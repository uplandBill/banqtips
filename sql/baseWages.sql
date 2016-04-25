-- phpMyAdmin SQL Dump
-- version 3.4.11.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 28, 2013 at 03:25 PM
-- Server version: 5.5.29
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `averyrco_tipspay`
--

-- --------------------------------------------------------

--
-- Table structure for table `baseWages`
--

DROP TABLE IF EXISTS `baseWages`;
CREATE TABLE IF NOT EXISTS `baseWages` (
  `unitId` varchar(10) NOT NULL COMMENT 'Unit Id',
  `funcType` int(11) NOT NULL COMMENT 'Function Type',
  `emplClass` varchar(3) NOT NULL COMMENT 'Employee Class',
  `baseWage` decimal(8,2) NOT NULL COMMENT 'Default Wage'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `baseWages`
--

INSERT INTO `baseWages` (`unitId`, `funcType`, `emplClass`, `baseWage`) VALUES
('337W0', 1, '6', 24.21),
('337W0', 1, '8', 22.01),
('337W0', 2, '6', 24.21),
('337W0', 2, '8', 22.01),
('337W0', 3, '6', 25.71),
('337W0', 3, '8', 23.51),
('337W0', 4, '6', 24.21),
('337W0', 4, '8', 22.01),
('337W0', 5, '6', 25.71),
('337W0', 5, '8', 24.21),
('337W0', 6, '6', 25.71),
('337W0', 6, '8', 24.21),
('337W0', 7, '6', 25.71),
('337W0', 7, '8', 24.21);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
