-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2026 at 06:45 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_bengkel`
--

-- --------------------------------------------------------

--
-- Table structure for table `table_kendaraan`
--

CREATE TABLE `table_kendaraan` (
  `id_kendaraan` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `no_plat` varchar(15) NOT NULL,
  `merk_tipe` varchar(25) NOT NULL,
  `tahun_keluaran` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table_kendaraan`
--

INSERT INTO `table_kendaraan` (`id_kendaraan`, `id_pelanggan`, `no_plat`, `merk_tipe`, `tahun_keluaran`) VALUES
(5, 6, 'AOFLA', '2345', '2026'),
(6, 7, 'FIHR0343', 'saflk', '2026');

-- --------------------------------------------------------

--
-- Table structure for table `table_pelanggan`
--

CREATE TABLE `table_pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama_pelanggan` varchar(25) NOT NULL,
  `no_hp` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table_pelanggan`
--

INSERT INTO `table_pelanggan` (`id_pelanggan`, `nama_pelanggan`, `no_hp`) VALUES
(6, 'ewgihkfj', '2345'),
(7, 'asflk', '203948');

-- --------------------------------------------------------

--
-- Table structure for table `table_servis`
--

CREATE TABLE `table_servis` (
  `id_servis` int(11) NOT NULL,
  `id_kendaraan` int(11) NOT NULL,
  `tanggal_servis` date NOT NULL,
  `keluhan` text NOT NULL,
  `tindakan_mekanik` text DEFAULT NULL,
  `status_servis` enum('Antre','Diproses','Selesai') NOT NULL,
  `total_biaya` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table_servis`
--

INSERT INTO `table_servis` (`id_servis`, `id_kendaraan`, `tanggal_servis`, `keluhan`, `tindakan_mekanik`, `status_servis`, `total_biaya`) VALUES
(6, 5, '2026-06-17', 'gfgjhkk', NULL, 'Antre', 0),
(9, 6, '2026-06-17', 'gxfhcgjkjl', 'ghvj,,', 'Selesai', 865567);

-- --------------------------------------------------------

--
-- Table structure for table `table_user`
--

CREATE TABLE `table_user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(15) NOT NULL,
  `nama_lengkap` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table_user`
--

INSERT INTO `table_user` (`id_user`, `username`, `password`, `nama_lengkap`) VALUES
(1, 'admin', 'admin123', 'Resepsionis Bengkel');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `table_kendaraan`
--
ALTER TABLE `table_kendaraan`
  ADD PRIMARY KEY (`id_kendaraan`),
  ADD UNIQUE KEY `no_plat` (`no_plat`),
  ADD KEY `id_pelanggan` (`id_pelanggan`);

--
-- Indexes for table `table_pelanggan`
--
ALTER TABLE `table_pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `table_servis`
--
ALTER TABLE `table_servis`
  ADD PRIMARY KEY (`id_servis`),
  ADD UNIQUE KEY `id_kendaraan` (`id_kendaraan`);

--
-- Indexes for table `table_user`
--
ALTER TABLE `table_user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `password` (`password`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `table_kendaraan`
--
ALTER TABLE `table_kendaraan`
  MODIFY `id_kendaraan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `table_pelanggan`
--
ALTER TABLE `table_pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `table_servis`
--
ALTER TABLE `table_servis`
  MODIFY `id_servis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `table_user`
--
ALTER TABLE `table_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `table_kendaraan`
--
ALTER TABLE `table_kendaraan`
  ADD CONSTRAINT `table_kendaraan_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `table_pelanggan` (`id_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `table_servis`
--
ALTER TABLE `table_servis`
  ADD CONSTRAINT `table_servis_ibfk_1` FOREIGN KEY (`id_kendaraan`) REFERENCES `table_kendaraan` (`id_kendaraan`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
