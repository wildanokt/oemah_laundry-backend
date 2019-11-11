-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2019 at 11:30 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `oemah_laundry`
--

-- --------------------------------------------------------

--
-- Table structure for table `ppk_barang_cucian`
--

CREATE TABLE `ppk_barang_cucian` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `lama` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ppk_barang_cucian`
--

INSERT INTO `ppk_barang_cucian` (`id`, `nama`, `harga`, `lama`) VALUES
(1, 'Pakaian', 3000, 1),
(2, 'Selimut', 4000, 3),
(3, 'Boneka', 8000, 3),
(5, 'Seprei', 5000, 2);

-- --------------------------------------------------------

--
-- Table structure for table `ppk_pelanggan`
--

CREATE TABLE `ppk_pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `telepon` varchar(255) NOT NULL DEFAULT '',
  `alamat` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ppk_pelanggan`
--

INSERT INTO `ppk_pelanggan` (`id_pelanggan`, `nama`, `username`, `password`, `telepon`, `alamat`) VALUES
(1, 'fakhri', 'fakhri', '123', '0823267156', 'jl. kenangan no 4'),
(2, 'Hama', 'Hama', 'qweasd123', '', ''),
(3, '', 'infaag', 'infa3785IN', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `ppk_pemesanan`
--

CREATE TABLE `ppk_pemesanan` (
  `id_pemesanan` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL DEFAULT '0',
  `id_petugas` int(11) NOT NULL DEFAULT '0',
  `tipe_cucian` varchar(255) NOT NULL DEFAULT '0',
  `barang_cucian` varchar(255) NOT NULL DEFAULT '0',
  `berat` int(11) DEFAULT '0',
  `harga` int(11) DEFAULT '0',
  `tanggal_masuk` date NOT NULL DEFAULT '0000-00-00',
  `tanggal_keluar` date DEFAULT '0000-00-00',
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ppk_pemesanan`
--

INSERT INTO `ppk_pemesanan` (`id_pemesanan`, `id_pelanggan`, `id_petugas`, `tipe_cucian`, `barang_cucian`, `berat`, `harga`, `tanggal_masuk`, `tanggal_keluar`, `status`) VALUES
(5, 2, 0, 'Cuci Kering', 'Selimut', 2, 8000, '2019-09-27', '2019-10-02', 'selesai'),
(9, 1, 1, 'Cuci Kering', 'Pakaian', 5, 14000, '2019-10-03', '2019-10-07', '');

-- --------------------------------------------------------

--
-- Table structure for table `ppk_petugas`
--

CREATE TABLE `ppk_petugas` (
  `id_petugas` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `tipe` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ppk_petugas`
--

INSERT INTO `ppk_petugas` (`id_petugas`, `nama`, `username`, `password`, `tipe`) VALUES
(0, 'ilham', 'ilham', 'qweasd123', 'umum'),
(1, 'baziyad', 'baziyad@oemah.com', '123456789#', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ppk_barang_cucian`
--
ALTER TABLE `ppk_barang_cucian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppk_pelanggan`
--
ALTER TABLE `ppk_pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `ppk_pemesanan`
--
ALTER TABLE `ppk_pemesanan`
  ADD PRIMARY KEY (`id_pemesanan`),
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `id_petugas` (`id_petugas`) USING BTREE;

--
-- Indexes for table `ppk_petugas`
--
ALTER TABLE `ppk_petugas`
  ADD PRIMARY KEY (`id_petugas`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ppk_pelanggan`
--
ALTER TABLE `ppk_pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ppk_pemesanan`
--
ALTER TABLE `ppk_pemesanan`
  MODIFY `id_pemesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ppk_petugas`
--
ALTER TABLE `ppk_petugas`
  MODIFY `id_petugas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ppk_pemesanan`
--
ALTER TABLE `ppk_pemesanan`
  ADD CONSTRAINT `ppk_pemesanan_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `ppk_pelanggan` (`id_pelanggan`),
  ADD CONSTRAINT `ppk_pemesanan_ibfk_2` FOREIGN KEY (`id_petugas`) REFERENCES `ppk_petugas` (`id_petugas`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
