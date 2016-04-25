-- phpMyAdmin SQL Dump
-- version 3.4.11.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 28, 2013 at 03:26 PM
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
-- Table structure for table `depts`
--

DROP TABLE IF EXISTS `depts`;
CREATE TABLE IF NOT EXISTS `depts` (
  `unitId` varchar(7) NOT NULL,
  `deptId` varchar(10) NOT NULL COMMENT 'deptId',
  `effdt` date NOT NULL,
  `deptDescr` varchar(30) NOT NULL COMMENT 'Department Name',
  `baseWage` decimal(7,2) NOT NULL,
  UNIQUE KEY `unitId` (`unitId`,`deptId`,`effdt`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `depts`
--

INSERT INTO `depts` (`unitId`, `deptId`, `effdt`, `deptDescr`, `baseWage`) VALUES
('33967', '000000', '2012-12-01', 'External', 0.00),
('337W0', '009000', '2012-12-01', '009000', 0.00),
('337W0', '021100', '2012-12-01', '021100', 0.00),
('337W0', '023000', '2012-12-01', 'Banquets', 23.00),
('337W0', '041000', '2012-12-01', '041000', 0.00),
('337W0', '0011W2', '2012-12-01', 'Front Office', 0.00),
('337W0', '0012W1', '2012-12-01', '0012W1', 0.00),
('337W0', '0020W6', '2012-12-01', '0020W6', 0.00),
('337W0', '0030W7', '2012-12-01', '0030W7', 0.00),
('337W0', '0090W8', '2012-12-01', '0090W8', 0.00),
('337W0', '0190W9', '2012-12-01', '0190W9', 0.00),
('337W0', '0221WB', '2012-12-01', 'Lobby Lounge', 0.00),
('337W0', '0430W5', '2012-12-01', 'Dept 0430W5', 0.00),
('337W0', '0271WG', '2012-12-01', 'Woodley Market', 0.00),
('337W0', '0190WQ', '2012-12-01', 'Kitchen', 0.00),
('337W0', '0190WT', '2012-12-01', 'Kitchen', 0.00),
('33777', '10000', '2012-12-01', 'Test Dept', 21.00),
('337W0', '000001', '2012-12-01', 'The House Account', 0.00),
('337W0', '0230WC', '2012-12-01', 'Banquets', 25.71),
('337W0', '0261WF', '2012-12-01', 'Harry''s Pub', 0.00),
('337W0', '0230WJ', '2012-12-01', 'Banquets', 0.00),
('337W0', '0240WD', '2012-12-01', 'Room Service', 22.00),
('337W0', '000000', '2012-12-01', 'External', 0.00),
('337W0', '0211WA', '2012-12-01', 'Restuarant', 0.00);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
