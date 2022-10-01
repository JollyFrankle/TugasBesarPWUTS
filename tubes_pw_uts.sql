-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 01, 2022 at 11:50 AM
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
(1, 'The Mind of A Leader', 'fotobuku_TheMindOfALeader.jpg', 0),
(2, 'Kereta Selatan', 'fotobuku_6337ec090080e9.52758704.jpg', 1),
(3, 'Kereta Utara', 'fotobuku_6337f0c872d4b6.22087486.png', 20),
(5, 'Buku Tamu extra', 'fotobuku_6338011e6fd2b6.77077100.png', 9);

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
(10, 4, 2, '2022-10-01', '2022-10-08', 1),
(11, 4, 1, '2022-10-01', '2022-10-01', 0),
(13, 16, 1, '2022-10-01', '2022-10-08', 1),
(14, 16, 2, '2022-10-01', '2022-10-08', 1),
(15, 16, 2, '2022-10-01', '2022-10-01', 0),
(16, 4, 1, '2022-10-01', '2022-10-08', 1),
(17, 4, 3, '2022-10-01', '2022-10-08', 1),
(18, 10, 1, '2022-10-01', '2022-10-01', 0),
(19, 10, 1, '2022-10-01', '2022-10-08', 1),
(20, 10, 2, '2022-10-01', '2022-10-08', 1),
(21, 10, 2, '2022-10-01', '2022-10-01', 0),
(22, 10, 2, '2022-10-01', '2022-10-08', 1),
(23, 10, 5, '2022-10-01', '2022-10-08', 1);

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
(1, 'admin', '$2y$10$j6fR8II1dmVqRxSRx6cCB.YwLDDxjHnI.dCdF70L4a6v3nll7oIRu', 'Administrasi Minecraft', NULL, 'admin'),
(4, 'danielricky33@yahoo.com', '$2y$10$meyDtFLAfkXHFiBXnXtukeBbZtoTUgSdTfhOumcr.7M92TAkSNSEi', 'Daniel Ricky Alexander', 'fotouser_63380a4f180ac8.78329673.jpg', 'user'),
(10, 'jollyfrankle3@gmail.com', '$2y$10$meyDtFLAfkXHFiBXnXtukeBbZtoTUgSdTfhOumcr.7M92TAkSNSEi', 'Jolly Hans Frankle', 'fotouser_6337e1093d27e0.36780603.jpg', 'user'),
(11, 'jol4yfrankle3@gmail.com', '$2y$10$Ds3QQAI9QDdyKcO50slzbuj0V05e.OzFVkxrm4cthGn1V2v2ba.sm', 'Jolly 2', NULL, 'user'),
(12, 'jollyfrankle4@gmail.com', '$2y$10$ESeBFmjZPXJzZMIqja4b/.TC6UB5PtpF7w4T0XwkPgcHboSfv97ta', 'qweqe', 'fotouser_6337b71e074270.37070299.png', 'user'),
(14, '123@ee.ww', '$2y$10$pcwDS49NB7NPTG8FPxjK4ex6bR21lc9MrGfQhajFBA.3bHhq3FQRC', '123', 'fotouser_6337d00c434b63.41400932.png', 'user'),
(15, 'krisna@gmail.com', '$2y$10$zmS1q2zOMojIrntBnic32eE8p9wW1LawEzrXuKt.brQHAZtXN/5Mm', 'krisnarata', 'fotouser_6337d021cfff12.29895413.jpg', 'user'),
(16, 'krisnarata2@gmail.com', '$2y$10$P9CRL04ERpeHrArfF.Dw2uJACYGqS9gLww91l7U3G5qZqoTfDgMfy', 'krisna', 'fotouser_6337fe265d2e48.49849435.jpg', 'user'),
(17, 'User@gmail.com', '$2y$10$49h9q0xgqQd92YCJ7gLA2OEfLBapRebwiCPQfgICHVbZj3lbiCt26', 'User', 'fotouser_63380bdb066974.63308337.jpg', 'user'),
(18, 'danielricky1404@yahoo.com', '$2y$10$Sr80Ogl1Dc7MUY9cKGuya.VSiSyruy9B60e.8eXtyx7hInWlmzmoe', 'Daniel Ricky Alexander', 'fotouser_63380cb37565f7.89475995.png', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK buku` (`id_buku`),
  ADD KEY `FK user` (`id_user`);

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `FK buku` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
