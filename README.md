# StockMate

**Smart Supplier System | Sistem Manajemen Stok Barang Berbasis Web**

## Description

StockMate adalah aplikasi manajemen stok barang berbasis web yang digunakan untuk membantu proses pengelolaan data barang, supplier, barang masuk, barang keluar, serta laporan stok. Sistem ini dirancang untuk memudahkan admin dan petugas gudang dalam memantau ketersediaan barang, mencatat pemasokan, mencatat barang keluar, serta mengetahui barang dengan stok rendah.

Sistem ini cocok digunakan untuk pengelolaan stok sederhana pada gudang, toko, minimarket, atau kebutuhan inventaris internal.

## Features

* Login dengan role Admin dan Petugas
* Dashboard ringkasan data stok
* Manajemen data barang
* Manajemen data supplier
* Pencatatan barang masuk / pemasokan
* Pencatatan barang keluar / stock out
* Deteksi stok rendah berdasarkan stok minimum
* Detail barang lengkap dengan informasi stok
* Detail supplier dan riwayat pemasokan
* Detail transaksi pemasokan
* Pembatalan transaksi barang masuk dan barang keluar
* Laporan data stok, barang masuk, dan barang keluar

## User Roles

### Admin

Admin memiliki hak akses untuk mengelola data utama dan memantau laporan sistem.

Fitur Admin:

* Mengelola data barang
* Mengelola data supplier
* Melihat data pemasokan
* Melihat data barang keluar
* Melihat laporan
* Melihat dashboard sistem

### Petugas

Petugas memiliki hak akses untuk melakukan aktivitas operasional gudang.

Fitur Petugas:

* Melihat data barang
* Melihat data supplier
* Mencatat barang masuk
* Mencatat barang keluar
* Membatalkan transaksi barang masuk
* Membatalkan transaksi barang keluar
* Melihat dashboard petugas

## Tech Stack

* PHP Native
* MySQL
* HTML
* CSS
* Laragon 
* phpMyAdmin

## Folder Structure

```txt
stockmate/
├── assets/
│   ├── css/
│   └── img/
├── config/
├── controllers/
├── helpers/
├── models/
├── views/
│   ├── admin/
│   │   ├── barang/
│   │   ├── dashboard/
│   │   ├── laporan/
│   │   ├── pemasokan/
│   │   ├── stock_out/
│   │   └── supplier/
│   ├── auth/
│   ├── barang/
│   ├── dashboard/
│   ├── layout/
│   ├── pemasokan/
│   └── supplier/
├── index.php
├── stockmate.sql
└── README.md
```

## Installation

### 1. Clone Repository

```bash
git clone https://github.com/Sandi072006/Project-Kelompok-8-PemWeb.git
```

### 2. Masuk ke Folder Project

```bash
cd Project-Kelompok-8-PemWeb
```

### 3. Pindahkan Project ke Folder Web Server

Jika menggunakan Laragon, letakkan folder project di:

```txt
C:\laragon\www\Project-Kelompok-8-PemWeb
```

### 4. Buat Database

Buka phpMyAdmin, lalu buat database baru dengan nama:

```txt
stockmate
```

### 5. Import Database

Import file database:

```txt
stockmate.sql
```

melalui phpMyAdmin.

### 6. Jalankan Project

Buka browser dan akses:

```txt
http://localhost/stockmate
```

atau sesuai nama folder project:

```txt
http://localhost/hayu
```

## Default Account

### Admin

```txt
Username: admin
Password: admin123
```

### Petugas

```txt
Username: petugas
Password: petugas123
```

## Main Business Flow

### Barang Masuk / Pemasokan

1. Petugas mencatat barang masuk.
2. Sistem menyimpan transaksi pemasokan.
3. Stok barang otomatis bertambah.
4. Transaksi tampil pada riwayat pemasokan.
5. Jika transaksi dibatalkan, stok akan dikurangi kembali.

### Barang Keluar / Stock Out

1. Petugas memilih barang yang akan dikurangi stoknya.
2. Petugas mengisi jumlah barang keluar.
3. Sistem memvalidasi stok tersedia.
4. Jika stok cukup, sistem menyimpan transaksi stock out.
5. Stok barang otomatis berkurang.
6. Jika transaksi dibatalkan, stok akan dikembalikan.

### Stok Rendah

Barang akan masuk kategori stok rendah jika:

```txt
stok saat ini <= stok minimum
```

Contoh:

```txt
Stok saat ini: 20
Stok minimum: 20
Status: Stok Rendah
```

## Database Tables

Tabel utama yang digunakan:

* users
* barang
* supplier
* pemasokan
* stock_out
