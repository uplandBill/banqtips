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
-- Table structure for table `wkendCal`
--

DROP TABLE IF EXISTS `wkendCal`;
CREATE TABLE IF NOT EXISTS `wkendCal` (
  `unitId` varchar(10) NOT NULL COMMENT 'Unit / Location',
  `wkendDate` date NOT NULL COMMENT 'Weekend Date',
  `weekStatus` varchar(1) NOT NULL COMMENT 'Week / Proc Status',
  `firstFuncNum` int(11) NOT NULL COMMENT 'First Function Number',
  `lastFuncNum` int(11) NOT NULL COMMENT 'Last Func Entered',
  PRIMARY KEY (`unitId`,`wkendDate`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wkendCal`
--

INSERT INTO `wkendCal` (`unitId`, `wkendDate`, `weekStatus`, `firstFuncNum`, `lastFuncNum`) VALUES
('337W0', '2012-12-28', 'C', 0, 0),
('337W0', '2012-12-14', 'C', 0, 0),
('33777', '2013-01-11', 'O', 0, 0),
('337W0', '2012-12-07', 'O', 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
