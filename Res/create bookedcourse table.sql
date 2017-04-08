-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 08-Abr-2017 às 16:06
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
-- Estrutura da tabela `bookedcourse`
--

CREATE TABLE `bookedcourse` (
  `id_bookedcourse` bigint(20) UNSIGNED NOT NULL,
  `id_company` int(11) NOT NULL,
  `id_course` int(11) NOT NULL,
  `pretenddate` date NOT NULL,
  `realdate` date DEFAULT NULL,
  `bundlefood` char(1) COLLATE utf8_bin DEFAULT NULL,
  `dietaryrestriction` text COLLATE utf8_bin,
  `registerdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `bookedcourse`
--

INSERT INTO `bookedcourse` (`id_bookedcourse`, `id_company`, `id_course`, `pretenddate`, `realdate`, `bundlefood`, `dietaryrestriction`, `registerdate`) VALUES
(1, 0, 1, '2017-04-07', '2017-04-08', 'S', 'asdvasd', '2017-04-08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookedcourse`
--
ALTER TABLE `bookedcourse`
  ADD UNIQUE KEY `id_bookedcourse` (`id_bookedcourse`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookedcourse`
--
ALTER TABLE `bookedcourse`
  MODIFY `id_bookedcourse` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
