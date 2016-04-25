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
-- Table structure for table `funcTypes`
--

DROP TABLE IF EXISTS `funcTypes`;
CREATE TABLE IF NOT EXISTS `funcTypes` (
  `unitId` varchar(10) NOT NULL COMMENT 'Unit / Location',
  `funcType` int(11) NOT NULL COMMENT 'Function Number',
  `funcDescr` varchar(20) NOT NULL COMMENT 'Function Description',
  `defCovers` smallint(6) NOT NULL COMMENT 'Default Covers',
  PRIMARY KEY (`unitId`,`funcType`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `funcTypes`
--

INSERT INTO `funcTypes` (`unitId`, `funcType`, `funcDescr`, `defCovers`) VALUES
('337W0', 1, 'Breakfast', 16),
('337W0', 2, 'Lunch', 16),
('337W0', 3, 'Dinner', 15),
('337W0', 4, 'Coffee AM', 0),
('337W0', 5, 'Coffee PM', 0),
('337W0', 6, 'Conference AM', 0),
('337W0', 7, 'Conference PM', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
