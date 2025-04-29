-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 29, 2025 at 04:21 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `marketplace_pemweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `price` int NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`) VALUES
(1, 'Camera Fuji Film', 'Kamera Untuk Foto', 1000000, 'c3cc531b73e6b0df5923a38c2ccbecd0f4a38932eee237d808eed7cca695ca87.jpeg'),
(2, 'Lipstick', 'Lipstick Bibir', 150000, '7319f55c8c8bb6c6a4a667170ee7e7405059f6d7a9a063252367f69697817eb3.jpeg'),
(3, 'Thinkpad', 'Thinkpad Untuk Bekerja', 5000000, '139362c81cebc55c81feb312eb7dd9e6880c71bce2e06588878e070e3f31e636.jpeg'),
(4, 'Jam Tangan', 'Jam Tangan Mewah', 4000000, '727cd8792e70d2f913e45a6a7103af16b8aa7f7e8d42dfc98ff5542e986ed982.png'),
(5, 'Headset', 'Headset Gaming', 900000, 'db4591ec82be4ea475f4d152d7989fff855cc2b340fad952d969562499860572.jpeg'),
(6, 'Sepatu', 'Sepatu Untuk Lari', 1500000, 'e364aa87c4f2d893b19fbd594ccb34c34154e5eb3bbc624243739f217b29ca7e.jpg'),
(9, 'Pocari Sweat', 'Minuman ber-Ion', 8000, 'fd2b4ae26c575fb932d946fbab6eab286ed3615351132ab46cf3e7cd5d01a6d7.jpg'),
(10, 'Mini Bite', 'Cemilan Enak &amp; Sehat', 10000, '74846a30e5a4416c42be60def2bab7838adddebd97bf551942715c4b6755b05b.png'),
(27, 'Soundcore R50i', 'TWS Untuk Motoran', 195000, 'af5439985768bd2c83a2b024fde7778ef14edb2e13c62bc0b773920f6af10963.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(6, 'ellorabyndra', 'ellorabyndra@gmail.com', '$2y$10$bFZEfRC/6jT1kplXF3EDpuraN7DQkoNBPJJ42cEQjrrbkJHAwzRLW', '2025-04-28 03:28:03'),
(7, 'User', 'user@gmail.com', '$2y$10$pRgon66JPHXq0tt2fUL4M.qOxI/iGHueYza.QmPCo2IAWaFUgxoF6', '2025-04-29 16:06:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
