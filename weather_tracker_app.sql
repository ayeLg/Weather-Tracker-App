-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2022 at 08:12 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `php_api_jwt`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(45) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_email`, `user_password`, `created_at`) VALUES
(1, 'arnt', 'arnt@gmail.com', 'arnt', '2022-06-12 22:48:10'),
(2, 'arnt', 'arnt@gmail.com', 'arnt', '2022-06-12 22:48:10'),
(3, 'aung', 'aung@gmail.com', 'aung', '2022-06-12 22:53:55'),
(4, 'aung', 'aung@gmail.com', 'aung', '2022-06-12 22:53:55');

-- --------------------------------------------------------

--
-- Table structure for table `weather`
--

CREATE TABLE `weather` (
  `weather_id` int(11) NOT NULL,
  `weather` varchar(255) NOT NULL,
  `weather_temp` varchar(255) NOT NULL,
  `date` varchar(45) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `weather`
--

INSERT INTO `weather` (`weather_id`, `weather`, `weather_temp`, `date`, `user_id`, `created_at`) VALUES
(1, 'broken clouds', '26.25', '2022-06-06', 2, '2022-06-12 22:51:35'),
(2, 'broken clouds', '26.25', '2022-06-01', 4, '2022-06-12 22:54:05'),
(3, 'broken clouds', '26.25', '2022-05-29', 4, '2022-06-12 22:56:14'),
(6, 'broken clouds', '26.25', '2022-06-13', 4, '2022-06-13 00:24:22'),
(8, 'broken clouds', '26.25', '2022-06-13', 4, '2022-06-13 00:26:55'),
(9, 'broken clouds', '26.25', '2022-06-13', 4, '2022-06-13 00:28:03'),
(10, 'broken clouds', '26.25', '2022-06-13', 4, '2022-06-13 00:33:34'),
(11, 'broken clouds', '26.25', '2022-06-11', 4, '2022-06-13 00:35:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `weather`
--
ALTER TABLE `weather`
  ADD PRIMARY KEY (`weather_id`),
  ADD KEY `user_weather` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `weather`
--
ALTER TABLE `weather`
  MODIFY `weather_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `weather`
--
ALTER TABLE `weather`
  ADD CONSTRAINT `user_weather` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
