<aside class="sidebar">
    <div class="logo">
        <h2>StockMate</h2>
        <p>Smart Supplier System</p>
    </div>
    <nav class="menu">
        <a href="<?= BASE_URL ?>/"        <?= ($aktif??'')==='dashboard' ? 'class="active"' : '' ?>>Dashboard</a>
        <a href="<?= BASE_URL ?>/barang"  <?= ($aktif??'')==='barang'    ? 'class="active"' : '' ?>>Data Barang</a>
        <a href="<?= BASE_URL ?>/supplier"<?= ($aktif??'')==='supplier'  ? 'class="active"' : '' ?>>Supplier</a>
        <a href="<?= BASE_URL ?>/pemasokan" <?= ($aktif??'')==='pemasokan' ? 'class="active"' : '' ?>>Pemasokan</a>
    </nav>
    <div class="user-box">
        <p>Logged in as</p>
        <h4><?= htmlspecialchars($_SESSION['nama'] ?? 'Petugas') ?></h4>
        <span>Petugas</span>
    </div>
    <a href="<?= BASE_URL ?>/logout" class="logout">Logout</a>
</aside>