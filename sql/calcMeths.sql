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
-- Table structure for table `calcMeths`
--

DROP TABLE IF EXISTS `calcMeths`;
CREATE TABLE IF NOT EXISTS `calcMeths` (
  `compMethod` varchar(1) NOT NULL COMMENT 'Calc Method Id',
  `compDescr` varchar(250) NOT NULL COMMENT 'Description',
  `compDescrShrt` varchar(15) NOT NULL COMMENT 'Short Description',
  UNIQUE KEY `compMethod` (`compMethod`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `calcMeths`
--

INSERT INTO `calcMeths` (`compMethod`, `compDescr`, `compDescrShrt`) VALUES
('1', 'Straight Percent - Percent of tip divided by employees in the group.', 'Flat Percent'),
('2', 'By Covers - Tip per cover times the covers for the employee.', 'By Covers');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
