<div class="topbar">
    <div class="topbar-left">
        <span class="status-dot"></span>
        <span class="status-label">System Active</span>
    </div>
    <div class="topbar-right">
        <span class="topbar-date"><?= date('l, d F Y') ?></span>
        <div class="topbar-divider"></div>
        <div class="topbar-user">
            <div class="topbar-avatar">
                <?= strtoupper(substr($_SESSION['nama'] ?? $_SESSION['username'] ?? 'U', 0, 1)) ?>
            </div>
            <div class="topbar-user-info">
                <div class="topbar-user-name">
                    <?= htmlspecialchars($_SESSION['nama'] ?? $_SESSION['username'] ?? 'User') ?>
                </div>
                <div style="font-size:11px;color:#9ca3af;text-transform:capitalize;">
                    <?= htmlspecialchars($_SESSION['role'] ?? '') ?>
                </div>
            </div>
        </div>
    </div>
</div>