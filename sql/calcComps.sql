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
-- Table structure for table `calcComps`
--

DROP TABLE IF EXISTS `calcComps`;
CREATE TABLE IF NOT EXISTS `calcComps` (
  `unitId` varchar(10) NOT NULL COMMENT 'Unit Id',
  `funcType` int(11) NOT NULL COMMENT 'Function Type',
  `eeType` smallint(6) NOT NULL COMMENT 'Employee Type',
  `foodMeth` varchar(1) NOT NULL COMMENT 'Food Comp Method',
  `barMeth` varchar(1) NOT NULL COMMENT 'Bar Comp Method',
  UNIQUE KEY `unitId` (`unitId`,`funcType`,`eeType`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `calcComps`
--

INSERT INTO `calcComps` (`unitId`, `funcType`, `eeType`, `foodMeth`, `barMeth`) VALUES
('337W0', 1, 1, '1', '1'),
('337W0', 2, 1, '1', '1'),
('337W0', 3, 1, '1', '1'),
('337W0', 4, 1, '1', '1'),
('337W0', 5, 1, '1', '1'),
('337W0', 6, 1, '1', '1'),
('337W0', 7, 1, '1', '1'),
('337W0', 1, 2, '1', '1'),
('337W0', 2, 2, '1', '1'),
('337W0', 3, 2, '1', '1'),
('337W0', 4, 2, '1', '1'),
('337W0', 5, 2, '1', '1'),
('337W0', 6, 2, '1', '1'),
('337W0', 7, 2, '1', '1'),
('337W0', 1, 3, '2', '1'),
('337W0', 2, 3, '2', '1'),
('337W0', 3, 3, '2', '1'),
('337W0', 4, 3, '1', '1'),
('337W0', 5, 3, '1', '1'),
('337W0', 6, 3, '2', '1'),
('337W0', 7, 3, '1', '1'),
('337W0', 1, 4, '1', '1'),
('337W0', 2, 4, '1', '1'),
('337W0', 3, 4, '1', '1'),
('337W0', 4, 4, '1', '1'),
('337W0', 5, 4, '1', '1'),
('337W0', 6, 4, '1', '1'),
('337W0', 7, 4, '1', '1'),
('337W0', 1, 5, '1', '1'),
('337W0', 2, 5, '1', '1'),
('337W0', 3, 5, '1', '1'),
('337W0', 4, 5, '1', '1'),
('337W0', 5, 5, '1', '1'),
('337W0', 6, 5, '1', '1'),
('337W0', 7, 5, '1', '1');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
