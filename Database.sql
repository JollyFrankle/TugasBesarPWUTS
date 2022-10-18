-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 18, 2022 at 03:37 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tubes_pw_uts`
--

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id` int(10) UNSIGNED NOT NULL,
  `judul` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gambar` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id`, `judul`, `gambar`, `jumlah`) VALUES
(1, 'The Mind of A Leader - Kevin Anderson', 'fotobuku_TheMindOfALeader.jpg', 9),
(3, 'Kereta Utara', 'fotobuku_634c2185454ad1.48936238.png', 20),
(9, 'Moby Dick', 'fotobuku_634126ff897d79.47015435.jpg', 5),
(10, 'Hujan - Tereliye', 'fotobuku_634c2d08e7c8e3.80052667.jpg', 44),
(11, 'Lima Sekawan - Di Pulau Seram', 'fotobuku_634c1da3cf96c0.12970370.jpg', 33),
(12, 'Pergi - Tereliye', 'fotobuku_634c2029a05a55.97298109.jpg', 77),
(13, 'Pulang - Tereliye', 'fotobuku_634c20a50b5dd3.95476777.jpg', 56),
(14, 'Laskar Pelangi', 'fotobuku_634e5c86e54cd8.47024908.jpg', 22),
(15, 'Lima Sekawan - Rahasia Harta Karun', 'fotobuku_634c23d4a2aef4.76512082.jpg', 58),
(17, 'Harry Potter and the Deathly Hallows', 'fotobuku_634c24e152d553.55690791.jpg', 87),
(18, 'Harry Potter and the Sorcerers Stone', 'fotobuku_634e5b1bc61983.05726050.jpg', 75),
(23, 'Evrnt', 'fotobuku_634e72211e3824.92924874.jpg', 127);

-- --------------------------------------------------------

--
-- Table structure for table `kritik_saran`
--

CREATE TABLE `kritik_saran` (
  `id` int(10) NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `judul` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `konten` tinytext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_kirim` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kritik_saran`
--

INSERT INTO `kritik_saran` (`id`, `id_user`, `judul`, `konten`, `tanggal_kirim`) VALUES
(1, 10, 'Musik di perpus', 'PRO DANGDUT 444', '2022-10-08 14:51:27'),
(2, 4, 'Kritik Buku Harry Potter', 'ceritanya sangat menarik sekali dan saya juga ingin jadi penyihir', '2022-10-07 16:11:58'),
(3, 10, 'kritik brutal', 'Lantai 2 Sangat Berisik! Diharapkan pustakawan lebih tegas menegur orang yang gaduh, sangat merugikan yang sedang mengerjakan SKRIPSI. Thanks', '2022-10-08 00:00:00'),
(11, 16, 'Ini Komentar/ ini saran', 'Saran untuk Minecraft Library :\nBatas peminjaman buku  diperbanyak. Jangan hanya 2, misalnya 5 buku, kemudian waktu peminjaman diperpanjang dari 7 hari menjadi 14 hari. Terimakasi', '2022-10-08 17:10:08'),
(17, 4, 'hehe', 'Penjaga perpusnya ganteng banget 11/10 la :3', '2022-10-08 14:51:28'),
(18, 16, 'Saran', 'perlu diupayakan peningkatan aspek fisik perpustakaan yang ideal sehingga diharapkan tercipta kondisi ruang perpustakaan yang kondusif untuk pengguna perpustakaan.', '2022-10-08 17:10:38'),
(19, 10, 'Pujian untuk Perpus', 'perpustakan ini sangat menginspirasi saya untuk menjadi perpustakawan, karena para pengursu disini sangat baik baik dan memiliki atitude. Lalu buku buku disini sangat banyak dan menarik', '2022-10-08 17:09:44'),
(25, 4, 'Kritik perpustakaan', 'pada perpustakaan ini tempatnya kotor dan tidak rapi. banyak sampah berceceran di lantai, permen karet di bawah meja, dan banyak buku yang sobek dan rusak. Penjaganya juga tidak waras. ', '2022-10-16 23:06:14'),
(30, 23, 'Buki bsnyak yang sudah rusak', 'Buku Laskar Pelangi sampulnya sudah banyak yang rusak, banyak hakaman yang hilang juga...\r\n\r\nTolong kalau tidak berniat buka perpustakaan, jangan dibuka.', '2022-10-18 15:15:20');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `id_buku` int(10) UNSIGNED NOT NULL,
  `tanggal_pinjam` date DEFAULT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `id_user`, `id_buku`, `tanggal_pinjam`, `tanggal_kembali`, `status`) VALUES
(1, 4, 1, '2022-10-04', '2022-10-01', 0),
(2, 1, 1, '2022-10-01', '2022-10-01', 0),
(3, 1, 1, '2022-10-01', '2022-10-08', 0),
(4, 1, 1, '2022-10-01', '2022-10-01', 0),
(5, 1, 1, '2022-10-01', '2022-10-01', 0),
(6, 1, 1, '2022-10-01', '2022-10-01', 0),
(7, 4, 1, '2022-10-01', '2022-10-01', 0),
(8, 15, 1, '2022-10-01', '2022-10-08', 1),
(9, 4, 1, '2022-10-01', '2022-10-01', 0),
(11, 4, 1, '2022-10-01', '2022-10-01', 0),
(13, 16, 1, '2022-10-01', '2022-10-07', 0),
(16, 4, 1, '2022-10-01', '2022-10-16', 0),
(17, 4, 3, '2022-10-01', '2022-10-08', 1),
(18, 10, 1, '2022-10-01', '2022-10-01', 0),
(19, 10, 1, '2022-10-01', '2022-10-07', 0),
(25, 16, 3, '2022-10-07', '2022-10-08', 0),
(27, 16, 1, '2022-10-08', '2022-10-15', 1),
(30, 16, 10, '2022-10-08', '2022-10-16', 0),
(31, 4, 10, '2022-10-08', '2022-10-16', 0),
(32, 19, 10, '2022-10-08', '2022-10-15', 1),
(33, 4, 9, '2022-10-08', '2022-10-18', 0),
(34, 10, 1, '2022-10-08', '2022-10-08', 0),
(36, 10, 10, '2022-10-09', '2022-10-09', 0),
(37, 10, 1, '2022-10-09', '2022-10-09', 0),
(38, 10, 1, '2022-10-09', '2022-10-09', 0),
(39, 10, 10, '2022-10-16', '2022-10-16', 0),
(40, 4, 17, '2022-10-16', '2022-10-16', 0),
(41, 4, 18, '2022-10-16', '2022-10-23', 1),
(42, 4, 17, '2022-10-16', '2022-10-23', 1),
(43, 21, 3, '2022-10-18', '2022-10-18', 0),
(46, 21, 11, '2022-10-18', '2022-10-18', 0),
(47, 23, 18, '2022-10-18', '2022-10-18', 0),
(48, 1, 1, '2022-10-18', '2022-10-25', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reservasi_ruang_baca`
--

CREATE TABLE `reservasi_ruang_baca` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `id_ruang` int(10) UNSIGNED NOT NULL,
  `tanggal` date DEFAULT NULL,
  `sesi` tinyint(4) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reservasi_ruang_baca`
--

INSERT INTO `reservasi_ruang_baca` (`id`, `id_user`, `id_ruang`, `tanggal`, `sesi`, `status`) VALUES
(4, 10, 3, '2022-10-01', 3, 0),
(5, 10, 2, '2022-10-27', 3, 1),
(6, 16, 2, '2022-10-09', 2, 1),
(7, 16, 3, '2022-10-09', 1, 1),
(8, 4, 3, '2022-10-23', 3, 1),
(9, 10, 2, '2022-10-19', 3, 2),
(10, 10, 2, '2022-10-15', 3, 0),
(13, 16, 4, '2022-10-09', 1, 1),
(15, 4, 4, '2022-10-09', 3, 1),
(19, 4, 2, '2022-10-19', 4, 2),
(20, 16, 2, '2022-10-11', 2, 2),
(21, 4, 2, '2022-11-05', 2, 2),
(23, 16, 2, '2022-10-29', 5, 0),
(24, 16, 4, '2022-10-20', 3, 2),
(26, 21, 3, '2022-10-29', 2, 2),
(27, 23, 2, '2022-10-19', 5, 1),
(29, 23, 2, '2022-10-19', 5, 1),
(30, 1, 2, '2022-10-19', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ruang_baca`
--

CREATE TABLE `ruang_baca` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama_ruang` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kapasitas` int(10) NOT NULL,
  `gambar` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ruang_baca`
--

INSERT INTO `ruang_baca` (`id`, `nama_ruang`, `deskripsi`, `kapasitas`, `gambar`) VALUES
(1, 'Ruang Baca 1', 'Ruang Baca 1 adalah ruang baca dengan ukuran terbesar, dilengkapi fasilitas seperti AC, TV 48 inch, serta kursi untuk 12 orang.', 12, 'ruang1.png'),
(2, 'Ruang Meeting 1', 'Ruang Baca 2 adalah ruang baca ukuran kecil, dapat menampung hingga 6 orang di kursi.', 6, 'ruangBaca2.webp'),
(3, 'Bilik Renungan 1', 'Kamar renungan yang dapat menampung hingga 3 orang dalam 1 bangku. Tersedia 1 buah TV 14 inch.', 3, 'ruangBaca3.webp'),
(4, 'Ruang Baca 2', 'Ruang ini bisa digunakan untuk meeting ataupun kerja kelompok. Mahasiswa dapat menggunakan ini untuk kerja kelompok serta meeting. Ruangnan ini tersedia 2 kursi sofa panjang, 1 meja bundar, 2 kursi bantal, AC, lemari, dan lampu indah.', 10, 'ruangBaca4.webp');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `nama`, `foto`, `role`) VALUES
(1, 'admin', '$2y$10$j6fR8II1dmVqRxSRx6cCB.YwLDDxjHnI.dCdF70L4a6v3nll7oIRu', 'Administrasi Minecraft', 'fotouser_634129a23a5fa8.45841245.png', 'admin'),
(4, 'danielricky33@yahoo.com', '$2y$10$meyDtFLAfkXHFiBXnXtukeBbZtoTUgSdTfhOumcr.7M92TAkSNSEi', 'Riq', 'fotouser_634c2cb0ce3379.91819680.jpg', 'user'),
(10, 'jollyfrankle3@gmail.com', '$2y$10$meyDtFLAfkXHFiBXnXtukeBbZtoTUgSdTfhOumcr.7M92TAkSNSEi', 'Jolly Hans Frankle', 'fotouser_63414e217bf305.71975676.png', 'user'),
(11, 'jol4yfrankle3@gmail.com', '$2y$10$Ds3QQAI9QDdyKcO50slzbuj0V05e.OzFVkxrm4cthGn1V2v2ba.sm', 'Jolly 2', NULL, 'user'),
(12, 'jollyfrankle4@gmail.com', '$2y$10$ESeBFmjZPXJzZMIqja4b/.TC6UB5PtpF7w4T0XwkPgcHboSfv97ta', 'qweqe', 'fotouser_6337b71e074270.37070299.png', 'user'),
(14, '123@ee.ww', '$2y$10$pcwDS49NB7NPTG8FPxjK4ex6bR21lc9MrGfQhajFBA.3bHhq3FQRC', '123', 'fotouser_6337d00c434b63.41400932.png', 'user'),
(15, 'krisna@gmail.com', '$2y$10$zmS1q2zOMojIrntBnic32eE8p9wW1LawEzrXuKt.brQHAZtXN/5Mm', 'krisnarata', 'fotouser_6337d021cfff12.29895413.jpg', 'user'),
(16, 'krisnarata2@gmail.com', '$2y$10$P9CRL04ERpeHrArfF.Dw2uJACYGqS9gLww91l7U3G5qZqoTfDgMfy', 'krisnarata', 'fotouser_6337fe265d2e48.49849435.jpg', 'user'),
(17, 'User@gmail.com', '$2y$10$49h9q0xgqQd92YCJ7gLA2OEfLBapRebwiCPQfgICHVbZj3lbiCt26', 'User', 'fotouser_63380bdb066974.63308337.jpg', 'user'),
(18, 'danielricky1404@yahoo.com', '$2y$10$Sr80Ogl1Dc7MUY9cKGuya.VSiSyruy9B60e.8eXtyx7hInWlmzmoe', 'Daniel Ricky Alexander', 'fotouser_63380cb37565f7.89475995.png', 'user'),
(19, 'Email@mail.com', '$2y$10$fzAYc45LDCQm6sQQJ4utOeLglPfeL8nRWUpqYp5HvjsqX79eySCq6', 'User', 'fotouser_634128b7839327.61839312.jpg', 'user'),
(20, '123@r', '$2y$10$R01gdGgpSBCrvzhKBBI4G.4hbjM0lzX4V0OsuSd9Ot6FyAR22Fx92', '123', 'fotouser_634128c1e61392.97962267.png', 'user'),
(21, 'Ricky@email.com', '$2y$10$BEgtO072YnCoCQHBppkp.OiBslWyoWI8kSj0QQLDOTRB8fS4LJzTa', 'Ricky', 'fotouser_634e3e4c3383a5.82693512.jpg', 'user'),
(22, 'Ricky@gmail.com', '$2y$10$KXBDhBo2L.Q1H8ApEBSHHuQA63WvIPTjUwI3JQGY8lJYk0M81zI0e', 'Daniel Ricky Alexander', 'fotouser_634e3f2a328cd8.89214574.jpg', 'user'),
(23, 'vincent01sj@gmail.com', '$2y$10$lAeIX2ayRt3jBN5EmjjZmefCJLhV7tknddqmODPtSzfFRKvb90nnq', 'Vingent Sadja', 'fotouser_634e46b4f1c258.07200615.jpg', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kritik_saran`
--
ALTER TABLE `kritik_saran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK id_user` (`id_user`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK buku` (`id_buku`),
  ADD KEY `FK user` (`id_user`);

--
-- Indexes for table `reservasi_ruang_baca`
--
ALTER TABLE `reservasi_ruang_baca`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_user` (`id_user`),
  ADD KEY `FK_ruang` (`id_ruang`),
  ADD KEY `tanggal` (`tanggal`),
  ADD KEY `sesi` (`sesi`);

--
-- Indexes for table `ruang_baca`
--
ALTER TABLE `ruang_baca`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `kritik_saran`
--
ALTER TABLE `kritik_saran`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `reservasi_ruang_baca`
--
ALTER TABLE `reservasi_ruang_baca`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `ruang_baca`
--
ALTER TABLE `ruang_baca`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kritik_saran`
--
ALTER TABLE `kritik_saran`
  ADD CONSTRAINT `FK id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `FK buku` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reservasi_ruang_baca`
--
ALTER TABLE `reservasi_ruang_baca`
  ADD CONSTRAINT `FK_ruang` FOREIGN KEY (`id_ruang`) REFERENCES `ruang_baca` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
