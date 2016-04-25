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
-- Table structure for table `translates`
--

DROP TABLE IF EXISTS `translates`;
CREATE TABLE IF NOT EXISTS `translates` (
  `unitId` varchar(10) NOT NULL COMMENT 'Unit Id',
  `fieldName` varchar(15) NOT NULL COMMENT 'Field Name',
  `fieldValue` varchar(3) NOT NULL COMMENT 'Field Value',
  `effdt` date NOT NULL COMMENT 'Effective Date',
  `effStatus` varchar(1) NOT NULL COMMENT 'Effective Status',
  `descr` varchar(30) NOT NULL COMMENT 'Description',
  `descrShort` varchar(10) NOT NULL COMMENT 'Short Description',
  UNIQUE KEY `unitId` (`unitId`,`fieldName`,`fieldValue`,`effdt`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `translates`
--

INSERT INTO `translates` (`unitId`, `fieldName`, `fieldValue`, `effdt`, `effStatus`, `descr`, `descrShort`) VALUES
('337W0', 'emplClass', '6', '2012-12-01', 'A', 'Full Time', 'Full Time'),
('337W0', 'emplClass', '8', '2012-12-01', 'A', 'Pool', 'Pool'),
('337W0', 'ecMeth', '1', '2012-12-01', 'A', 'Empl Class Field', 'Empl Class'),
('337W0', 'ecMeth', '2', '2012-12-01', 'A', 'Pay Group Field', 'Pay Group'),
('337W0', 'emplStatus', 'A', '2012-12-01', 'A', 'Active', 'Active'),
('337W0', 'emplStatus', 'T', '2012-12-01', 'A', 'Terminated', 'Terminated');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
