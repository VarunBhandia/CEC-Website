-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 07, 2019 at 01:14 PM
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

-- --------------------------------------------------------

--
-- Table structure for table `cec-marvel`
--

CREATE TABLE `cec-marvel` (
  `id` int(11) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `name` varchar(30) NOT NULL,
  `img` varchar(50) NOT NULL,
  `enrollment_no` varchar(50) NOT NULL,
  `abstract` varchar(250) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(13, 'Dr.G.D. Ransinchung R.N.', '1.jpg', '', 'Convener', 'Associate Professor'),
(14, 'Dr. Gargi Singh', '2.jpg', '', 'Co-Convener', 'Associate Professor'),
(15, 'Pracheer Mehra', '3.JPG', '', 'President', 'IV'),
(16, 'Srishti Katiyar', '4.jpg', '', 'Vice-President', 'IV'),
(17, 'Kanchan Shrivastava', '5.jpg', '', 'Vice-President(Events and Culture)', 'IV'),
(18, 'Sarvesh Gandhi', '6.jpg', '', 'Secretary', 'III'),
(19, 'Varun Bhandia', '7.jpg', '', 'Manager(Web-D)', 'III'),
(20, 'Anant Agrawal', '8.jpg', '', 'Manager(Design)', 'III'),
(21, 'Tapan S. chauhan', '9.jpg', '', 'Manager(Finance)', 'III'),
(22, 'Surabhi Agarwal', '10.jpg', '', 'Manager(Events and Culture)', 'III'),
(23, 'Ankit Garg', '11.jpg', '', 'Member', 'II'),
(25, 'Muneeb Ahmad', '18.JPG', '', 'Member', 'II'),
(26, 'Rahul Yadav', '17.jpg', '', 'Member', 'II'),
(27, 'Nikita Singh', '12.jpg', '', 'Member', 'II'),
(28, 'Vishesh Prakash Srivastava', '21.jpg', '', 'Member', 'II'),
(29, 'Vedant Kumar', '20.jpg', '', 'Member', 'II'),
(30, 'Jay Modi', '19.jpg', '', 'Member', 'II'),
(31, 'Nikhil Raizada', '22.jpg', '', 'Member', 'II'),
(32, 'Vikas Agarwal', '23.jpg', '', 'Member', 'II');

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
-- Indexes for table `cec-marvel`
--
ALTER TABLE `cec-marvel`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cec-marvel`
--
ALTER TABLE `cec-marvel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
