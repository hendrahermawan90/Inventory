-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2025 at 06:02 AM
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
-- Database: `stockbarang`
--

-- --------------------------------------------------------

--
-- Table structure for table `keluar`
--

CREATE TABLE `keluar` (
  `idkeluar` int(11) NOT NULL,
  `idbarang` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `qty` int(11) NOT NULL,
  `penerima` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `keluar`
--

INSERT INTO `keluar` (`idkeluar`, `idbarang`, `tanggal`, `qty`, `penerima`) VALUES
(9, 109, '2025-01-08 04:10:42', 34, 'hendra');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `iduser` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`iduser`, `email`, `password`) VALUES
(11, 'hendra@gmail.com', '$2y$10$.ZCnBRprpgQtzyI5gLtuY.AS7iETTZqWYNYFYNoMWH4IAq6oymRCO');

-- --------------------------------------------------------

--
-- Table structure for table `masuk`
--

CREATE TABLE `masuk` (
  `idmasuk` int(11) NOT NULL,
  `idbarang` int(11) DEFAULT NULL,
  `tanggal` timestamp NULL DEFAULT current_timestamp(),
  `qty` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `masuk`
--

INSERT INTO `masuk` (`idmasuk`, `idbarang`, `tanggal`, `qty`, `keterangan`) VALUES
(18, 60, '2024-12-31 05:44:55', 4, 'hendra'),
(19, 28, '2024-12-31 06:03:07', 4, 'hendra'),
(20, 52, '2025-01-08 04:05:03', 9, 'Semua Barang Kondisinya OK'),
(21, 38, '2025-01-08 04:05:19', 2, 'Semua Barang Kondisinya OK'),
(22, 60, '2025-01-08 04:07:14', 6, 'Semua Barang Kondisinya OK');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `idpeminjaman` int(11) NOT NULL,
  `idbarang` int(11) NOT NULL,
  `tanggalpinjam` timestamp NOT NULL DEFAULT current_timestamp(),
  `qty` int(11) NOT NULL,
  `peminjam` varchar(255) NOT NULL,
  `status` enum('Dipinjam','Kembali') DEFAULT 'Dipinjam'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`idpeminjaman`, `idbarang`, `tanggalpinjam`, `qty`, `peminjam`, `status`) VALUES
(8, 60, '2024-12-18 08:21:22', 20, 'hendra', 'Kembali'),
(15, 109, '2025-01-08 04:11:08', 2, 'hendra', 'Dipinjam');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `idbarang` int(11) NOT NULL,
  `namabarang` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `stock` int(11) DEFAULT 0,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`idbarang`, `namabarang`, `deskripsi`, `stock`, `image`) VALUES
(28, 'Game Console', 'Handphone', 79, NULL),
(38, 'Printer', 'Deskripsi produk 28', 82, NULL),
(41, 'External Hard Drive', 'Deskripsi produk 31', 500, NULL),
(43, 'Charger', 'Deskripsi produk 33', 430, NULL),
(46, 'Speakers', 'Deskripsi produk 36', 200, NULL),
(47, 'Smart Watch', 'Deskripsi produk 37', 130, NULL),
(48, 'Game Console', 'Deskripsi produk 38', 150, NULL),
(49, 'Router', 'Deskripsi produk 39', 400, NULL),
(50, 'Memory Card', 'Deskripsi produk 40', 600, NULL),
(51, 'Laptop', 'Deskripsi produk 41', 250, NULL),
(52, 'Mouse', 'Deskripsi produk 42', 189, NULL),
(53, 'Keyboard', 'Deskripsi produk 43', 210, NULL),
(54, 'Monitor', 'Deskripsi produk 44', 150, NULL),
(55, 'Headphone', 'Deskripsi produk 45', 80, NULL),
(56, 'Smartphone', 'Deskripsi produk 46', 500, NULL),
(57, 'Tablet', 'Deskripsi produk 47', 280, NULL),
(58, 'Printer', 'Deskripsi produk 48', 90, NULL),
(59, 'Webcam', 'Deskripsi produk 49', 160, NULL),
(60, 'USB Cable', 'Deskripsi produk 50', 530, NULL),
(61, 'External Hard Drive', 'Deskripsi produk 51', 450, NULL),
(62, 'Power Bank', 'Deskripsi produk 52', 300, NULL),
(63, 'Charger', 'Deskripsi produk 53', 500, NULL),
(64, 'Camera', 'Deskripsi produk 54', 250, NULL),
(65, 'Microphone', 'Deskripsi produk 55', 180, NULL),
(66, 'Speakers', 'Deskripsi produk 56', 220, NULL),
(67, 'Smart Watch', 'Deskripsi produk 57', 100, NULL),
(68, 'Game Console', 'Deskripsi produk 58', 150, NULL),
(69, 'Router', 'Deskripsi produk 59', 300, NULL),
(70, 'Memory Card', 'Deskripsi produk 60', 700, NULL),
(71, 'Laptop', 'Deskripsi produk 61', 400, NULL),
(72, 'Mouse', 'Deskripsi produk 62', 300, NULL),
(73, 'Keyboard', 'Deskripsi produk 63', 180, NULL),
(74, 'Monitor', 'Deskripsi produk 64', 150, NULL),
(75, 'Headphone', 'Deskripsi produk 65', 250, NULL),
(76, 'Smartphone', 'Deskripsi produk 66', 500, NULL),
(77, 'Tablet', 'Deskripsi produk 67', 200, NULL),
(78, 'Printer', 'Deskripsi produk 68', 100, NULL),
(79, 'Webcam', 'Deskripsi produk 69', 220, NULL),
(80, 'USB Cable', 'Deskripsi produk 70', 350, NULL),
(81, 'External Hard Drive', 'Deskripsi produk 71', 550, NULL),
(82, 'Power Bank', 'Deskripsi produk 72', 300, NULL),
(83, 'Charger', 'Deskripsi produk 73', 450, NULL),
(84, 'Camera', 'Deskripsi produk 74', 180, NULL),
(85, 'Microphone', 'Deskripsi produk 75', 230, NULL),
(86, 'Speakers', 'Deskripsi produk 76', 300, NULL),
(87, 'Smart Watch', 'Deskripsi produk 77', 120, NULL),
(88, 'Game Console', 'Deskripsi produk 78', 200, NULL),
(89, 'Router', 'Deskripsi produk 79', 400, NULL),
(90, 'Memory Card', 'Deskripsi produk 80', 600, NULL),
(91, 'Laptop', 'Deskripsi produk 81', 250, NULL),
(92, 'Mouse', 'Deskripsi produk 82', 150, NULL),
(93, 'Keyboard', 'Deskripsi produk 83', 120, NULL),
(94, 'Monitor', 'Deskripsi produk 84', 300, NULL),
(95, 'Headphone', 'Deskripsi produk 85', 350, NULL),
(96, 'Smartphone', 'Deskripsi produk 86', 400, NULL),
(97, 'Tablet', 'Deskripsi produk 87', 230, NULL),
(98, 'Printer', 'Deskripsi produk 88', 60, NULL),
(99, 'Webcam', 'Deskripsi produk 89', 210, NULL),
(100, 'USB Cable', 'Deskripsi produk 90', 500, NULL),
(101, 'External Hard Drive', 'Deskripsi produk 91', 350, NULL),
(102, 'Power Bank', 'Deskripsi produk 92', 420, NULL),
(103, 'Charger', 'Deskripsi produk 93', 380, NULL),
(104, 'Camera', 'Deskripsi produk 94', 170, NULL),
(105, 'Microphone', 'Deskripsi produk 95', 220, NULL),
(109, 'Samsung', 'Handphone', 666666630, 'b57cf70d7b513f089262d41d329318ef.png'),
(110, 'dcascac', '', 88, 'd185f769ac0b2c5aa72d31c8ad044d6c.png'),
(112, 'asdADadx', 'sdfgsdgvsxcvxcvxcvxcvc', 66, '69e3511c631af6ba52f1886d5623ddff.png'),
(113, 'qasdfsadasd', 'asdasd', 77, 'cda03ee150505cd357908e7598da881c.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `keluar`
--
ALTER TABLE `keluar`
  ADD PRIMARY KEY (`idkeluar`),
  ADD KEY `idbarang` (`idbarang`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`iduser`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `masuk`
--
ALTER TABLE `masuk`
  ADD PRIMARY KEY (`idmasuk`),
  ADD KEY `idbarang` (`idbarang`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`idpeminjaman`),
  ADD KEY `idbarang` (`idbarang`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`idbarang`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `keluar`
--
ALTER TABLE `keluar`
  MODIFY `idkeluar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `masuk`
--
ALTER TABLE `masuk`
  MODIFY `idmasuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `idpeminjaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `idbarang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `keluar`
--
ALTER TABLE `keluar`
  ADD CONSTRAINT `keluar_ibfk_1` FOREIGN KEY (`idbarang`) REFERENCES `stock` (`idbarang`);

--
-- Constraints for table `masuk`
--
ALTER TABLE `masuk`
  ADD CONSTRAINT `masuk_ibfk_1` FOREIGN KEY (`idbarang`) REFERENCES `stock` (`idbarang`);

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`idbarang`) REFERENCES `stock` (`idbarang`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
