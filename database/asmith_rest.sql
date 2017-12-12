-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 12 Des 2017 pada 12.30
-- Versi Server: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `asmith_rest`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `rest_crud`
--

CREATE TABLE `rest_crud` (
  `id` int(11) NOT NULL,
  `data` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `rest_crud`
--

INSERT INTO `rest_crud` (`id`, `data`, `created_at`, `updated_at`) VALUES
(2, 'data kedua', '2017-12-12 03:40:32', '2017-12-12 03:40:32'),
(3, 'data ketiga', '2017-12-12 03:40:35', '2017-12-12 03:40:35'),
(4, 'data keempat', '2017-12-12 03:40:40', '2017-12-12 03:40:40'),
(5, 'data kelima', '2017-12-12 03:40:43', '2017-12-12 03:40:43'),
(6, 'data keenam', '2017-12-12 03:55:05', '2017-12-12 04:28:12'),
(7, 'data ketujuh', '2017-12-12 04:27:24', '2017-12-12 04:28:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rest_user`
--

CREATE TABLE `rest_user` (
  `id` int(11) NOT NULL,
  `name` varchar(225) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(225) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `rest_user`
--

INSERT INTO `rest_user` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(5, 'Agus Adhi Sumitro', 'mail@asmith.my.id', '$2y$10$OahV.jOAPq3MnwaGxt6p1eJOG7dEf5gMsDZI4xiLE82X48.W7GNd6', '2017-12-11 03:01:44', '2017-12-12 03:03:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rest_crud`
--
ALTER TABLE `rest_crud`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rest_user`
--
ALTER TABLE `rest_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rest_crud`
--
ALTER TABLE `rest_crud`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `rest_user`
--
ALTER TABLE `rest_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
