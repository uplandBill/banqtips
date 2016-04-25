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
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `unitId` varchar(10) NOT NULL COMMENT 'Unit / Location',
  `eventNum` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Event Number',
  `wkendDate` date NOT NULL COMMENT 'Weekending Date',
  `funcDate` date NOT NULL COMMENT 'Func / Event Date',
  `funcGroup` varchar(30) NOT NULL COMMENT 'Function Client/Group',
  `roomNum` int(11) NOT NULL COMMENT 'Function Room',
  `funcType` int(11) NOT NULL,
  `funcNumWk` int(11) NOT NULL COMMENT 'Function Num For Week',
  `foodCheck` varchar(15) NOT NULL COMMENT 'Food Check Num',
  `barCheck` varchar(15) NOT NULL COMMENT 'Bar Check Num',
  `foodBill` decimal(8,2) NOT NULL COMMENT 'Food Bill Amount',
  `foodGrat` decimal(8,2) NOT NULL COMMENT 'Food Gratuity',
  `barBill` decimal(8,2) NOT NULL COMMENT 'Bar Bill Amount',
  `barGrat` decimal(8,2) NOT NULL COMMENT 'Bar Gratuity',
  `totCovers` smallint(6) NOT NULL COMMENT 'Total Covers',
  `defSetup` decimal(6,2) NOT NULL COMMENT 'Default Setup',
  `defClear` decimal(6,2) NOT NULL COMMENT 'Default Clear',
  `defExtra` decimal(6,2) NOT NULL COMMENT 'Default Extra',
  PRIMARY KEY (`unitId`,`eventNum`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`unitId`, `eventNum`, `wkendDate`, `funcDate`, `funcGroup`, `roomNum`, `funcType`, `funcNumWk`, `foodCheck`, `barCheck`, `foodBill`, `foodGrat`, `barBill`, `barGrat`, `totCovers`, `defSetup`, `defClear`, `defExtra`) VALUES
('337W0', 1, '2012-12-07', '2012-12-01', 'Exxon Mobile Research & Engine', 40, 3, 1, '345733', ' ', 57600.00, 12672.00, 22845.00, 5025.90, 1215, 8.60, 8.60, 17.20),
('337W0', 2, '2012-12-07', '2012-12-01', 'Washington Kali Temple', 65, 3, 2, ' 345670', ' ', 5775.00, 1270.50, 0.00, 0.00, 90, 0.00, 0.00, 0.00),
('337W0', 3, '2012-12-07', '2012-12-01', '', 41, 7, 3, ' 345528', '345528', 11520.00, 2534.40, 10080.00, 2217.60, 1, 2.20, 2.20, 0.00),
('337W0', 4, '2012-12-07', '2012-12-01', 'Exxon Mobile Research & Engine', 42, 4, 4, '345610', ' ', 1200.00, 264.00, 0.00, 0.00, 1, 2.20, 2.20, 0.00),
('337W0', 5, '2012-12-07', '2012-12-02', 'Washington Kali Temple', 65, 2, 5, '511938', ' ', 4200.00, 924.00, 0.00, 0.00, 84, 2.20, 9.05, 0.00),
('337W0', 6, '2012-12-07', '2012-12-02', 'Jewish Women International', 48, 2, 6, '364688', ' ', 12800.00, 281.60, 0.00, 0.00, 32, 0.00, 0.00, 0.00),
('337W0', 7, '2012-12-07', '2012-12-03', 'ABA', 54, 2, 14, '380583', ' ', 8658.00, 1904.76, 0.00, 0.00, 208, 9.05, 9.05, 0.00),
('337W0', 8, '2012-12-07', '2012-12-02', 'Duff & Phelps LLC', 41, 7, 8, '605333', ' ', 4404.50, 968.99, 1836.00, 403.92, 1, 9.05, 9.05, 0.00),
('337W0', 9, '2012-12-07', '2012-12-02', 'Duff & Phelps LLC', 41, 7, 8, '605333', ' ', 4404.50, 968.99, 1836.00, 403.92, 1, 9.05, 9.05, 0.00),
('337W0', 10, '2012-12-07', '2012-12-02', 'AICPA', 7, 7, 9, '543503', '543503', 365.40, 80.39, 1400.85, 308.19, 1, 9.05, 9.05, 0.00),
('337W0', 11, '2012-12-07', '2012-12-03', 'AICPA', 54, 1, 10, '357704', '380498', 15208.20, 3345.81, 4320.00, 950.40, 320, 9.05, 9.05, 0.00),
('337W0', 12, '2012-12-07', '2012-12-03', 'AICPA', 15, 1, 11, '252518', ' ', 5178.80, 1138.90, 0.00, 0.00, 112, 2.20, 9.05, 0.00),
('337W0', 13, '2012-12-07', '2012-12-03', 'Jewish Women International', 65, 2, 12, '364811', ' ', 29375.00, 6462.50, 0.00, 0.00, 680, 8.60, 8.60, 0.00),
('337W0', 14, '2012-12-07', '2012-12-03', 'AICPA', 24, 2, 13, '380383', ' ', 43263.00, 9517.86, 0.00, 0.00, 1101, 2.20, 8.60, 0.00),
('337W0', 15, '2012-12-07', '2012-12-06', 'Innovative Publishing', 52, 2, 37, '131393', ' ', 2197.50, 483.45, 0.00, 0.00, 48, 2.20, 9.05, 0.00),
('337W0', 16, '2012-12-07', '2012-12-06', 'The National Law Journal', 41, 2, 36, '251897', ' ', 8575.00, 1886.50, 0.00, 0.00, 224, 2.20, 9.05, 0.00),
('337W0', 21, '2012-12-07', '2012-12-04', 'AICPA', 41, 1, 19, '509848', ' ', 6500.00, 1432.79, 0.00, 0.00, 112, 9.05, 9.05, 0.00),
('337W0', 20, '2012-12-07', '2012-12-07', 'Natl. Black Caucus State Legis', 41, 3, 44, '871577', '871577', 26100.00, 5742.00, 2175.00, 478.50, 305, 9.05, 0.00, 0.00),
('337W0', 19, '2012-12-07', '2012-12-07', 'N.B.C.S.Leg', 32, 2, 42, '871564', ' ', 11466.00, 2522.52, 0.00, 0.00, 328, 2.20, 9.05, 0.00),
('337W0', 18, '2012-12-07', '2013-01-04', 'AICPA', 54, 1, 18, '510098', ' ', 19500.00, 4292.77, 0.00, 0.00, 336, 9.05, 9.05, 0.00),
('337W0', 17, '2012-12-07', '2012-12-03', '', 52, 7, 17, '370125', '370125', 2988.00, 657.36, 1563.00, 343.86, 1, 9.05, 9.05, 0.00),
('337W0', 22, '2012-12-07', '2012-12-04', 'American Bar ASS.', 51, 2, 20, '509764', ' ', 4018.50, 884.07, 0.00, 0.00, 100, 2.20, 8.60, 0.00),
('337W0', 23, '2012-12-07', '2012-12-03', 'test group', 26, 2, 15, ' ', ' ', 0.00, 0.00, 0.00, 0.00, 1, 0.00, 0.00, 0.00),
('337W0', 24, '2012-12-07', '2012-12-04', 'AICPA', 45, 3, 22, '551413', ' ', 719.00, 158.18, 0.00, 0.00, 15, 9.05, 2.20, 0.00),
('337W0', 25, '2012-12-07', '2012-12-05', 'AICPA', 41, 1, 23, '209321', ' ', 20509.50, 4512.09, 0.00, 0.00, 384, 2.20, 9.05, 0.00),
('337W0', 26, '2012-12-07', '2012-12-05', 'National Black Cacus', 32, 1, 24, '209407', ' ', 3512.70, 772.78, 0.00, 0.00, 96, 2.20, 8.60, 0.00),
('337W0', 27, '2012-12-07', '2012-11-28', 'AICPA', 41, 1, 25, '209265', ' ', 3018.60, 664.09, 0.00, 0.00, 80, 9.05, 9.05, 0.00),
('337W0', 28, '2012-12-07', '2012-12-05', 'National Black Caucus', 54, 1, 26, '209473', ' ', 451.40, 99.31, 0.00, 0.00, 16, 2.20, 2.20, 0.00),
('337W0', 29, '2012-12-07', '2012-12-05', 'NBC of State Legislators', 32, 7, 31, '209419', '209419', 12155.00, 2674.10, 1496.70, 329.27, 1, 9.05, 9.05, 0.00),
('337W0', 30, '2012-12-07', '2012-12-03', 'ABA', 54, 2, 14, '380583', ' ', 8658.00, 1904.76, 0.00, 0.00, 208, 9.05, 9.05, 0.00),
('337W0', 32, '2012-12-07', '2012-12-06', 'USD Commerce', 41, 2, 34, '130959', ' ', 20574.25, 4526.34, 0.00, 0.00, 551, 2.20, 8.60, 0.00),
('337W0', 33, '2012-12-07', '2012-12-05', 'AICPA', 45, 3, 29, '209195', ' ', 719.00, 158.18, 0.00, 0.00, 16, 9.05, 2.20, 0.00),
('337W0', 34, '2012-12-07', '2012-12-05', '', 49, 7, 30, '209179', '209179', 2325.00, 511.50, 532.00, 117.04, 16, 2.20, 2.20, 0.00),
('337W0', 35, '2012-12-07', '2012-12-03', 'AICPA', 32, 7, 16, '357797', '357797', 26100.00, 6084.14, 8633.25, 1899.33, 1, 9.05, 2.20, 0.00),
('337W0', 36, '2012-12-07', '2012-12-05', 'National Black Caucus', 32, 2, 28, '209786', ' ', 11466.00, 2522.52, 0.00, 0.00, 320, 8.60, 8.60, 0.00),
('337W0', 37, '2012-12-07', '2012-12-05', 'AICPA', 24, 2, 27, '209288', ' ', 32782.50, 7212.15, 0.00, 0.00, 873, 8.60, 8.60, 0.00);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
