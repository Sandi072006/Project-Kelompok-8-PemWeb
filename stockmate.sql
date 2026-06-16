-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 15, 2026 at 09:55 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stockmate`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int NOT NULL,
  `kode` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_barang` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `kategori` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `merek` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `supplier_id` int DEFAULT NULL,
  `stok` int NOT NULL DEFAULT '0',
  `satuan` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `stok_minimum` int NOT NULL DEFAULT '0',
  `harga_beli` decimal(10,2) NOT NULL DEFAULT '0.00',
  `harga_jual` decimal(10,2) NOT NULL DEFAULT '0.00',
  `deskripsi` text COLLATE utf8mb4_general_ci,
  `status` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_aktif` enum('aktif','nonaktif') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `kode`, `nama_barang`, `kategori`, `merek`, `supplier_id`, `stok`, `satuan`, `stok_minimum`, `harga_beli`, `harga_jual`, `deskripsi`, `status`, `status_aktif`, `created_at`) VALUES
(1, 'BRG-001', 'Laptop Asus Vivobook', 'Elektronik', NULL, NULL, 15, NULL, 0, '7500000.00', '8500000.00', NULL, NULL, 'aktif', '2026-06-08 06:53:40'),
(2, 'BRG-002', 'Mouse Logitech M220', 'Aksesoris', NULL, NULL, 50, NULL, 0, '150000.00', '200000.00', NULL, NULL, 'aktif', '2026-06-08 06:53:40'),
(3, 'BRG-003', 'Keyboard Mechanical', 'Aksesoris', NULL, NULL, 30, NULL, 0, '450000.00', '600000.00', NULL, NULL, 'aktif', '2026-06-08 06:53:40'),
(4, 'BRG-004', 'Monitor LG 24 Inch', 'Elektronik', NULL, NULL, 20, NULL, 0, '2200000.00', '2500000.00', NULL, NULL, 'aktif', '2026-06-08 06:53:40'),
(5, 'BRG-005', 'Flashdisk 32GB', 'Penyimpanan', NULL, NULL, 40, NULL, 0, '85000.00', '120000.00', NULL, NULL, 'aktif', '2026-06-08 06:53:40'),
(6, 'BRG006', 'Susu Kaleng', 'Minuman', 'Susu Bendera', 3, 0, 'dus', 25, '100000.00', '110000.00', 'Datang dengan keadaan baik', 'Habis', 'nonaktif', '2026-06-15 01:55:11'),
(7, 'BRG-007', 'Minyak Goreng', 'Bumbu', 'Bimo Oil', 2, 20, 'dus', 20, '100000.00', '115000.00', 'Datang dengan keadaan baik.', 'Hampir habis', 'aktif', '2026-06-15 02:18:52'),
(8, 'BRG-008', 'Roti Aoka', 'Makanan', 'Aoka', 5, 50, 'dus', 15, '50000.00', '57000.00', 'Produk dari perusahaan RotiKu', 'Tersedia', 'aktif', '2026-06-15 09:34:32');

-- --------------------------------------------------------

--
-- Table structure for table `pemasokan`
--

CREATE TABLE `pemasokan` (
  `id` int NOT NULL,
  `kode` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `barang_id` int NOT NULL,
  `supplier_id` int NOT NULL,
  `jumlah` int NOT NULL,
  `tanggal_pemasokan` date NOT NULL,
  `harga_beli` decimal(10,2) NOT NULL DEFAULT '0.00',
  `catatan` text COLLATE utf8mb4_general_ci,
  `user_id` int DEFAULT NULL,
  `status` enum('aktif','dibatalkan') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'aktif',
  `cancelled_by` int DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pemasokan`
--

INSERT INTO `pemasokan` (`id`, `kode`, `barang_id`, `supplier_id`, `jumlah`, `tanggal_pemasokan`, `harga_beli`, `catatan`, `user_id`, `status`, `cancelled_by`, `cancelled_at`, `created_at`) VALUES
(1, 'PMK-001', 1, 1, 10, '2026-06-01', '0.00', NULL, NULL, 'aktif', NULL, NULL, '2026-06-08 06:53:40'),
(2, 'PMK-002', 2, 2, 25, '2026-06-02', '0.00', NULL, NULL, 'aktif', NULL, NULL, '2026-06-08 06:53:40'),
(3, 'PMK-003', 3, 1, 15, '2026-06-03', '0.00', NULL, NULL, 'aktif', NULL, NULL, '2026-06-08 06:53:40'),
(4, 'PMK-004', 4, 3, 8, '2026-06-04', '0.00', NULL, NULL, 'aktif', NULL, NULL, '2026-06-08 06:53:40'),
(5, 'PMK-005', 5, 4, 20, '2026-06-05', '0.00', NULL, NULL, 'aktif', NULL, NULL, '2026-06-08 06:53:40'),
(6, 'PMK-006', 7, 2, 20, '2026-06-15', '100000.00', 'Barang masuk dengan keadaan yang baik.', 2, 'aktif', NULL, NULL, '2026-06-15 02:48:28'),
(7, 'PMK-007', 7, 2, 5, '2026-06-15', '100000.00', 'Datang dengan keadaan baik.', 2, 'aktif', NULL, NULL, '2026-06-15 02:49:16'),
(8, 'SO-008', 8, 5, 50, '2026-06-15', '50000.00', 'Roti Aoka datang dengan keadaan yang baik.', 2, 'aktif', NULL, NULL, '2026-06-15 09:35:47');

-- --------------------------------------------------------

--
-- Table structure for table `stock_out`
--

CREATE TABLE `stock_out` (
  `id` int NOT NULL,
  `kode` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `barang_id` int NOT NULL,
  `jumlah` int NOT NULL,
  `tanggal_keluar` date NOT NULL,
  `tujuan` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `catatan` text COLLATE utf8mb4_general_ci,
  `keterangan` text COLLATE utf8mb4_general_ci,
  `user_id` int DEFAULT NULL,
  `status` enum('aktif','dibatalkan') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'aktif',
  `cancelled_by` int DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock_out`
--

INSERT INTO `stock_out` (`id`, `kode`, `barang_id`, `jumlah`, `tanggal_keluar`, `tujuan`, `catatan`, `keterangan`, `user_id`, `status`, `cancelled_by`, `cancelled_at`, `created_at`) VALUES
(1, 'SO-001', 1, 2, '2026-06-06', NULL, NULL, 'Penjualan ke pelanggan', NULL, 'aktif', NULL, NULL, '2026-06-08 06:53:40'),
(2, 'SO-002', 2, 5, '2026-06-06', NULL, NULL, 'Penjualan toko cabang', NULL, 'aktif', NULL, NULL, '2026-06-08 06:53:40'),
(3, 'SO-003', 3, 3, '2026-06-07', NULL, NULL, 'Keperluan kantor', NULL, 'aktif', NULL, NULL, '2026-06-08 06:53:40'),
(4, 'SO-004', 4, 1, '2026-06-07', NULL, NULL, 'Penjualan pelanggan', NULL, 'aktif', NULL, NULL, '2026-06-08 06:53:40'),
(5, 'SO-005', 5, 10, '2026-06-08', NULL, NULL, 'Promosi dan hadiah', NULL, 'aktif', NULL, NULL, '2026-06-08 06:53:40'),
(6, 'SO-006', 7, 3, '2026-06-15', 'Penjualan', 'Pembeli atas nama Arkan Afarel', 'Penjualan - Pembeli atas nama Arkan Afarel', 2, 'aktif', NULL, NULL, '2026-06-15 02:50:32'),
(7, 'SO-007', 7, 2, '2026-06-15', 'Penjualan', 'Pembeli atas nama Sandi Zuliansyah', 'Penjualan - Pembeli atas nama Sandi Zuliansyah', 2, 'aktif', NULL, NULL, '2026-06-15 03:20:00');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int NOT NULL,
  `nama_supplier` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kontak` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_general_ci,
  `kategori` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('aktif','nonaktif') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'aktif',
  `catatan` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `nama_supplier`, `nama`, `kontak`, `email`, `alamat`, `kategori`, `status`, `catatan`, `created_at`) VALUES
(1, 'PT Sumber Teknologi', NULL, '081234567890', NULL, 'Jl. Soekarno Hatta No. 12, Bandar Lampung', NULL, 'aktif', NULL, '2026-06-08 06:53:40'),
(2, 'CV Maju Bersama', NULL, '082345678901', NULL, 'Jl. ZA Pagar Alam No. 45, Bandar Lampung', NULL, 'aktif', NULL, '2026-06-08 06:53:40'),
(3, 'PT Digital Nusantara', NULL, '083456789012', NULL, 'Jl. Diponegoro No. 20, Jakarta', NULL, 'aktif', NULL, '2026-06-08 06:53:40'),
(4, 'CV Cahaya Komputer', NULL, '084567890123', NULL, 'Jl. Ahmad Yani No. 5, Palembang', NULL, 'aktif', NULL, '2026-06-08 06:53:40'),
(5, 'RotiKu', 'Arkan Afarel', '085841800408', 'arkanafarel811@gmail.com', 'JL ADIPATI VI', 'Makanan', 'aktif', 'Perusahaan yang memberikan supply produk roti', '2026-06-15 03:57:18');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('admin','petugas') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'petugas',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama`, `role`, `created_at`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin', '2026-06-08 06:53:40'),
(2, 'petugas', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Petugas', 'petugas', '2026-06-08 06:53:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode` (`kode`);

--
-- Indexes for table `pemasokan`
--
ALTER TABLE `pemasokan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barang_id` (`barang_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `stock_out`
--
ALTER TABLE `stock_out`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barang_id` (`barang_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pemasokan`
--
ALTER TABLE `pemasokan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `stock_out`
--
ALTER TABLE `stock_out`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pemasokan`
--
ALTER TABLE `pemasokan`
  ADD CONSTRAINT `fk_pemasokan_barang` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_pemasokan_supplier` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_out`
--
ALTER TABLE `stock_out`
  ADD CONSTRAINT `fk_stockout_barang` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
