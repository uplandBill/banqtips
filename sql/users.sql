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
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `userid` varchar(20) NOT NULL COMMENT 'User / Logon',
  `userName` varchar(30) NOT NULL COMMENT 'User Name',
  `password` varchar(41) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL COMMENT 'Encrypted Password',
  `active` varchar(1) NOT NULL COMMENT 'Status',
  `userType` varchar(5) NOT NULL COMMENT 'User Type',
  `userMaint` varchar(1) NOT NULL COMMENT 'Maintain Users',
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `userName`, `password`, `active`, `userType`, `userMaint`) VALUES
('bill', 'Bill Reimers', '*29A1BB43D3B9EB42028B4566E4836353285B9395', 'A', 'admin', 'Y'),
('Peter', 'Peter Donath', '*A26E78384A0D84520AAF5A2E8964AD7B5C6D9E3C', 'A', 'user', 'Y'),
('preston', 'Preston Joyce', '*7AC682601BD653ED7069984367A7812D58EE097D', 'A', 'admin', 'Y');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
