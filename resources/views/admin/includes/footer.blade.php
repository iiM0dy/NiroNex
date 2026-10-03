<footer class="lira-admin-footer">
    <div class="container-xxl">
        <div class="lira-admin-footer-inner">
            <div class="lira-admin-footer-copy">
                <span class="lira-admin-footer-brand">{{ env('APP_NAME') }}</span>
                <span class="lira-admin-footer-sep">·</span>
                <span>© {{ date('Y') }} جميع الحقوق محفوظة</span>
            </div>
            <div class="lira-admin-footer-meta">
                <span class="lira-admin-footer-chip">
                    <i class="fa-solid fa-shield-halved"></i>
                    Admin Panel
                </span>
            </div>
        </div>
    </div>
</footer>

<style>
    .lira-admin-footer {
        padding: 18px 28px;
        border-top: 1px solid var(--lira-border);
        background: rgba(7, 9, 13, 0.5);
    }

    .lira-admin-footer-inner {
        max-width: 1480px;
        margin-inline: auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        flex-wrap: wrap;
    }

    .lira-admin-footer-copy {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--lira-text-muted);
        font-size: 12px;
        font-weight: 600;
    }

    .lira-admin-footer-brand {
        color: var(--lira-accent);
        font-weight: 800;
    }

    .lira-admin-footer-sep {
        opacity: 0.4;
    }

    .lira-admin-footer-meta {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .lira-admin-footer-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        min-height: 30px;
        padding: 0 10px;
        border-radius: 999px;
        background: rgba(0, 230, 167, 0.08);
        border: 1px solid rgba(0, 230, 167, 0.14);
        color: var(--lira-accent);
        font-size: 11px;
        font-weight: 700;
    }
</style>

