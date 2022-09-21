-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 08, 2022 at 03:03 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `videodb`
--

-- --------------------------------------------------------

--
-- Table structure for table `convertedvideo`
--

CREATE TABLE `convertedvideo` (
  `conversionID` int(11) NOT NULL,
  `video_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `date_time` datetime NOT NULL,
  `original_format` varchar(10) NOT NULL,
  `target_format` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `convertedvideo`
--

INSERT INTO `convertedvideo` (`conversionID`, `video_name`, `file_path`, `date_time`, `original_format`, `target_format`) VALUES
(10, 'sample', 'C:\\Users\\chilc\\Desktop\\Web-Services\\Logging', '2022-09-08 03:00:59', 'mp4', 'avi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `convertedvideo`
--
ALTER TABLE `convertedvideo`
  ADD PRIMARY KEY (`conversionID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `convertedvideo`
--
ALTER TABLE `convertedvideo`
  MODIFY `conversionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
