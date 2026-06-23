-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2026 at 06:56 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_kasir`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`, `nama_lengkap`, `created_at`) VALUES
(1, 'admin', 'admin123', 'Neng Isan Gladiator\r\n', '2026-06-20 04:42:36');

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL,
  `nama_barang` varchar(100) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `id_supplier` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_barang`, `harga`, `stok`, `id_kategori`, `id_supplier`) VALUES
(1, 'kopi kapal selam', 3000, 11, 1, 1),
(2, 'Foundation', 30000, 18, 5, 2),
(3, 'Happytos', 12000, 30, 3, 1),
(5, 'sabun surga', 30000, 57, 4, 2),
(6, 'Wardah Lip Cream', 45000, 27, 5, 2),
(7, 'Teh Botol', 7000, 99, 2, 5),
(8, 'Floridina', 30000, 38, 2, 5),
(9, 'Bodrek', 15000, 43, 7, 6),
(10, 'Entrostop', 9000, 19, 7, 6),
(11, 'Vitamin C', 7000, 25, 7, 1),
(12, 'moring SZ', 9000, 90, 1, 4),
(13, 'Mie Indomie Goreng Aceh', 89000, 89, 8, 6),
(14, 'susu ultramilk', 3000, 20, 2, 7),
(15, 'susu indomilk', 3000, 1, 2, 7),
(18, 'mie indomie rendang', 3000, 13, 1, 4),
(20, 'puding coklat pak hambali', 1000000, -3, 9, 7),
(21, 'Sabun Anggrek Ponorogo', 2000, 5, 4, 2),
(22, 'Djarum Superman', 28000, 12, 9, 6),
(23, 'sate maranggi', 20000, 12, 1, 5),
(24, 'anggrek mekar pontianak', 15000, 13, 5, 3);

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id_detail` int(11) NOT NULL,
  `id_transaksi` int(11) DEFAULT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id_detail`, `id_transaksi`, `id_barang`, `jumlah`, `subtotal`) VALUES
(1, 1, 2, 1, 30000.00),
(2, 1, 3, 1, 12000.00),
(3, 1, 7, 1, 7000.00),
(4, 2, 2, 1, 30000.00),
(5, 2, 6, 1, 45000.00),
(6, 2, 5, 1, 30000.00),
(7, 3, 4, 1, 500000.00),
(8, 3, 5, 1, 30000.00),
(9, 3, 1, 1, 2000.00),
(10, 4, 9, 1, 15000.00),
(11, 5, 9, 1, 15000.00),
(12, 6, 3, 2, 24000.00),
(13, 7, 10, 1, 9000.00),
(14, 8, 10, 1, 9000.00),
(15, 9, 10, 1, 9000.00),
(16, 9, 6, 1, 45000.00),
(17, 9, 15, 1, 3000.00),
(18, 9, 2, 1, 30000.00),
(19, 10, 16, 1, 3000.00),
(20, 11, 20, 4, 4000000.00),
(21, 12, 24, 2, 30000.00),
(22, 12, 1, 3, 9000.00),
(23, 13, 24, 1, 15000.00);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Makanan'),
(2, 'Minuman'),
(3, 'Snack'),
(4, 'Sabun'),
(5, 'Makeup'),
(7, 'Obat obatan'),
(8, 'pakaian luar'),
(9, 'miu miu');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_transaksi` int(11) DEFAULT NULL,
  `metode` enum('cash','debit','ewallet') DEFAULT NULL,
  `jumlah_bayar` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int(11) NOT NULL,
  `nama_supplier` varchar(100) DEFAULT NULL,
  `kontak` varchar(50) DEFAULT NULL,
  `alamat` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama_supplier`, `kontak`, `alamat`) VALUES
(1, 'Unilever', NULL, NULL),
(2, 'Wardah', NULL, NULL),
(3, 'Mayora', NULL, NULL),
(4, 'Indostarr', NULL, NULL),
(5, 'Wings', NULL, NULL),
(11, 'nunung', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `total_belanja` decimal(10,2) DEFAULT NULL,
  `bayar` decimal(10,2) DEFAULT NULL,
  `kembalian` decimal(10,2) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `tanggal`, `total_belanja`, `bayar`, `kembalian`, `id_user`, `status`) VALUES
(1, '2026-06-04', 49000.00, 50000.00, 1000.00, 1, 'Selesai'),
(2, '2026-06-04', 105000.00, 150000.00, 45000.00, 1, 'Pending'),
(3, '2026-06-04', 532000.00, 1000000.00, 468000.00, 1, 'Selesai'),
(4, '2026-06-17', 15000.00, 16000.00, 1000.00, 1, 'Pending'),
(5, '2026-06-17', 15000.00, 20000.00, 5000.00, 1, 'Selesai'),
(6, '2026-06-17', 24000.00, 30000.00, 6000.00, 1, 'Batal'),
(7, '2026-06-17', 9000.00, 10000.00, 1000.00, 1, 'Selesai'),
(8, '2026-06-17', 9000.00, 10000.00, 1000.00, 1, 'Selesai'),
(9, '2026-06-18', 87000.00, 100000.00, 13000.00, 1, 'Selesai'),
(10, '2026-06-20', 3000.00, 30000.00, 27000.00, 1, 'Pending'),
(11, '2026-06-20', 4000000.00, 4000000.00, 0.00, 1, 'Pending'),
(12, '2026-06-23', 39000.00, 39000.00, 0.00, 1, 'Pending'),
(13, '2026-06-23', 15000.00, 20000.00, 5000.00, 1, 'Pending');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id_detail`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
