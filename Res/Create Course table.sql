-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 08-Abr-2017 às 14:31
-- Versão do servidor: 10.1.10-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vanhackathon17`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `course`
--

CREATE TABLE `course` (
  `id_course` bigint(20) UNSIGNED NOT NULL,
  `id_category` bigint(2) NOT NULL,
  `id_educator` bigint(100) NOT NULL,
  `title` varchar(200) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin,
  `registerdate` datetime DEFAULT NULL,
  `videolink` varchar(1000) COLLATE utf8_bin DEFAULT NULL,
  `time` time NOT NULL,
  `setuptime` time NOT NULL,
  `cost` decimal(10,0) NOT NULL,
  `audience_min` int(11) DEFAULT NULL,
  `audience_max` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `course`
--

INSERT INTO `course` (`id_course`, `id_category`, `id_educator`, `title`, `description`, `registerdate`, `videolink`, `time`, `setuptime`, `cost`, `audience_min`, `audience_max`) VALUES
(1, 1, 0, 'First Lunch n'' Learn', 'First Lunch n'' Learn', '2017-04-08 02:04:42', 'First Lunch n'' Learn', '00:00:02', '00:00:03', '1', 4, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id_course`),
  ADD UNIQUE KEY `id_laudotopico` (`id_course`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id_course` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
