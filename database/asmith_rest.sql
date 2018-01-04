-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 16 Des 2017 pada 08.29
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
-- Struktur dari tabel `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'member', 'General User');

-- --------------------------------------------------------

--
-- Struktur dari tabel `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `login_attempts`
--

INSERT INTO `login_attempts` (`id`, `ip_address`, `login`, `time`) VALUES
(5, '::1', 'adhi.sumitro@hotmail.com', 1513406750);

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
-- Struktur dari tabel `site_setting`
--

CREATE TABLE `site_setting` (
  `id` int(11) NOT NULL,
  `keys` varchar(225) NOT NULL,
  `value` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `site_setting`
--

INSERT INTO `site_setting` (`id`, `keys`, `value`) VALUES
(1, 'nama', 'Some App'),
(2, 'deskripsi', 'Some Project Dashboard and APIs'),
(3, 'office_email', 'mail@asmith.my.id'),
(4, 'office_number', '+6282271115593'),
(5, 'office_address', 'Jln. Kampung Baru '),
(6, 'maintenance_mode', 'N');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `api_token` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `api_token`, `created_at`, `updated_at`) VALUES
(13, '127.0.0.1', 'aasumitro', '$2y$08$SDVg5axxNST1YQU.rE0iOOita2ie55w1s6.y7gggoOY6fyIGLSEda', NULL, 'mail@asmith.my.id', NULL, NULL, NULL, NULL, 1512478971, 1513408158, 1, '3ba8ff161f1275b8e12b4293664a6c1a', '2017-12-16 06:16:20', '2017-12-16 00:01:41'),
(14, '::1', 'si_cantik', '$2y$08$reoz4s8IGbzYLTpPnWrUseDqcpoIj5mth.cQ/Cv0ODgM4BieEeqP2', NULL, 'sidia@asmith.my.id', NULL, NULL, NULL, NULL, 1512626651, 1513406380, 1, NULL, '2017-12-16 06:16:20', '2017-12-16 06:16:20'),
(26, '::1', 'is_new', '$2y$08$frgO9NakQC6sS/K22Za37.5tqIuE25ofPiby4txzrB3Lua/tGA162', NULL, 'adhi.sumitro@hotmail.com', '9c6363dfc428e5a4cf4a745bcdec5c5ccdc7eaef', NULL, NULL, NULL, 1513406706, 1513406723, 0, NULL, '2017-12-16 06:45:06', '2017-12-16 06:45:06'),
(30, '', 'user_baru', '$2y$10$.Uex63Xl8YzBiYFOCa.ukO.jZg5EkUi.Qh2L1wALu8AX/lLfSplzS', NULL, 'test@asmith.my.id', NULL, NULL, NULL, NULL, 0, NULL, 1, 'aa3a259b0b91434bcc1a9681b68366db', '2017-12-16 00:22:41', '2017-12-16 00:22:41');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users_details`
--

CREATE TABLE `users_details` (
  `id` int(11) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `avatar` varchar(50) NOT NULL,
  `company` varchar(75) DEFAULT NULL,
  `position` varchar(75) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `users_details`
--

INSERT INTO `users_details` (`id`, `user_id`, `full_name`, `phone`, `avatar`, `company`, `position`, `created_at`, `updated_at`) VALUES
(1, 13, 'Agus Adhi Sumitro', '+6282271115593', 'qwe.png', 'Gembel Code', 'Tukang cat', '2017-12-15 23:32:15', '2017-12-15 23:32:15'),
(2, 14, 'Bunga Sidia Inisial', '+6282233445566', 'dokter.png', 'Apotik Cinta Medika', 'Dokter Cinta', '2017-12-15 23:32:15', '2017-12-15 23:32:15'),
(11, 26, 'new user', '123', '', NULL, NULL, '2017-12-16 06:45:06', '2017-12-16 06:45:06'),
(15, 30, 'Test Akun', '+6277777777', '', NULL, NULL, '2017-12-16 00:22:41', '2017-12-16 00:22:41');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`, `created_at`, `updated_at`) VALUES
(74, 13, 1, '2017-12-15 22:56:22', '2017-12-15 22:56:22'),
(112, 14, 2, '2017-12-16 06:39:05', '2017-12-16 06:39:05'),
(113, 26, 2, '2017-12-16 06:45:06', '2017-12-16 06:45:06'),
(117, 30, 2, '2017-12-16 00:22:41', '2017-12-16 00:22:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rest_crud`
--
ALTER TABLE `rest_crud`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_setting`
--
ALTER TABLE `site_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `avatar` (`api_token`);

--
-- Indexes for table `users_details`
--
ALTER TABLE `users_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `rest_crud`
--
ALTER TABLE `rest_crud`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `site_setting`
--
ALTER TABLE `site_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users_details`
--
ALTER TABLE `users_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `users_details`
--
ALTER TABLE `users_details`
  ADD CONSTRAINT `users_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
