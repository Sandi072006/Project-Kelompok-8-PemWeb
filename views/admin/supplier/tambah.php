<!DOCTYPE html>
<html lang="id">
<?php $pageTitle = 'Tambah Supplier — Admin StockMate'; require_once ROOT . '/views/layout/header.php'; ?>
<body>
<div class="layout">

    <?php $aktif = 'supplier'; require_once ROOT . '/views/layout/sidebar_admin.php'; ?>

    <main class="main-content">
        <?php require_once ROOT . '/views/layout/topbar.php'; ?>

        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <div class="breadcrumb">
                        <a href="<?= BASE_URL ?>/admin/supplier">Supplier</a>
                        <span>›</span>
                        <span>Tambah Supplier</span>
                    </div>
                    <h1>Tambah Supplier</h1>
                    <p>Tambahkan data supplier baru ke sistem</p>
                </div>
                <a href="<?= BASE_URL ?>/admin/supplier" class="btn gray">Kembali</a>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3>Form Tambah Supplier</h3>
                    <p>Isi semua field yang diperlukan</p>
                </div>
                <div class="card-body">
                    <form action="<?= BASE_URL ?>/admin/supplier/simpan" method="POST">
                        <div class="form-grid">
                            <div class="form-group">
                                <label>Nama Penanggung Jawab</label>
                                <input type="text" name="nama" placeholder="cth. Budi Santoso" required>
                            </div>
                            <div class="form-group">
                                <label>Nama Perusahaan</label>
                                <input type="text" name="perusahaan" placeholder="cth. PT Maju Bersama" required>
                            </div>
                            <div class="form-group">
                                <label>Nomor Telepon</label>
                                <input type="tel" name="telepon" placeholder="cth. 08123456789" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" placeholder="cth. supplier@email.com">
                            </div>
                            <div class="form-group">
                                <label>Kategori Produk</label>
                                <select name="kategori" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="Makanan">Makanan</option>
                                    <option value="Minuman">Minuman</option>
                                    <option value="Kebersihan">Kebersihan</option>
                                    <option value="Bumbu &amp; Rempah">Bumbu &amp; Rempah</option>
                                    <option value="Snack">Snack</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" required>
                                    <option value="aktif" selected>Aktif</option>
                                    <option value="nonaktif">Nonaktif</option>
                                </select>
                            </div>
                            <div class="form-group form-full">
                                <label>Alamat</label>
                                <input type="text" name="alamat" placeholder="cth. Jl. Sudirman No.45, Jakarta">
                            </div>
                            <div class="form-group form-full">
                                <label>Catatan <span class="label-optional">(opsional)</span></label>
                                <textarea rows="3" name="catatan" placeholder="Catatan tambahan mengenai supplier..."></textarea>
                            </div>
                        </div>
                        <div style="padding:20px 0 0;border-top:1px solid #e2e8f0;margin-top:20px;display:flex;justify-content:flex-end;gap:10px;">
                            <a href="<?= BASE_URL ?>/admin/supplier" class="btn-secondary">Batal</a>
                            <button type="submit" class="btn-primary">Simpan Supplier</button>
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