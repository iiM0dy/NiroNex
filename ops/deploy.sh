#!/usr/bin/env bash
# Run as root on the existing NiroNex VPS deployment.
set -euo pipefail
umask 027

BASE=/var/www/nironex
REPOSITORY="$BASE/repository"
EXPECTED_REMOTE=https://github.com/iiM0dy/NiroNex.git
test "$(id -u)" = 0 || { echo 'Run this deployment command as root.'; exit 1; }
test -f "$BASE/shared/install.complete"
test -f "$BASE/shared/.env"
test -d "$BASE/shared/storage"
test -d "$REPOSITORY/.git"
for tool in git composer node npm php curl mysqldump gzip flock python3 sha256sum; do command -v "$tool" >/dev/null; done

exec 9>"$BASE/shared/github-deploy.lock"
flock -n 9 || { echo 'Another NiroNex deployment is already running.'; exit 1; }
run_git() { runuser -u nironex -- git -C "$REPOSITORY" "$@"; }
test "$(run_git remote get-url origin)" = "$EXPECTED_REMOTE"
test "$(run_git branch --show-current)" = main
test -z "$(run_git status --porcelain)" || { echo 'The VPS source checkout has local changes; resolve them before deploying.'; exit 1; }
SCRIPT_DIGEST="$(sha256sum "$REPOSITORY/ops/deploy.sh" | cut -d ' ' -f 1)"

echo '=== Pull NiroNex main ==='
run_git pull --ff-only origin main
if [ "$(sha256sum "$REPOSITORY/ops/deploy.sh" | cut -d ' ' -f 1)" != "$SCRIPT_DIGEST" ]; then
    echo 'Deployment script updated; restarting with the new version.'
    exec 9>&-
    exec bash "$REPOSITORY/ops/deploy.sh"
fi
COMMIT="$(run_git rev-parse HEAD)"
PREVIOUS="$(readlink -f "$BASE/current")"
case "$PREVIOUS" in "$BASE/releases/"*) ;; *) echo 'Unexpected current release path.'; exit 1;; esac
test -f "$PREVIOUS/artisan"
if [ -f "$PREVIOUS/.release-commit" ] && [ "$(cat "$PREVIOUS/.release-commit")" = "$COMMIT" ]; then
    echo "Already deployed: $COMMIT"
    exit 0
fi

STAMP="$(date -u +%Y%m%d-%H%M%S)"
RELEASE="$BASE/releases/$STAMP-${COMMIT:0:12}"
test ! -e "$RELEASE"
install -d -o nironex -g nironex -m 0755 "$RELEASE"
SWITCHED=0
PAUSED_TIMER=0

switch_release() {
    local target="$1" temporary
    temporary="$BASE/.current-$STAMP-$$"
    ln -s "$target" "$temporary"
    mv -Tf "$temporary" "$BASE/current"
}

finish() {
    local result=$?
    trap - EXIT
    if [ "$result" -ne 0 ]; then
        if [ "$SWITCHED" = 1 ]; then
            switch_release "$PREVIOUS"
            echo "Restored the previous application release: $PREVIOUS"
        fi
        echo "Deployment stopped; the prepared release is retained at $RELEASE"
        echo 'Database migrations are not automatically reversed. The database backup is retained for recovery.'
    fi
    if [ "$PAUSED_TIMER" = 1 ]; then systemctl start nironex-scheduler.timer; fi
    exit "$result"
}
trap finish EXIT

# Export only versioned application files; live data stays in shared storage.
run_git archive HEAD | runuser -u nironex -- bash -c 'umask 022; exec tar -x -C "$1" --exclude=storage' bash "$RELEASE"
test -f "$RELEASE/artisan"
test ! -e "$RELEASE/.env"
test ! -e "$RELEASE/storage"
runuser -u nironex -- ln -s "$BASE/shared/.env" "$RELEASE/.env"
runuser -u nironex -- ln -s "$BASE/shared/storage" "$RELEASE/storage"
install -d -o nironex -g nironex -m 0755 "$RELEASE/bootstrap/cache"
COMPOSER_BIN="$(command -v composer)"

echo '=== Install dependencies and build assets ==='
runuser -u nironex -- "$COMPOSER_BIN" --working-dir="$RELEASE" install --no-dev --prefer-dist --optimize-autoloader --no-interaction --no-scripts
runuser -u nironex -- "$COMPOSER_BIN" --working-dir="$RELEASE" check-platform-reqs --no-dev
runuser -u nironex -- bash -c 'umask 022; cd "$1" && npm ci --no-audit --no-fund && npm run build && php artisan package:discover --ansi' bash "$RELEASE"
test -f "$RELEASE/public/build/manifest.json"

# Nginx runs as www-data, while the application files belong to nironex.
# Normalize only public files. find does not follow the shared storage symlink,
# so private documents, database backups and .env retain their permissions.
find "$RELEASE/public" -type d -exec chmod 0755 {} +
find "$RELEASE/public" -type f -exec chmod 0644 {} +
echo '=== Verify Nginx can read public assets ==='
runuser -u www-data -- python3 - "$RELEASE/public" <<'PY'
import json
import os
import pathlib
import sys

public = pathlib.Path(sys.argv[1])
for required in ('index.php', 'build/manifest.json', 'assets/images/home/LOGO-NIRO-3.webp'):
    with (public / required).open('rb') as stream:
        stream.read(1)
manifest = json.loads((public / 'build/manifest.json').read_text())
for entry in manifest.values():
    for asset in [entry['file'], *entry.get('css', []), *entry.get('assets', [])]:
        with (public / 'build' / asset).open('rb') as stream:
            stream.read(1)
count = 0
for directory, directories, files in os.walk(public, followlinks=False):
    directories[:] = [name for name in directories if not (pathlib.Path(directory) / name).is_symlink()]
    for name in files:
        file = pathlib.Path(directory) / name
        if file.is_symlink():
            continue
        with file.open('rb') as stream:
            stream.read(1)
        count += 1
print(f'Nginx user can read {count} public files, including WebP images and built assets.')
PY

# Pause only NiroNex scheduled jobs and let any running invocation finish.
if systemctl is-active --quiet nironex-scheduler.timer; then
    systemctl stop nironex-scheduler.timer
    PAUSED_TIMER=1
fi
for attempt in $(seq 1 120); do
    if ! systemctl is-active --quiet nironex-scheduler.service; then break; fi
    sleep 1
done
if systemctl is-active --quiet nironex-scheduler.service; then
    echo 'A NiroNex scheduled job is still running. Retry deployment after it finishes.'
    exit 1
fi

echo '=== Back up NiroNex database and apply migrations ==='
install -d -o root -g root -m 0700 /var/backups/nironex
BACKUP="/var/backups/nironex/$STAMP-${COMMIT:0:12}.sql.gz"
(umask 077; mysqldump --single-transaction --no-tablespaces --databases nironex | gzip > "$BACKUP")
test -s "$BACKUP"
gzip -t "$BACKUP"
echo "Database backup: $BACKUP"
runuser -u nironex -- bash -c 'cd "$1" && php artisan migrate --force && php artisan storage:link && php artisan route:cache && php artisan view:cache' bash "$RELEASE"
# Existing code uses env() outside configuration files; do not config:cache.
test ! -f "$RELEASE/bootstrap/cache/config.php"
runuser -u nironex -- php "$RELEASE/ops/check-release.php"
printf '%s\n' "$COMMIT" > "$RELEASE/.release-commit"
chown nironex:nironex "$RELEASE/.release-commit"

echo '=== Activate the prepared release ==='
switch_release "$RELEASE"
SWITCHED=1
READY=0
for attempt in $(seq 1 15); do
    STATUS="$(curl -sS --connect-timeout 2 --max-time 10 --resolve nironex.com:443:127.0.0.1 -o /dev/null -w '%{http_code}' https://nironex.com/up 2>/dev/null || true)"
    if [ "$STATUS" = 200 ]; then READY=1; break; fi
    sleep 1
done
test "$READY" = 1 || { echo 'NiroNex health check failed.'; exit 1; }
for path in / /login /register; do
    STATUS="$(curl -sS --max-time 30 --resolve nironex.com:443:127.0.0.1 -o /dev/null -w '%{http_code}' "https://nironex.com$path")"
    echo "$path: HTTP $STATUS"
    test "$STATUS" = 200
done
echo "Deployed NiroNex: $COMMIT"
echo 'Website: https://nironex.com'
