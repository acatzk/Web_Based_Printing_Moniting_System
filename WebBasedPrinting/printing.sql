-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2019 at 01:41 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `printing`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `account_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `username`, `password`, `email`, `status`, `account_type`) VALUES
(1, 'Gayle', 'Dela Torre', 'gayle', 'gayle', 'julius@gmail.com', 'Active', 'User'),
(2, 'Paul', 'Vanzuela', 'admin', 'admin', 'paulvanzuela@gmail.com', 'Active', 'Administrator'),
(3, 'Jerwin', 'Gilo', 'admin2', 'admin2', 'jerwin@gmail.com', 'Inactive', 'Administrator'),
(4, 'Nicco', 'Casinillo', 'tae', 'tae', 'nicco@gmail.com', 'Inactive', 'Administrator'),
(5, 'baboy', 'gago', 'baboy', 'baboy', 'asdf@gmail.com', 'Active', 'User'),
(6, 'The', 'Quick Bronw', 'adfasdf', 'dg', 'dgdsg@gmal.com', 'Inactive', 'User'),
(11, 'bbbbb', 'bbb', 'bbb', 'bbb', 'bbb@gmail.com', 'Active', 'User'),
(19, 'admin3', 'admin3', 'admin3', 'admin3', 'admin3@gmail.com', 'Active', 'Administrator'),
(20, 'sdfsdf', 'sdf', 'sdfsd', 'sdfsd', 'sdfffff@gmail.com', 'Active', 'User'),
(21, 'hhh', 'hhh', 'hhh', 'hhhh', 'hhh@gmail.com', 'Inactive', 'User');

-- --------------------------------------------------------

--
-- Table structure for table `user_files`
--

CREATE TABLE `user_files` (
  `id` int(11) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `date` varchar(100) NOT NULL,
  `filename` varchar(50) NOT NULL,
  `path` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_files`
--

INSERT INTO `user_files` (`id`, `user_id`, `date`, `filename`, `path`) VALUES
(3, '5', '4/22/2019', 'jounal', 'documents/ojt journal format.docx'),
(7, '5', '4/22/2019', 'fgdfgd', 'documents/44872063_342350606526088_7084106761531031552_n.jpg'),
(12, '1', '04/24/19', '8 Secrets', 'documents/8secrets.pdf'),
(13, '1', '04/24/19', 'Rich Dad Poor Dad', 'documents/rich.pdf'),
(14, '1', '04/24/19', 'Monthly Reports', 'documents/monthly report_apilan.docx'),
(15, '1', '04/24/19', 'Black Book of Virus', 'documents/Black Book of Viruses and Hacking.pdf'),
(16, '1', '04/25/19', 'I will teach you how to become rich', 'documents/I-Will-Teach-You-To-Be-Rich_Chapter1.pdf'),
(17, '1', '04/25/19', 'Real Estate Stuff', 'documents/1340495.pdf'),
(18, '1', '04/25/19', 'Think and Grow Rich', 'documents/NapoleonHill-Think-and-Grow-Rich.pdf'),
(19, '5', '04/27/19', '8 Secrets', 'documents/8secrets.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `user_printing`
--

CREATE TABLE `user_printing` (
  `id` int(11) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `date` varchar(50) NOT NULL,
  `date2` varchar(50) NOT NULL,
  `filename` varchar(50) NOT NULL,
  `time` varchar(50) NOT NULL,
  `paper_size` varchar(50) NOT NULL,
  `no_pages` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_printing`
--

INSERT INTO `user_printing` (`id`, `user_id`, `date`, `date2`, `filename`, `time`, `paper_size`, `no_pages`) VALUES
(20, '1', '02/27/2019', '02/27/2019', 'Think and Grow Rich', '07:14:39 am', 'A5', '7'),
(21, '5', '04/27/2018', '04/27/2018', '8 Secrets', '07:15:27 am', 'A5', '6'),
(22, '1', '04/28/2019', '04/28/2019', 'Rich Dad Poor Dad', '07:09:05 pm', 'Letter', '32'),
(23, '1', '04/28/2019', '04/28/2019', '8 Secrets', '07:25:26 pm', 'Tabloid', '75');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `fname` (`fname`,`lname`);

--
-- Indexes for table `user_files`
--
ALTER TABLE `user_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_printing`
--
ALTER TABLE `user_printing`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `user_files`
--
ALTER TABLE `user_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user_printing`
--
ALTER TABLE `user_printing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
