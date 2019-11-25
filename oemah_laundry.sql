-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 25 Nov 2019 pada 07.28
-- Versi server: 10.1.37-MariaDB
-- Versi PHP: 7.3.0

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
-- Struktur dari tabel `barang_cucian`
--

CREATE TABLE `barang_cucian` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `lama` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `barang_cucian`
--

INSERT INTO `barang_cucian` (`id`, `nama`, `harga`, `lama`) VALUES
(1, 'Pakaian', 3000, 1),
(2, 'Selimut', 4000, 3),
(3, 'Boneka', 8000, 3),
(5, 'Seprei', 5000, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `telepon` varchar(255) NOT NULL DEFAULT '',
  `alamat` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama`, `username`, `password`, `telepon`, `alamat`) VALUES
(1, 'fakhri', 'fakhri', '123', '0823267156', 'jl. kenangan no 4'),
(2, 'Hama', 'Hama', 'qweasd123', '', ''),
(3, '', 'infaag', 'infa3785IN', '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemesanan`
--

CREATE TABLE `pemesanan` (
  `id_pemesanan` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL DEFAULT '0',
  `id_petugas` int(11) NOT NULL DEFAULT '0',
  `total_harga` int(11) DEFAULT '0',
  `tanggal_masuk` date NOT NULL DEFAULT '0000-00-00',
  `tanggal_keluar` date DEFAULT '0000-00-00',
  `status` varchar(255) DEFAULT 'Belum Diproses' COMMENT 'Belum Diproses, Sedang Diproses, Selesai'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pemesanan`
--

INSERT INTO `pemesanan` (`id_pemesanan`, `id_pelanggan`, `id_petugas`, `total_harga`, `tanggal_masuk`, `tanggal_keluar`, `status`) VALUES
(5, 2, 0, 8000, '2019-09-27', '2019-10-02', 'selesai'),
(9, 1, 1, 14000, '2019-10-03', '2019-10-07', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `petugas`
--

CREATE TABLE `petugas` (
  `id_petugas` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `tipe` enum('Petugas Cuci','Petugas Admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `petugas`
--

INSERT INTO `petugas` (`id_petugas`, `nama`, `username`, `password`, `tipe`) VALUES
(0, 'ilham', 'ilham', 'andri', 'Petugas Cuci'),
(1, 'baziyad', 'baziyad', 'hummam', 'Petugas Admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rincian_pemesanan`
--

CREATE TABLE `rincian_pemesanan` (
  `id_rincian` int(11) NOT NULL,
  `id_pemesanan` int(11) DEFAULT NULL,
  `id_barang_cucian` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `harga` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang_cucian`
--
ALTER TABLE `barang_cucian`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indeks untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`id_pemesanan`),
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `id_petugas` (`id_petugas`) USING BTREE;

--
-- Indeks untuk tabel `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id_petugas`);

--
-- Indeks untuk tabel `rincian_pemesanan`
--
ALTER TABLE `rincian_pemesanan`
  ADD PRIMARY KEY (`id_rincian`),
  ADD KEY `id_pemesanan` (`id_pemesanan`),
  ADD KEY `id_barang_cucian` (`id_barang_cucian`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `id_pemesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id_petugas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `rincian_pemesanan`
--
ALTER TABLE `rincian_pemesanan`
  MODIFY `id_rincian` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD CONSTRAINT `pemesanan_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`),
  ADD CONSTRAINT `pemesanan_ibfk_2` FOREIGN KEY (`id_petugas`) REFERENCES `petugas` (`id_petugas`);

--
-- Ketidakleluasaan untuk tabel `rincian_pemesanan`
--
ALTER TABLE `rincian_pemesanan`
  ADD CONSTRAINT `rincian_pemesanan_ibfk_1` FOREIGN KEY (`id_pemesanan`) REFERENCES `pemesanan` (`id_pemesanan`),
  ADD CONSTRAINT `rincian_pemesanan_ibfk_2` FOREIGN KEY (`id_barang_cucian`) REFERENCES `barang_cucian` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
