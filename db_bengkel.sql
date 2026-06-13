-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2026 at 04:37 AM
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
(2, 3, 'BM2120JAF', 'megapro', '2026'),
(3, 4, 'BH5678JHG', 'nmax', '2026'),
(4, 5, 'B4567HGF', 'vario', '2026');

-- --------------------------------------------------------

--
-- Table structure for table `table_pelanggan`
--

CREATE TABLE `table_pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama_pelanggan` varchar(25) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table_pelanggan`
--

INSERT INTO `table_pelanggan` (`id_pelanggan`, `nama_pelanggan`, `no_hp`, `alamat`) VALUES
(3, 'sdfgg', '0987654', ''),
(4, 'vbnm', '9876543', ''),
(5, 'bngfc ', '9876556', '');

-- --------------------------------------------------------

--
-- Table structure for table `table_servis`
--

CREATE TABLE `table_servis` (
  `id_servis` int(11) NOT NULL,
  `id_kendaraan` int(11) NOT NULL,
  `tanggal_servis` date NOT NULL,
  `keluhan` text NOT NULL,
  `tindakan_mekanik` text NOT NULL,
  `status_servis` enum('Antre','Diproses','Selesai') NOT NULL,
  `total_biaya` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table_servis`
--

INSERT INTO `table_servis` (`id_servis`, `id_kendaraan`, `tanggal_servis`, `keluhan`, `tindakan_mekanik`, `status_servis`, `total_biaya`) VALUES
(2, 2, '2026-06-13', 'bghjmnbvgh', 'fghjklkmnbvcc', 'Selesai', 2345678),
(3, 4, '2026-06-13', 'ngfghj', 'ojihpfvajl', 'Selesai', 549999),
(4, 3, '2026-06-13', 'jalskhf', 'lrkwhq', 'Selesai', 123212);

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
  MODIFY `id_kendaraan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `table_pelanggan`
--
ALTER TABLE `table_pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `table_servis`
--
ALTER TABLE `table_servis`
  MODIFY `id_servis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
