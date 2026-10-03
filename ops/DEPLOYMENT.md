# NiroNex updates

Repository: https://github.com/iiM0dy/NiroNex.git

## Push changes from Windows

Run in the local application directory:

```powershell
cd E:\nironex.com\nironex.com
git status
git add .
git commit -m "Describe your change"
git push origin main
```

## Pull and deploy on the VPS

After the one-time GitHub connection, run as root:

```bash
bash /var/www/nironex/repository/ops/deploy.sh
```

The command pulls `main` with `--ff-only`, reloads itself if its script changed,
builds a separate release, verifies public files are readable by the Nginx user, backs up
the NiroNex database, applies pending Laravel migrations, checks the application,
and atomically switches `/var/www/nironex/current`. A failed activation restores
the previous code release. Database migrations are not automatically reversed;
their backups are private under `/var/backups/nironex`.

Runtime secrets and uploads remain in `/var/www/nironex/shared`; Git updates do
not replace them or reimport the local database. Changes to database structure
must use Laravel migrations. Local database edits are not pushed to GitHub.

The deployment only pauses the NiroNex scheduler. It does not restart the other
sites, replace their configuration, or delete old releases. Its PHP pool and
Nginx configuration already use the current release's real path.

Keep Laravel configuration uncached until the existing application calls to
`env()` outside configuration files have been moved into configuration files.

The first commit is a clean snapshot. The previous project's Git history is kept
locally under `legacy/nironex-history` and is not pushed to GitHub.
