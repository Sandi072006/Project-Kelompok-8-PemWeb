<aside class="sidebar">
    <div class="logo">
        <h2>StockMate</h2>
        <p>Smart Supplier System</p>
    </div>
    <nav class="menu">
        <a href="<?= BASE_URL ?>/admin/dashboard" <?= ($aktif??'')==='dashboard' ? 'class="active"' : '' ?>>Dashboard</a>
        <a href="<?= BASE_URL ?>/admin/barang"    <?= ($aktif??'')==='barang'    ? 'class="active"' : '' ?>>Data Barang</a>
        <a href="<?= BASE_URL ?>/admin/supplier"  <?= ($aktif??'')==='supplier'  ? 'class="active"' : '' ?>>Supplier</a>
        <a href="<?= BASE_URL ?>/admin/pemasokan" <?= ($aktif??'')==='pemasokan' ? 'class="active"' : '' ?>>Pemasokan</a>
        <a href="<?= BASE_URL ?>/admin/laporan"   <?= ($aktif??'')==='laporan'   ? 'class="active"' : '' ?>>Laporan</a>
    </nav>
    <div class="user-box">
        <p>Logged in as</p>
        <h4><?= htmlspecialchars($_SESSION['nama'] ?? 'Admin') ?></h4>
        <span><?= ucfirst($_SESSION['role'] ?? 'admin') ?></span>
    </div>
    <a href="<?= BASE_URL ?>/logout" class="logout">Logout</a>
</aside>