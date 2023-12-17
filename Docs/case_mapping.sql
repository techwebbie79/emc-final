-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2022 at 02:18 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecourt_em`
--

-- --------------------------------------------------------

--
-- Table structure for table `case_mapping`
--

CREATE TABLE `case_mapping` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `district_id` int(11) DEFAULT NULL,
  `upazilla_id` int(11) DEFAULT NULL,
  `status` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `case_mapping`
--

INSERT INTO `case_mapping` (`id`, `user_id`, `district_id`, `upazilla_id`, `status`) VALUES
(24, 35, 13, 49, 1),
(25, 35, 13, 50, 1),
(26, 35, 13, 51, 0),
(27, 35, 13, 514, 1),
(28, 35, 13, 512, 1),
(29, 35, 13, 59, 0),
(30, 34, 13, 49, 1),
(31, 34, 13, 55, 0),
(32, 34, 13, 59, 1),
(33, 34, 13, 512, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `case_mapping`
--
ALTER TABLE `case_mapping`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `case_mapping`
--
ALTER TABLE `case_mapping`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
