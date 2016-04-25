-- phpMyAdmin SQL Dump
-- version 3.4.11.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 28, 2013 at 03:28 PM
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
-- Table structure for table `units`
--

DROP TABLE IF EXISTS `units`;
CREATE TABLE IF NOT EXISTS `units` (
  `unitId` varchar(7) NOT NULL,
  `unitName` varchar(50) NOT NULL,
  `unitStatus` varchar(1) NOT NULL,
  `wkendDay` varchar(8) NOT NULL COMMENT 'Wkend Day',
  `ecMeth` varchar(1) NOT NULL COMMENT 'Empl Class Method',
  `csvFormat` varchar(1) NOT NULL COMMENT 'CSV File Format',
  `lastTempId` bigint(11) NOT NULL COMMENT 'Last Temporary Id',
  PRIMARY KEY (`unitId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`unitId`, `unitName`, `unitStatus`, `wkendDay`, `ecMeth`, `csvFormat`, `lastTempId`) VALUES
('337W0', 'Marriott Wardman Park', 'A', 'Friday', '2', '1', 99000003),
('33777', 'MerryRot Int', 'A', 'Friday', '1', '', 99000000);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
