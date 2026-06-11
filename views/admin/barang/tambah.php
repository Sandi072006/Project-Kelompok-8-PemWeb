<!DOCTYPE html>
<html lang="id">
<?php $pageTitle = 'Tambah Barang - Admin StockMate'; require_once ROOT . '/views/layout/header.php'; ?>
<body>
<div class="layout">

    <?php $aktif = 'barang'; require_once ROOT . '/views/layout/sidebar_admin.php'; ?>

    <main class="main-content">
        <?php require_once ROOT . '/views/layout/topbar.php'; ?>

        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <div class="breadcrumb">
                        <a href="<?= BASE_URL ?>/admin/barang">Data Barang</a>
                        <span>&rsaquo;</span>
                        <span>Tambah Barang</span>
                    </div>
                    <h1>Tambah Barang</h1>
                    <p>Tambahkan data barang baru ke sistem</p>
                </div>
                <a href="<?= BASE_URL ?>/admin/barang" class="btn gray">Kembali</a>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3>Form Tambah Barang</h3>
                    <p>Isi semua field yang diperlukan</p>
                </div>
                <div class="card-body">
                    <form action="<?= BASE_URL ?>/admin/barang/simpan" method="POST">
                        <div class="form-grid">
                            <div class="form-group">
                                <label>Kode Barang</label>
                                <input type="text" name="kode" placeholder="cth. BRG001" required>
                            </div>
                            <div class="form-group">
                                <label>Nama Barang</label>
                                <input type="text" name="nama" placeholder="cth. Beras Premium 5kg" required>
                            </div>
                            <div class="form-group">
                                <label>Kategori</label>
                                <select name="kategori" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <?php foreach (['Makanan','Minuman','Kebersihan','Bumbu','Snack'] as $kat): ?>
                                        <option value="<?= $kat ?>"><?= $kat ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Merek</label>
                                <input type="text" name="merek" placeholder="cth. Cap Makmur">
                            </div>
                            <div class="form-group">
                                <label>Supplier</label>
                                <select name="supplier_id" required>
                                    <option value="">-- Pilih Supplier --</option>
                                    <?php if (!empty($data['suppliers'])): ?>
                                        <?php foreach ($data['suppliers'] as $s): ?>
                                            <option value="<?= (int)$s['id'] ?>"><?= htmlspecialchars($s['perusahaan']) ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Stok Awal</label>
                                <input type="number" name="stok" value="0" min="0" required>
                            </div>
                            <div class="form-group">
                                <label>Satuan</label>
                                <input type="text" name="satuan" placeholder="cth. pcs, dus, kg">
                            </div>
                            <div class="form-group">
                                <label>Stok Minimum</label>
                                <input type="number" name="stok_minimum" value="0" min="0">
                            </div>
                            <div class="form-group">
                                <label>Harga Beli</label>
                                <input type="number" name="harga_beli" value="0" min="0" required>
                            </div>
                            <div class="form-group">
                                <label>Harga Jual</label>
                                <input type="number" name="harga_jual" value="0" min="0" required>
                            </div>
                            <div class="form-group form-full">
                                <label>Deskripsi <span class="label-optional">(opsional)</span></label>
                                <textarea rows="3" name="deskripsi" placeholder="Keterangan tambahan mengenai barang..."></textarea>
                            </div>
                        </div>
                        <div style="padding:20px 0 0;border-top:1px solid #e2e8f0;margin-top:20px;display:flex;justify-content:flex-end;gap:10px;">
                            <a href="<?= BASE_URL ?>/admin/barang" class="btn-secondary">Batal</a>
                            <button type="submit" class="btn-primary">Simpan Barang</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>
<?php require_once ROOT . '/views/layout/footer.php'; ?>
</body>
</html>
