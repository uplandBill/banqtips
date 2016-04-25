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
-- Table structure for table `configs`
--

DROP TABLE IF EXISTS `configs`;
CREATE TABLE IF NOT EXISTS `configs` (
  `tableName` varchar(30) NOT NULL COMMENT 'Table Name',
  `tableDescr` varchar(20) NOT NULL COMMENT 'Description',
  `userConfig` varchar(1) NOT NULL COMMENT 'User Configurable',
  `adminConfig` varchar(1) NOT NULL COMMENT 'Admin Configurable',
  `edFunc` varchar(15) NOT NULL COMMENT 'Edit Function',
  PRIMARY KEY (`tableName`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `configs`
--

INSERT INTO `configs` (`tableName`, `tableDescr`, `userConfig`, `adminConfig`, `edFunc`) VALUES
('depts', 'Departments Table', 'Y', 'Y', 'edDepts'),
('configs', 'Config Tables', 'N', 'Y', 'edConfigs'),
('units', 'Units / Properties', 'N', 'Y', 'edUnits'),
('employeeTypes', 'Employee Types', 'Y', 'Y', 'edEeTypes'),
('rooms', 'Room Names', 'Y', 'Y', 'nada'),
('users', 'System Users', 'N', 'Y', 'nada'),
('secUnits', 'Security by Unit', 'N', 'Y', 'nada');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
