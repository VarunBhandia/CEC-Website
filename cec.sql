-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 16, 2018 at 04:00 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cec`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Geomatics'),
(2, 'Structure');

-- --------------------------------------------------------

--
-- Table structure for table `cec-blog`
--

CREATE TABLE `cec-blog` (
  `id` int(11) NOT NULL,
  `Topic` varchar(255) NOT NULL,
  `Texteditor` text NOT NULL,
  `Category` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `imagename` varchar(255) NOT NULL,
  `modified_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `visitorcount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cec-blog`
--

INSERT INTO `cec-blog` (`id`, `Topic`, `Texteditor`, `Category`, `status`, `imagename`, `modified_time`, `visitorcount`) VALUES
(16, 'ghfdsr', 'Fuck u', '', 1, '', '2018-02-04 14:21:16', 0),
(17, 'idgcfdygcv', '&lt;p&gt;jxhcghdsc vcj&lt;/p&gt;', '', 1, '', '2018-02-04 14:22:58', 0);

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `post` varchar(255) NOT NULL,
  `year` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id`, `name`, `img`, `link`, `post`, `year`) VALUES
(1, 'varun', '1.jpg', '', 'secy', 'Second'),
(2, 'varun2', '1.jpg', '', 'secy2', 'second'),
(3, 'varun3', '1.jpg', '', '', ''),
(4, 'varun4', '1.jpg', '', '', ''),
(5, 'varun5', '1.jpg', '', '', ''),
(6, 'varun6', '1.jpg', '', '', ''),
(7, 'varun7', '1.jpg', '', '', ''),
(8, 'varun8', '1.jpg', '', '', ''),
(9, 'varun9', '1.jpg', '', '', ''),
(10, 'varun10', '1.jpg', '', '', ''),
(11, 'Varun Bhandia', '1.jpg', '', 'secy108', 'Second'),
(12, 'Varun Bhandia', '1.jpg', '', 'cooooo', 'Second'),
(13, 'Varun Bhandia', '1.jpg', '', 'cccccc', 'dddddddd'),
(14, 'Varun Bhandia', '1.jpg', '', 'cccccc', 'dddddddd');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cec-blog`
--
ALTER TABLE `cec-blog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `cec-blog`
--
ALTER TABLE `cec-blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
