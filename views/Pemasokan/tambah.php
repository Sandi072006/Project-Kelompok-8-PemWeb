<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pemasokan</title>

    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>

<body>

<div class="layout">

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <div class="logo">
            <h2>StockMate</h2>
            <p>Smart Supplier System</p>
        </div>

        <nav class="menu">

            <a href="<?= BASE_URL ?>/admin/dashboard">
                Dashboard
            </a>

            <a href="<?= BASE_URL ?>/admin/barang">
                Data Barang
            </a>

            <a href="<?= BASE_URL ?>/admin/supplier">
                Supplier
            </a>

            <a href="<?= BASE_URL ?>/admin/pemasokan" class="active">
                Pemasokan
            </a>

            <a href="<?= BASE_URL ?>/admin/laporan">
                Laporan
            </a>

        </nav>

        <div class="user-box">
            <p>Logged in as</p>
            <h4>Petugas Gudang</h4>
            <span>Petugas</span>
        </div>

        <a href="<?= BASE_URL ?>/logout" class="logout">
            Logout
        </a>

    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">

        <!-- TOPBAR -->
        <div class="topbar">

            <div class="topbar-left">
                <span class="status-dot"></span>
                <span class="status-label">System Active</span>
            </div>

            <div class="topbar-right">

                <span class="topbar-date">
                    <?= date('d F Y') ?>
                </span>

                <div class="topbar-divider"></div>

                <div class="topbar-user">

                    <div class="topbar-avatar">P</div>

                    <div class="topbar-user-info">
                        <div class="topbar-user-name">
                            Petugas Gudang
                        </div>
                    </div>

                </div>

            </div>

        </div>

        <!-- CONTENT -->
        <div class="content">

            <!-- PAGE HEADER -->
            <div class="page-header">

                <div class="page-title">

                    <div class="breadcrumb">

                        <a href="<?= BASE_URL ?>/admin/pemasokan">
                            Pemasokan
                        </a>

                        <span>›</span>

                        <span>Tambah Pemasokan</span>

                    </div>

                    <h1>Tambah Pemasokan</h1>

                    <p>
                        Catat transaksi pemasokan barang baru
                    </p>

                </div>

                <a href="<?= BASE_URL ?>/admin/pemasokan"
                   class="btn gray">
                    Kembali
                </a>

            </div>

            <!-- CARD -->
            <div class="card">

                <div class="card-header">
                    <h3>Form Tambah Pemasokan</h3>
                    <p>Isi semua field yang diperlukan</p>
                </div>

                <div class="card-body">

                    <form action="<?= BASE_URL ?>/admin/pemasokan/simpan"
                          method="POST">

                        <div class="form-grid">

                            <!-- TANGGAL -->
                            <div class="form-group">

                                <label for="tanggal">
                                    Tanggal Pemasokan
                                </label>

                                <input
                                    type="date"
                                    id="tanggal"
                                    name="tanggal"
                                    required
                                >

                            </div>

                            <!-- SUPPLIER -->
                            <div class="form-group">

                                <label for="supplier">
                                    Supplier
                                </label>

                                <select
                                    id="supplier"
                                    name="supplier_id"
                                    required
                                >

                                    <option value="">
                                        -- Pilih Supplier --
                                    </option>

                                    <?php foreach ($supplier as $s): ?>

                                        <option value="<?= $s['id_supplier']; ?>">
                                            <?= $s['nama_perusahaan']; ?>
                                        </option>

                                    <?php endforeach; ?>

                                </select>

                            </div>

                            <!-- BARANG -->
                            <div class="form-group">

                                <label for="barang">
                                    Barang
                                </label>

                                <select
                                    id="barang"
                                    name="barang_id"
                                    required
                                >

                                    <option value="">
                                        -- Pilih Barang --
                                    </option>

                                    <?php foreach ($barang as $b): ?>

                                        <option value="<?= $b['id_barang']; ?>">
                                            <?= $b['nama_barang']; ?>
                                        </option>

                                    <?php endforeach; ?>

                                </select>

                            </div>

                            <!-- JUMLAH -->
                            <div class="form-group">

                                <label for="jumlah">
                                    Jumlah
                                </label>

                                <input
                                    type="number"
                                    id="jumlah"
                                    name="jumlah"
                                    placeholder="cth. 100"
                                    min="1"
                                    required
                                >

                            </div>

                            <!-- HARGA -->
                            <div class="form-group">

                                <label for="harga">
                                    Harga Beli Satuan
                                </label>

                                <input
                                    type="number"
                                    id="harga"
                                    name="harga_beli"
                                    placeholder="cth. 65000"
                                    min="0"
                                    required
                                >

                            </div>

                            <!-- PETUGAS -->
                            <div class="form-group">

                                <label for="petugas">
                                    Petugas Pencatat
                                </label>

                                <input
                                    type="text"
                                    id="petugas"
                                    name="petugas"
                                    placeholder="Nama Petugas"
                                    required
                                >

                            </div>

                            <!-- CATATAN -->
                            <div class="form-group form-full">

                                <label for="catatan">
                                    Catatan
                                    <span class="label-optional">
                                        (opsional)
                                    </span>
                                </label>

                                <textarea
                                    id="catatan"
                                    name="catatan"
                                    rows="3"
                                    placeholder="Keterangan tambahan mengenai pemasokan ini..."
                                ></textarea>

                            </div>

                        </div>

                        <!-- RINGKASAN -->
                        <div style="
                            background:#f8fafc;
                            border:1px solid #e2e8f0;
                            border-radius:10px;
                            padding:16px 20px;
                            margin-top:8px;
                        ">

                            <div style="
                                font-size:12px;
                                font-weight:700;
                                color:#9ca3af;
                                text-transform:uppercase;
                                letter-spacing:0.5px;
                                margin-bottom:8px;
                            ">
                                Ringkasan
                            </div>

                            <div style="
                                display:flex;
                                justify-content:space-between;
                                font-size:13.5px;
                                color:#374151;
                            ">

                                <span>Total Harga</span>

                                <span style="
                                    font-weight:700;
                                    color:#0d1117;
                                ">
                                    Akan dihitung otomatis
                                </span>

                            </div>

                        </div>

                        <!-- BUTTON -->
                        <div style="
                            padding:20px 0 0;
                            border-top:1px solid #e2e8f0;
                            margin-top:20px;
                            display:flex;
                            justify-content:flex-end;
                            gap:10px;
                        ">

                            <a href="<?= BASE_URL ?>/admin/pemasokan"
                               class="btn-secondary">
                                Batal
                            </a>

                            <button type="submit"
                                    class="btn-primary">
                                Simpan Pemasokan
                            </button>

                        </div>

                    </form>

                </div>
            </div>

        </div>

    </main>

</div>

<footer>
    <p>&copy; <?= date('Y') ?> StockMate</p>
</footer>

</body>
</html>
