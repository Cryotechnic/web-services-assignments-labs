-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2022 at 04:15 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `video`
--
CREATE DATABASE IF NOT EXISTS `video` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `video`;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(72) NOT NULL,
  `licenseStart` date NOT NULL DEFAULT current_timestamp(),
  `licenseEnd` date NOT NULL DEFAULT current_timestamp(),
  `licenseKey` varchar(20) NOT NULL,
  `licenseNumber` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password_hash`, `licenseStart`, `licenseEnd`, `licenseKey`, `licenseNumber`) VALUES
(5, '1', '$2y$10$qe.jmTCwOwYMHtH5qm0zHeKXwuZfUI4xM9oivnShEAzADn8rQMYTK', '2022-03-30', '2025-03-19', '1234', '12345'),
(6, 'Dharmin', '$2y$10$C5ton7p8zVCDB6oG749KNev4GgdPxo8dDrdMX2bkRKXtlc.qaY3Im', '2022-03-30', '2022-03-30', '', '1234'),
(8, 'John', '$2y$10$PjEej049BV1baEpbHDdouephdri53D0jWB6q.WqQBPE8bzNoJPDNi', '2022-03-30', '2022-03-30', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `video`
--

DROP TABLE IF EXISTS `video`;
CREATE TABLE `video` (
  `video_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `video` varchar(50) NOT NULL,
  `newVideo` varchar(50) NOT NULL,
  `requestTime` timestamp NOT NULL DEFAULT current_timestamp(),
  `completeTime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `video`
--

INSERT INTO `video` (`video_id`, `user_id`, `video`, `newVideo`, `requestTime`, `completeTime`) VALUES
(72, 6, 'file_example_MP4_1920_18MG.mp4', '202201191642624059.avi', '2022-01-19 20:27:39', '2022-01-19 20:27:44'),
(73, 6, 'test.mp4', '202201191642624067.avi', '2022-01-19 20:27:47', '2022-01-19 20:27:48'),
(74, 6, 'file_example_MP4_1920_18MG.mp4', '202201191642630790.avi', '2022-01-19 22:19:50', '2022-01-19 22:19:55'),
(75, 6, 'test.mp4', '202201241643030642.avi', '2022-01-24 13:24:02', '2022-01-24 13:24:05'),
(76, 6, 'test.mp4', '202201241643043839.avi', '2022-01-24 17:03:59', '2022-01-24 17:04:00'),
(77, 6, 'test.mp4', '202202251645819561.avi', '2022-02-25 20:06:01', '2022-02-25 20:06:04'),
(78, 6, 'C://Users//Dharmin//Downloads//test.mp4', '202204031649001800', '2022-04-03 16:03:20', '2022-04-03 16:03:20'),
(79, 6, 'C://Users//Dharmin//Downloads//test.mp4', '202204031649020818', '2022-04-03 21:20:18', '2022-04-03 21:20:18'),
(80, 6, 'C://Users//Dharmin//Downloads//test.mp4', '202204031649021013', '2022-04-03 21:23:33', '2022-04-03 21:23:33'),
(81, 6, 'C://Users//Dharmin//Downloads//test.mp4', '202204031649021068', '2022-04-03 21:24:28', '2022-04-03 21:24:28'),
(82, 6, 'C://Users//Dharmin//Downloads//test.mp4', '202204031649021199', '2022-04-03 21:26:39', '2022-04-03 21:26:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`video_id`),
  ADD KEY `video_to_user` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `video`
--
ALTER TABLE `video`
  MODIFY `video_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `video`
--
ALTER TABLE `video`
  ADD CONSTRAINT `video_to_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
