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
-- Table structure for table `rooms`
--

DROP TABLE IF EXISTS `rooms`;
CREATE TABLE IF NOT EXISTS `rooms` (
  `unitId` varchar(10) NOT NULL COMMENT 'Unit / Location',
  `roomNum` int(6) NOT NULL AUTO_INCREMENT COMMENT 'Room Index',
  `roomDescr` varchar(30) NOT NULL COMMENT 'Room Description',
  PRIMARY KEY (`unitId`,`roomNum`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`unitId`, `roomNum`, `roomDescr`) VALUES
('337W0', 1, 'Alexandria'),
('337W0', 2, 'Hoover'),
('337W0', 3, 'Annapolis Room'),
('337W0', 4, 'Annapolis/Rockville'),
('337W0', 5, 'Arlington'),
('337W0', 6, 'Arlington/Alexandri'),
('337W0', 7, 'Atrium #1'),
('337W0', 8, 'Atrium #2'),
('337W0', 9, 'Baltimore Room'),
('337W0', 10, 'Baltimore/Annapolis'),
('337W0', 11, 'Calvert'),
('337W0', 12, 'Colorado'),
('337W0', 13, 'Congressional'),
('337W0', 14, 'Cotillion Ballroom'),
('337W0', 15, 'Cotillion Foyer'),
('337W0', 16, 'Cotillion North'),
('337W0', 17, 'Cotillion South'),
('337W0', 18, 'Deleware Suite'),
('337W0', 19, 'Dover Room'),
('337W0', 20, 'Early Light'),
('337W0', 21, 'Eisenhower'),
('337W0', 22, 'Embassy'),
('337W0', 23, 'Ethan Allan'),
('337W0', 24, 'Exhibit Hall A'),
('337W0', 25, 'Exhibit Hall B'),
('337W0', 26, 'Exhibit Hall C'),
('337W0', 27, 'Holmes'),
('337W0', 28, 'Idaho'),
('337W0', 29, 'Johnson'),
('337W0', 30, 'Kansas'),
('337W0', 31, 'Kennedy'),
('337W0', 32, 'Marshall'),
('337W0', 33, 'Maryland Suite'),
('337W0', 34, 'Nathan Hale'),
('337W0', 35, 'Richmond'),
('337W0', 36, 'Richmond/Arlington'),
('337W0', 37, 'Rockville Room'),
('337W0', 38, 'Roosevelt'),
('337W0', 39, 'Sheraton Bal Balc'),
('337W0', 40, 'Marriott Ballroom'),
('337W0', 41, 'Marriott Foyer'),
('337W0', 42, 'MARRIOTT'),
('337W0', 43, 'Taft'),
('337W0', 44, 'Thomas Paine'),
('337W0', 45, 'Truman'),
('337W0', 46, 'Vermont'),
('337W0', 47, 'Virginia Suite'),
('337W0', 48, 'Warren'),
('337W0', 49, 'Washington Bal Balc'),
('337W0', 50, 'Washington Ballroom'),
('337W0', 51, 'Wilmington Room'),
('337W0', 52, 'Wisconsin'),
('337W0', 53, 'Woodley'),
('337W0', 54, 'Other'),
('337W0', 55, 'Breakfast'),
('337W0', 56, 'Lunch'),
('337W0', 57, 'Dinner'),
('337W0', 58, 'Reception'),
('337W0', 59, 'Reception'),
('337W0', 60, 'Coffee'),
('337W0', 61, 'Coffee'),
('337W0', 62, 'Special Gratuity Distribution'),
('337W0', 63, 'New Room'),
('337W0', 64, 'New New Room'),
('337W0', 65, 'Thurgood Marshall');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
