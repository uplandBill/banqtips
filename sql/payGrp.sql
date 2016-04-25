-- phpMyAdmin SQL Dump
-- version 3.4.11.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 28, 2013 at 03:27 PM
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
-- Table structure for table `payGrp`
--

DROP TABLE IF EXISTS `payGrp`;
CREATE TABLE IF NOT EXISTS `payGrp` (
  `unitId` varchar(10) NOT NULL COMMENT 'Unit Id',
  `payGrp` varchar(2) NOT NULL COMMENT 'Pay Group',
  `effdt` date NOT NULL COMMENT 'Effective Date',
  `effStatus` varchar(1) NOT NULL COMMENT 'Effective Status',
  `payGrpDescr` varchar(15) NOT NULL COMMENT 'Pay Group Descr',
  `emplClass` varchar(1) NOT NULL COMMENT 'Employee Class',
  UNIQUE KEY `unitId` (`unitId`,`payGrp`,`effdt`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payGrp`
--

INSERT INTO `payGrp` (`unitId`, `payGrp`, `effdt`, `effStatus`, `payGrpDescr`, `emplClass`) VALUES
('337W0', '25', '2012-12-01', 'A', 'Group 25', '6'),
('337W0', '26', '2012-12-01', 'A', 'Group 26', '8'),
('337W0', '33', '2012-12-01', 'A', 'Group 33', '8'),
('337W0', '35', '2012-12-01', 'A', 'Group 35', '8'),
('337W0', '11', '2012-12-01', 'A', 'Group 11', '8'),
('337W0', '34', '2012-12-01', 'A', 'Group 34', '6');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
