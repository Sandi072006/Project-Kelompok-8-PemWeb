<?php 
if (isset($_SESSION['nama']) && $_SESSION['nama'] !== '') {
    $namaTampil = $_SESSION['nama'];
} elseif (isset($_SESSION['username']) && $_SESSION['username'] !== '') {
    $namaTampil = $_SESSION['username'];
} else {
    $namaTampil = 'User';
}

$hurufPertama = strtoupper(substr($namaTampil, 0, 1));
$roleTampil   = isset($_SESSION['role']) ? $_SESSION['role'] : '';
?>
<div class="topbar">
    <div class="topbar-left">
        <!-- Status removed -->
    </div>
    <div class="topbar-right">
        <span class="topbar-date"><?= date('l, d F Y') ?></span>
        <div class="topbar-divider"></div>
        <div class="topbar-user">
            <div class="topbar-avatar">
                <?= $hurufPertama ?>
            </div>
            <div class="topbar-user-info">
                <div class="topbar-user-name">
                    <?= htmlspecialchars($namaTampil) ?>
                </div>
                <div style="font-size:11px;color:#9ca3af;text-transform:capitalize;">
                    <?= htmlspecialchars($roleTampil) ?>
                </div>
            </div>
        </div>
    </div>
</div>
