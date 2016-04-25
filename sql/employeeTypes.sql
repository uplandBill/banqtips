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
-- Table structure for table `employeeTypes`
--

DROP TABLE IF EXISTS `employeeTypes`;
CREATE TABLE IF NOT EXISTS `employeeTypes` (
  `unitId` varchar(7) NOT NULL,
  `eeType` smallint(6) NOT NULL AUTO_INCREMENT,
  `effdt` date NOT NULL DEFAULT '0000-00-00',
  `eeTypeDescr` varchar(20) NOT NULL,
  `eeBaseWage` varchar(1) NOT NULL,
  `foodTipPercent` decimal(7,5) NOT NULL,
  `foodNet` varchar(1) NOT NULL COMMENT 'Gets Net of Food Grat',
  `foodGroup` varchar(12) NOT NULL COMMENT 'Food Cut Group',
  `barTipPercent` decimal(7,5) NOT NULL,
  `barNet` varchar(1) NOT NULL COMMENT 'Gets Net of Bar Grat',
  `barGroup` varchar(12) NOT NULL COMMENT 'Bar Cut Group',
  `coversAllowed` varchar(1) NOT NULL COMMENT 'Covers Allowed',
  `defHours` smallint(6) NOT NULL COMMENT 'Default Hours per Function',
  `compMethod` varchar(1) NOT NULL COMMENT 'Computation Method',
  `addButton` varchar(1) NOT NULL COMMENT 'Show Add Button',
  `getSetup` varchar(1) NOT NULL COMMENT 'Gets Setup ',
  `getClear` varchar(1) NOT NULL COMMENT 'Gets Clear',
  `getExtra` varchar(1) NOT NULL COMMENT 'Gets Extra',
  `emplClass` varchar(1) NOT NULL COMMENT 'Employee Class',
  PRIMARY KEY (`unitId`,`eeType`,`effdt`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `employeeTypes`
--

INSERT INTO `employeeTypes` (`unitId`, `eeType`, `effdt`, `eeTypeDescr`, `eeBaseWage`, `foodTipPercent`, `foodNet`, `foodGroup`, `barTipPercent`, `barNet`, `barGroup`, `coversAllowed`, `defHours`, `compMethod`, `addButton`, `getSetup`, `getClear`, `getExtra`, `emplClass`) VALUES
('337W0', 1, '2012-12-01', 'Captain', 'N', 8.86000, 'N', 'Captains', 8.86000, 'N', 'Captains', 'N', 0, '1', 'Y', 'N', 'N', 'N', '6'),
('337W0', 2, '2012-12-01', 'House One', 'N', 20.41300, 'Y', 'House', 20.41300, 'Y', 'House', 'N', 0, '1', 'Y', 'N', 'N', 'N', '6'),
('337W0', 3, '2012-12-01', 'Waiter', 'Y', 70.72700, 'N', 'Waiters', 70.72700, 'N', 'Staff', 'Y', 5, '2', 'N', 'Y', 'Y', 'Y', '6'),
('337W0', 4, '2012-12-01', 'Bartender', 'N', 0.00000, 'N', '', 70.72700, 'N', 'Staff', 'Y', 0, '2', 'N', 'N', 'N', 'N', '6'),
('33777', 1, '2012-12-01', 'Waiters', 'Y', 70.00000, 'N', 'Waiters', 70.00000, 'N', 'Staff', '', 5, '', '', 'Y', 'Y', 'Y', '6'),
('337W0', 5, '2012-12-01', 'Temporary', '0', 70.72700, 'N', 'Waiters', 70.72700, 'N', 'Staff', 'Y', 0, '1', 'N', 'Y', 'Y', 'Y', '8');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
