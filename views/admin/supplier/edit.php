<!DOCTYPE html>
<html lang="id">
<?php $pageTitle = 'Edit Supplier — Admin StockMate'; require_once ROOT . '/views/layout/header.php'; ?>
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
                        <span>Edit Supplier</span>
                    </div>
                    <h1>Edit Supplier</h1>
                    <p>Ubah data supplier yang sudah ada</p>
                </div>
                <a href="<?= BASE_URL ?>/admin/supplier" class="btn gray">Kembali</a>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3>Form Edit Supplier</h3>
                    <p>Field sudah terisi otomatis dari data yang dipilih</p>
                </div>
                <div class="card-body">
                    <form action="<?= BASE_URL ?>/admin/supplier/update" method="POST">
                        <input type="hidden" name="id" value="<?= (int)($data['supplier']['id'] ?? 0) ?>">
                        <div class="form-grid">
                            <div class="form-group">
                                <label>Nama Penanggung Jawab</label>
                                <input type="text" name="nama" value="<?= htmlspecialchars($data['supplier']['nama'] ?? '') ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Nama Perusahaan</label>
                                <input type="text" name="perusahaan" value="<?= htmlspecialchars($data['supplier']['perusahaan'] ?? '') ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Nomor Telepon</label>
                                <input type="tel" name="telepon" value="<?= htmlspecialchars($data['supplier']['telepon'] ?? '') ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" value="<?= htmlspecialchars($data['supplier']['email'] ?? '') ?>">
                            </div>
                            <div class="form-group">
                                <label>Kategori Produk</label>
                                <select name="kategori">
                                    <option value="">-- Pilih Kategori --</option>
                                    <?php foreach (['Makanan','Minuman','Kebersihan','Bumbu & Rempah','Snack','Lainnya'] as $kat): ?>
                                        <option value="<?= $kat ?>" <?= ($data['supplier']['kategori'] ?? '') === $kat ? 'selected' : '' ?>><?= htmlspecialchars($kat) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status">
                                    <option value="aktif"    <?= ($data['supplier']['status'] ?? '') === 'aktif'    ? 'selected' : '' ?>>Aktif</option>
                                    <option value="nonaktif" <?= ($data['supplier']['status'] ?? '') === 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                                </select>
                            </div>
                            <div class="form-group form-full">
                                <label>Alamat</label>
                                <input type="text" name="alamat" value="<?= htmlspecialchars($data['supplier']['alamat'] ?? '') ?>">
                            </div>
                            <div class="form-group form-full">
                                <label>Catatan <span class="label-optional">(opsional)</span></label>
                                <textarea rows="3" name="catatan"><?= htmlspecialchars($data['supplier']['catatan'] ?? '') ?></textarea>
                            </div>
                        </div>
                        <div style="padding:20px 0 0;border-top:1px solid #e2e8f0;margin-top:20px;display:flex;justify-content:flex-end;gap:10px;">
                            <a href="<?= BASE_URL ?>/admin/supplier" class="btn-secondary">Batal</a>
                            <button type="submit" class="btn-primary">Simpan Perubahan</button>
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