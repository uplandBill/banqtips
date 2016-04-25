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
-- Table structure for table `cutGroupTypes`
--

DROP TABLE IF EXISTS `cutGroupTypes`;
CREATE TABLE IF NOT EXISTS `cutGroupTypes` (
  `unitId` varchar(7) NOT NULL COMMENT 'Unit / Location',
  `groupType` varchar(12) NOT NULL COMMENT 'Cut Group Type',
  `eeType` smallint(6) NOT NULL COMMENT 'EE Type',
  UNIQUE KEY `unitId` (`unitId`,`groupType`,`eeType`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cutGroupTypes`
--

INSERT INTO `cutGroupTypes` (`unitId`, `groupType`, `eeType`) VALUES
('337W0', 'Captains', 1),
('337W0', 'House', 2),
('337W0', 'Staff', 3),
('337W0', 'Staff', 4),
('337W0', 'Waiters', 3);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
