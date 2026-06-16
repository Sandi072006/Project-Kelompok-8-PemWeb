<?php 
$menuAktif = isset($aktif) ? $aktif : ''; 

$namaPengguna = isset($_SESSION['nama']) ? $_SESSION['nama'] : 'Petugas';
?>
<aside class="sidebar">
    <div class="logo">
        <h2>StockMate</h2>
        <p>Smart Supplier System</p>
    </div>
    <nav class="menu">
        <a href="<?= BASE_URL ?>/"        <?php if($menuAktif === 'dashboard') echo 'class="active"'; ?>>Dashboard</a>
        <a href="<?= BASE_URL ?>/barang"  <?php if($menuAktif === 'barang') echo 'class="active"'; ?>>Data Barang</a>
        <a href="<?= BASE_URL ?>/supplier"<?php if($menuAktif === 'supplier') echo 'class="active"'; ?>>Supplier</a>
        <a href="<?= BASE_URL ?>/pemasokan" <?php if($menuAktif === 'pemasokan') echo 'class="active"'; ?>>Barang Masuk</a>
    </nav>
    <div class="user-box">
        <p>Logged in as</p>
        <h4><?= htmlspecialchars($namaPengguna) ?></h4>
        <span>Petugas</span>
    </div>
    <a href="<?= BASE_URL ?>/logout" class="logout">Logout</a>
</aside>
