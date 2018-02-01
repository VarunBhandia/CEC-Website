-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 01, 2018 at 03:30 PM
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
(1, 'Blog1', 'Test test Test testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest testTest test', '1', 1, '', '2018-01-16 07:37:22', 0),
(2, 'Varun', 'dhgcdahcfsauyctfsauyctfscjhsvacytsuc', '2', 2, '', '2018-01-13 16:22:58', 0),
(3, 'Varun', 'dhgcdahcfsauyctfsauyctfscjhsvacytsuc', '2', 2, '', '2018-01-13 16:23:04', 0),
(4, 'kjkdjkhdgsifyug', 'akjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyakjefheaiugfyvv', '1', 1, '', '2018-01-16 07:36:51', 0),
(5, 'jhafyagf', 'asjdhgkajdghfhgfttufsadty', '1', 1, '', '2018-01-15 18:05:48', 0),
(6, 'sdjkcgdsiycf', 'jesfgiyeatsf', '1', 1, '', '2018-01-15 18:05:52', 0),
(7, 'dskjgciydstc', 'skdjhgcfydtscf', '2', 2, '', '2018-01-15 18:05:55', 0),
(8, 'GHDFTYD', 'SAGDFTSYA', '2', 1, '', '2018-01-15 18:40:11', 0),
(9, 'AKJUDGAIYTDF', 'jsjdhfguydsfgiyug', '1', 1, '', '2018-01-15 18:40:16', 0);

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
(1, 'varun', '', '', 'secy', 'Second'),
(2, 'varun2', '', '', 'secy2', 'second'),
(3, 'varun3', '', '', '', ''),
(4, 'varun4', '', '', '', ''),
(5, 'varun5', '', '', '', ''),
(6, 'varun6', '', '', '', ''),
(7, 'varun7', '', '', '', ''),
(8, 'varun8', '', '', '', ''),
(9, 'varun9', '', '', '', ''),
(10, 'varun10', '', '', '', '');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
