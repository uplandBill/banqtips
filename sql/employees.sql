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
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
CREATE TABLE IF NOT EXISTS `employees` (
  `unitId` varchar(7) NOT NULL COMMENT 'Unit / Location',
  `emplid` varchar(11) NOT NULL COMMENT 'Employee Id',
  `effdt` date NOT NULL COMMENT 'Effective Date',
  `name` varchar(50) NOT NULL COMMENT 'Employee Name',
  `deptId` varchar(10) NOT NULL COMMENT 'Employee Dept',
  `location` varchar(10) NOT NULL COMMENT 'Employee Location',
  `emplStatus` varchar(1) NOT NULL DEFAULT 'A',
  `eeType` smallint(6) NOT NULL COMMENT 'EE Type',
  `emplClass` varchar(1) NOT NULL COMMENT 'Employee Class',
  `payGrp` varchar(2) NOT NULL COMMENT 'Pay Group',
  PRIMARY KEY (`unitId`,`emplid`,`effdt`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`unitId`, `emplid`, `effdt`, `name`, `deptId`, `location`, `emplStatus`, `eeType`, `emplClass`, `payGrp`) VALUES
('337W0', '1041080', '2012-12-01', 'Salsamendi,Elena', '023000', '', 'A', 3, '6', '26'),
('337W0', '1041115', '2012-12-01', 'Hawaz,Azeb', '0211WA', '33W0', 'A', 3, '6', '25'),
('337W0', '1041116', '2012-12-01', 'Bonilla,Jose', '0261WF', '33W0', 'A', 3, '6', '25'),
('337W0', '1041120', '2012-12-01', 'Cooper,Patrick J', '0211WA', '33W0', 'A', 3, '6', '25'),
('337W0', '1041121', '2012-12-01', 'Hailu,Berekete Kahesay', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041123', '2012-12-01', 'Romero,Jose A', '0211WA', '33W0', 'A', 3, '6', '25'),
('337W0', '1041125', '2012-12-01', 'Abraham,Zufan', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041126', '2012-12-01', 'Teffera,Muluberhan', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041131', '2012-12-01', 'Huynh,Tuan C.', '0211WA', '33W0', 'A', 3, '6', '25'),
('337W0', '1041133', '2012-12-01', 'Rubio,Jose A', '0211WA', '33W0', 'A', 3, '6', '25'),
('337W0', '1041134', '2012-12-01', 'Gallo,Ana', '0211WA', '33W0', 'A', 3, '6', '25'),
('337W0', '1041136', '2012-12-01', 'Jamal,Mohammed', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041139', '2012-12-01', 'Andrade,Alcides', '0261WF', ' ', 'A', 3, '6', '25'),
('337W0', '1041141', '2012-12-01', 'Portillo,Wilberto Z', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041148', '2012-12-01', 'Rosa,Jose', '0221WB', '33W0', 'A', 3, '6', '25'),
('337W0', '1041150', '2012-12-01', 'Ilku,Nicholas J.', '0221WB', '33W0', 'A', 3, '6', '25'),
('337W0', '1041152', '2012-12-01', 'Tekle,Azeb', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041153', '2012-12-01', 'Gutema,Gashaye Zinabu', '0221WB', '33W0', 'A', 3, '6', '25'),
('337W0', '1041156', '2012-12-01', 'Siyoum,Tsega', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041159', '2012-12-01', 'Melaku,Askabech', '0221WB', '33W0', 'A', 3, '6', '25'),
('337W0', '1041160', '2012-12-01', 'Mengisteab,Tewolde', '0261WF', '33W0', 'A', 3, '6', '25'),
('337W0', '1041163', '2012-12-01', 'Lara,Ramon', '0261WF', '33W0', 'A', 3, '6', '25'),
('337W0', '1041168', '2012-12-01', 'Zane,Amina', '0211WA', '33W0', 'A', 3, '6', '25'),
('337W0', '1041177', '2012-12-01', 'Derose,Linois John', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041180', '2012-12-01', 'Urena,Augusto Nelson', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041185', '2012-12-01', 'Leshne,Stanley', '0230WC', '33W0', 'A', 4, '6', '25'),
('337W0', '1041189', '2012-12-01', 'Arache,Dorothy E.', '0230WC', '33W0', 'A', 3, '8', '26'),
('337W0', '1041192', '2012-12-01', 'Talley,Ottoway D', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041193', '2012-12-01', 'Hale,William G.', '0230WJ', '33W0', 'A', 3, '6', '25'),
('337W0', '1041201', '2012-12-01', 'Sol,Renaa M', '0230WC', '33W0', 'A', 4, '8', '26'),
('337W0', '1041203', '2012-12-01', 'Saint-Jean,Chrispin', '0230WC', '33W0', 'A', 1, '6', '25'),
('337W0', '1041204', '2012-12-01', 'Gheorghiu,Gabriel Aurel', '0230WJ', '33W0', 'A', 3, '6', '25'),
('337W0', '1041210', '2012-12-01', 'Villarreal,Carlos', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041211', '2012-12-01', 'Joseph,Gabriel', '0230WC', ' ', 'A', 3, '8', '26'),
('337W0', '1041212', '2012-12-01', 'Mahfoud,Alexandra C.', '0230WC', '33W0', 'A', 4, '8', '26'),
('337W0', '1041213', '2012-12-01', 'Marroquin,Antonio Garcia', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041214', '2012-12-01', 'Prieto,Cesar', '0230WC', '33W0', 'A', 3, '8', '26'),
('337W0', '1041220', '2012-12-01', 'Abuzaid,Abdel', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041226', '2012-12-01', 'Neely,Clyde J.', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041230', '2012-12-01', 'Oulare,Balla', '0240WD', '33W0', 'A', 3, '6', '25'),
('337W0', '1041232', '2012-12-01', 'Mazumder,Theophil', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041233', '2012-12-01', 'Andrade,Martha B.', '0230WC', ' ', 'A', 3, '8', '26'),
('337W0', '1041234', '2012-12-01', 'Blackellar,Utilla', '0230WC', '33W0', 'A', 3, '8', '26'),
('337W0', '1041235', '2012-12-01', 'Zambrano,Litha G.', '0230WC', ' ', 'A', 3, '6', '26'),
('337W0', '1041237', '2012-12-01', 'Zephirin,Jean R', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041240', '2012-12-01', 'Rozario,Dulal', '0230WJ', '33W0', 'A', 3, '6', '25'),
('337W0', '1041241', '2012-12-01', 'Chibuzo,Paul U', '0011W2', '33W0', 'A', 3, '6', '25'),
('337W0', '1041242', '2012-12-01', 'Zetino,Marta Evelyn', '0230WC', ' ', 'A', 3, '8', '26'),
('337W0', '1041244', '2012-12-01', 'Diaz,Xelaju Cindya', '0230WC', '33W0', 'A', 3, '8', '26'),
('337W0', '1041245', '2012-12-01', 'Palitha,Kalawane', '0211WA', '33W0', 'A', 3, '6', '25'),
('337W0', '1041248', '2012-12-01', 'Rodriguez,Fernando', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041252', '2012-12-01', 'Ponce,Carmen', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041254', '2012-12-01', 'Campos,Hugo M.', '0230WC', ' ', 'A', 3, '8', '26'),
('337W0', '1041255', '2012-12-01', 'Abouaraine,Brahim', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041256', '2012-12-01', 'Morales,Betty Isabel', '0230WC', '33W0', 'A', 3, '8', '26'),
('337W0', '1041262', '2012-12-01', 'Rodriguez,Emerita Exalta', '0230WC', ' ', 'A', 3, '8', '26'),
('337W0', '1041263', '2012-12-01', 'Reyes,Carlos J', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041266', '2012-12-01', 'Salahuddin,Karim Mohammad', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041267', '2012-12-01', 'Montero,Mauren', '0230WC', '33W0', 'A', 3, '8', '26'),
('337W0', '1041268', '2012-12-01', 'Hassan,Abdirahman Jama', '0230WJ', '33W0', 'A', 3, '6', '25'),
('337W0', '1041271', '2012-12-01', 'Hussaini,Sayed S.', '0230WC', '33W0', 'A', 1, '6', '25'),
('337W0', '1041282', '2012-12-01', 'Pho,Hoa Dung', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041283', '2012-12-01', 'Mandujano,Julio Cleofe', '0230WC', '33W0', 'A', 3, '8', '26'),
('337W0', '1041285', '2012-12-01', 'Maldonado,Silvia Eugenia', '0230WC', '33W0', 'A', 3, '8', '26'),
('337W0', '1041288', '2012-12-01', 'Ahmed,Muhammad K.', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041291', '2012-12-01', 'Jimenez,Mary', '0230WC', ' ', 'A', 3, '8', '26'),
('337W0', '1041300', '2012-12-01', 'Palmer,Margaret A.', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041301', '2012-12-01', 'Scott,Dolores', '0230WC', '33W0', 'A', 3, '8', '26'),
('337W0', '1041302', '2012-12-01', 'Hensel,Donald J', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041308', '2012-12-01', 'Barahona,Marta A.', '0230WC', ' ', 'A', 3, '8', '26'),
('337W0', '1041310', '2012-12-01', 'Hill,Barbara Ann', '0230WC', '33W0', 'A', 4, '8', '26'),
('337W0', '1041311', '2012-12-01', 'Shafiq,Mohammed', '0230WC', '33W0', 'A', 1, '6', '25'),
('337W0', '1041315', '2012-12-01', 'Pham,Dien V.', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041316', '2012-12-01', 'Yusuf,Abdulahi', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041317', '2012-12-01', 'Agnew,Doris G.', '0230WC', '33W0', 'A', 3, '8', '26'),
('337W0', '1041318', '2012-12-01', 'Patchimanon,Kamron', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041319', '2012-12-01', 'Foster-Hayes,Valerie', '0230WC', ' ', 'A', 3, '8', '26'),
('337W0', '1041321', '2012-12-01', 'McDowell,Beverly Ann', '0230WC', '33W0', 'A', 3, '8', '26'),
('337W0', '1041326', '2012-12-01', 'Miranda,Abel E.', '0230WC', ' ', 'A', 3, '8', '26'),
('337W0', '1041329', '2012-12-01', 'Nguyen,Loc V', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041331', '2012-12-01', 'Truong,Loc Min', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041341', '2012-12-01', 'Mella-Tolentino,Isidro', '0240WD', '33W0', 'A', 3, '6', '25'),
('337W0', '1041348', '2012-12-01', 'Escoto,Percy', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041353', '2012-12-01', 'McCray,Eloise J', '0230WC', '33W0', 'A', 3, '8', '26'),
('337W0', '1041357', '2012-12-01', 'Chuthaset,Mark', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041366', '2012-12-01', 'Fortiz-Reyes,Agustina', '0230WC', ' ', 'A', 3, '8', '26'),
('337W0', '1041372', '2012-12-01', 'Long,Ben Hue', '0240WD', '33W0', 'A', 3, '6', '25'),
('337W0', '1041373', '2012-12-01', 'Ochoa,Jose F.', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041375', '2012-12-01', 'Feria,Rosa Sanchez', '0230WC', '33W0', 'A', 3, '8', '26'),
('337W0', '1041376', '2012-12-01', 'Feria,Betty Volentina', '0230WC', ' ', 'A', 3, '8', '26'),
('337W0', '1041379', '2012-12-01', 'Sagastizado,Adolfo', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041382', '2012-12-01', 'Perpignan,Marie G', '0230WC', ' ', 'A', 3, '8', '26'),
('337W0', '1041383', '2012-12-01', 'Disla,Jose A', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041384', '2012-12-01', 'Garcia,Irma', '0230WC', '33W0', 'A', 3, '8', '26'),
('337W0', '1041386', '2012-12-01', 'Quintanilla,Emilio', '0230WC', ' ', 'A', 3, '8', '26'),
('337W0', '1041387', '2012-12-01', 'Kamara,Saidu', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041389', '2012-12-01', 'Monroy,Roberto', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041395', '2012-12-01', 'Vainqueur,Alex', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041400', '2012-12-01', 'Huallpa,Basilio', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041404', '2012-12-01', 'Ardon,Teresa J.', '0230WC', '33W0', 'A', 3, '8', '26'),
('337W0', '1041405', '2012-12-01', 'Casseus,Jeannote F', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041409', '2012-12-01', 'Prado,Carlos J.', '0230WC', ' ', 'A', 3, '8', '26'),
('337W0', '1041410', '2012-12-01', 'Jimenez,Rolando', '0230WC', ' ', 'A', 3, '8', '26'),
('337W0', '1041412', '2012-12-01', 'Damian,Mariana', '0230WC', '33W0', 'A', 3, '8', '26'),
('337W0', '1041414', '2012-12-01', 'McCrae,Vivian Alfreada', '0230WC', '33W0', 'A', 3, '8', '26'),
('337W0', '1041416', '2012-12-01', 'Admasu,Getachew', '0230WC', '33W0', 'A', 3, '8', '26'),
('337W0', '1041417', '2012-12-01', 'Teklewolde,Tamerat', '0230WC', ' ', 'A', 3, '8', '26'),
('337W0', '1041419', '2012-12-01', 'Arias,Juliana', '0230WC', '33W0', 'A', 3, '8', '26'),
('337W0', '1041420', '2012-12-01', 'Riley,Maxwell', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041421', '2012-12-01', 'Patel,Hasmukh V.', '0230WJ', '33W0', 'A', 3, '6', '25'),
('337W0', '1041422', '2012-12-01', 'Carlin,Carlos G.', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041423', '2012-12-01', 'Crespo,Luis B', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041427', '2012-12-01', 'Djahel,Baghdadi', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041431', '2012-12-01', 'Kazi,Main', '0230WC', '33W0', 'A', 1, '', '25'),
('337W0', '1041434', '2012-12-01', 'Goshu,Ye Alemzewed Y', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041437', '2012-12-01', 'Papadopoulos,George', '0230WC', ' ', 'A', 3, '8', '26'),
('337W0', '1041440', '2012-12-01', 'Decaneva,George A', '0230WC', '33W0', 'A', 3, '8', '26'),
('337W0', '1041444', '2012-12-01', 'Guarachi,Carlos R', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041447', '2012-12-01', 'Smith,Christiane', '0230WC', '33W0', 'A', 1, '6', '25'),
('337W0', '1041452', '2012-12-01', 'Farahanian,Seyed Hadi', '0230WC', ' ', 'A', 3, '8', '26'),
('337W0', '1041453', '2012-12-01', 'Pinedo,Mario R.', '0230WC', '33W0', 'A', 1, '6', '25'),
('337W0', '1041456', '2012-12-01', 'Feria,Justa', '0230WC', ' ', 'A', 3, '8', '26'),
('337W0', '1041457', '2012-12-01', 'Farahanian,Mehdi S', '0230WC', ' ', 'A', 3, '8', '26'),
('337W0', '1041461', '2012-12-01', 'Santi,Benito R', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041469', '2012-12-01', 'Bassiri,Firouz', '0230WC', '33W0', 'A', 1, '6', '25'),
('337W0', '1041473', '2012-12-01', 'Saunders,Winsley J', '0230WC', '33W0', 'A', 1, '6', '25'),
('337W0', '1041475', '2012-12-01', 'Torres,Jose R.', '0230WC', '33W0', 'A', 4, '6', '25'),
('337W0', '1041479', '2012-12-01', 'Arache,Tomas', '0240WD', ' ', 'A', 3, '6', '33'),
('337W0', '1041481', '2012-12-01', 'Negash,Tewachew T.', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041483', '2012-12-01', 'Feroz,Nasim', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041485', '2012-12-01', 'Murshed,Mahbubul W.', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041488', '2012-12-01', 'Obaze,Felix', '0230WJ', '33W0', 'A', 3, '6', '25'),
('337W0', '1041490', '2012-12-01', 'Gamys,Niang Mizi', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041492', '2012-12-01', 'Haque,Mohammad Majibul', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041493', '2012-12-01', 'Haque,Shamsul Mohammed', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041494', '2012-12-01', 'Shaffran,Hilda C', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041495', '2012-12-01', 'Bonilla,Javier R', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041496', '2012-12-01', 'Laura,Luis M.', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041497', '2012-12-01', 'Cetin,Guler', '0240WD', '33W0', 'A', 3, '6', '25'),
('337W0', '1041499', '2012-12-01', 'Khan,Muhammad Bashir', '0261WF', ' ', 'A', 3, '6', '33'),
('337W0', '1041500', '2012-12-01', 'Adriazola,Segundo Juan', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041501', '2012-12-01', 'Suriya,Bunpote', '0240WD', '33W0', 'A', 3, '6', '25'),
('337W0', '1041506', '2012-12-01', 'Ochoa,Guadalupe I', '0240WD', '33W0', 'A', 3, '6', '25'),
('337W0', '1041507', '2012-12-01', 'Marcia,Henry Olivar', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041514', '2012-12-01', 'Viera,Luis', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041515', '2012-12-01', 'Gosh,Babul', '0430W5', '33W0', 'A', 3, '6', '25'),
('337W0', '1041516', '2012-12-01', 'Sarker,Shafiqul', '0240WD', '33W0', 'A', 3, '6', '25'),
('337W0', '1041517', '2012-12-01', 'Kongsomboon,Kittisuck', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041519', '2012-12-01', 'Garnica,German', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041521', '2012-12-01', 'Carrillo,Dora Carmen', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041530', '2012-12-01', 'Harrache,Ahmed', '0211WA', '33W0', 'A', 3, '6', '25'),
('337W0', '1041531', '2012-12-01', 'Tesfaye,Elleni', '0211WA', '33W0', 'A', 3, '6', '25'),
('337W0', '1041532', '2012-12-01', 'Gomes,Stanley', '0261WF', '33W0', 'A', 3, '6', '25'),
('337W0', '1041533', '2012-12-01', 'Matz-Brown,Meegan', '0211WA', '33W0', 'A', 3, '6', '25'),
('337W0', '1041534', '2012-12-01', 'Gomes,Suntow', '0261WF', '33W0', 'A', 3, '6', '25'),
('337W0', '1041536', '2012-12-01', 'Mihtsun,Ghebreberhan', '0221WB', '33W0', 'A', 3, '6', '25'),
('337W0', '1041537', '2012-12-01', 'Beaudet,John S.', '0261WF', '33W0', 'A', 3, '6', '25'),
('337W0', '1041539', '2012-12-01', 'Mulatu,Yohannes', '0261WF', '33W0', 'A', 3, '6', '25'),
('337W0', '1041542', '2012-12-01', 'Techane,Roman', '0261WF', '33W0', 'A', 3, '6', '25'),
('337W0', '1041545', '2012-12-01', 'Strong,Brenda A', '0261WF', '33W0', 'A', 3, '6', '25'),
('337W0', '1041547', '2012-12-01', 'Grogan,Sean M', '0261WF', '33W0', 'A', 3, '6', '25'),
('337W0', '1041548', '2012-12-01', 'Ghebremichael,Miraf', '0271WG', '33W0', 'A', 3, '6', '25'),
('337W0', '1041553', '2012-12-01', 'Nguyen,Mai T', '0271WG', '33W0', 'A', 3, '6', '25'),
('337W0', '1041570', '2012-12-01', 'Seyoum,Mihiret Gimeskel', '0012W1', '33W0', 'A', 3, '', '25'),
('337W0', '1041579', '2012-12-01', 'Wube,Engidawork', '0271WG', '33W0', 'A', 3, '6', '25'),
('337W0', '1041581', '2012-12-01', 'Mohammed,Kedija Y.', '0240WD', '33W0', 'A', 3, '6', '25'),
('337W0', '1041589', '2012-12-01', 'Mohammed,Seada Ali', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041597', '2012-12-01', 'Ambaye,Mulugeta A', '0011W2', '33W0', 'A', 3, '6', '25'),
('337W0', '1041601', '2012-12-01', 'Tran,Bau T', '0012W1', '33W0', 'A', 3, '6', '25'),
('337W0', '1041604', '2012-12-01', 'Samater,Farhia A', '0240WD', '33W0', 'A', 3, '6', '25'),
('337W0', '1041607', '2012-12-01', 'Vargas,Candida', '0012W1', '33W0', 'A', 3, '6', '25'),
('337W0', '1041608', '2012-12-01', 'Bekele,Tsedale', '0012W1', '33W0', 'A', 3, '6', '25'),
('337W0', '1041611', '2012-12-01', 'Tesema,Dereje Mekonnen', '0011W2', '33W0', 'A', 3, '6', '25'),
('337W0', '1041614', '2012-12-01', 'Araya,Saba', '0012W1', '33W0', 'A', 3, '6', '25'),
('337W0', '1041616', '2012-12-01', 'Sanjines,Patricia', '0012W1', '33W0', 'A', 3, '6', '25'),
('337W0', '1041622', '2012-12-01', 'Kobani,Joy', '0012W1', '33W0', 'A', 3, '6', '25'),
('337W0', '1041635', '2012-12-01', 'Sou,Proeung', '0012W1', '33W0', 'A', 3, '6', '25'),
('337W0', '1041637', '2012-12-01', 'Pajibo,Florence T.', '0012W1', '33W0', 'A', 3, '6', '25'),
('337W0', '1041675', '2012-12-01', 'Manuel,Sonya', '0012W1', '33W0', 'A', 3, '6', '25'),
('337W0', '1041732', '2012-12-01', 'Tsehai,Yewubdar', '0211WA', '33W0', 'A', 3, '6', '25'),
('337W0', '1041735', '2012-12-01', 'Argueta,Sonia M', '0020W6', '33W0', 'A', 3, '6', '25'),
('337W0', '1041738', '2012-12-01', 'Nwosu,Gladys Chioma', '0012W1', '33W0', 'A', 3, '6', '25'),
('337W0', '1041746', '2012-12-01', 'Ellsworth,Nedra Y.', '0012W1', '33W0', 'A', 3, '6', '25'),
('337W0', '1041767', '2012-12-01', 'Huynh,Anh M.', '0012W1', '33W0', 'A', 3, '6', '25'),
('337W0', '1041770', '2012-12-01', 'Kahsu,Tiblets A.', '0240WD', ' ', 'A', 3, '6', '33'),
('337W0', '1041791', '2012-12-01', 'Solomon,Samson', '0011W2', '33W0', 'A', 3, '6', '25'),
('337W0', '1041844', '2012-12-01', 'Eubanks,Eunice Hines', '0020W6', '33W0', 'A', 3, '6', '25'),
('337W0', '1041847', '2012-12-01', 'Eubanks,Frankie M.', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041865', '2012-12-01', 'Bautista,Felix D.', '0030W7', '33W0', 'A', 3, '6', '25'),
('337W0', '1041881', '2012-12-01', 'Gonzalez Garcia,Edgar Gabino', '0090W8', '33W0', 'A', 3, '6', '25'),
('337W0', '1041883', '2012-12-01', 'Martinez,Miguel A.', '0090W8', '33W0', 'A', 3, '6', '25'),
('337W0', '1041910', '2012-12-01', 'Gilson,Pierre Marc Jean', '0190WQ', '33W0', 'A', 3, '6', '25'),
('337W0', '1041929', '2012-12-01', 'Campbell,Bruce', '009000', '33W0', 'A', 3, '6', '25'),
('337W0', '1041933', '2012-12-01', 'Cartagena,Maria Elena', '0190WT', '33W0', 'A', 3, '6', '25'),
('337W0', '1041940', '2012-12-01', 'Rodriguez,Jose G', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041949', '2012-12-01', 'Cuenca,Eddy', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1041963', '2012-12-01', 'Redman,Pablo E', '0190WQ', '33W0', 'A', 3, '6', '25'),
('337W0', '1041972', '2012-12-01', 'Ferreyros,Carlos A.', '0190WQ', '33W0', 'A', 3, '6', '25'),
('337W0', '1041988', '2012-12-01', 'Forde,Jeanette', '0211WA', ' ', 'A', 3, '6', '33'),
('337W0', '1041990', '2012-12-01', 'Villalta,Jose B', '0190WQ', '33W0', 'A', 3, '6', '25'),
('337W0', '1042006', '2012-12-01', 'Liu,Shao Ming', '0240WD', '33W0', 'A', 3, '6', '25'),
('337W0', '1042014', '2012-12-01', 'McDuffie,Melody G.', '0190W9', '33W0', 'A', 3, '6', '25'),
('337W0', '1042134', '2012-12-01', 'Haider,Karim Shameem M', '023000', '33W0', 'A', 3, '6', '25'),
('337W0', '1042228', '2012-12-01', 'Lockhart Jones,Charlene Yvonne', '041000', '33W0', 'A', 3, '6', '25'),
('337W0', '1043959', '2012-12-01', 'Abdelaziz,Adnan H', '023000', '33W0', 'A', 3, '6', '25'),
('337W0', '1044132', '2012-12-01', 'Ortega,Rosa-Denisse', '0271WG', '33W0', 'A', 3, '6', '25'),
('337W0', '1119492', '2012-12-01', 'Ortiz,Gloria', '0230WC', '33W0', 'A', 3, '8', '26'),
('337W0', '1120083', '2012-12-01', 'Perry,Clelia', '0271WG', '33W0', 'A', 3, '6', '25'),
('337W0', '1126083', '2012-12-01', 'De Las Casas,Victor R.', '0230WC', ' ', 'A', 3, '8', '26'),
('337W0', '1126087', '2012-12-01', 'Espinoza,Fidel', '0230WC', ' ', 'A', 3, '8', '26'),
('337W0', '1126101', '2012-12-01', 'Wong,Lester L.', '0230WC', '33W0', 'A', 4, '8', '26'),
('337W0', '1126584', '2012-12-01', 'Maldonado,Roberto', '0230WC', '33W0', 'A', 3, '8', '26'),
('337W0', '1126600', '2012-12-01', 'Nino De Guzman,Tatiana', '0230WC', '33W0', 'A', 3, '8', '26'),
('337W0', '1135094', '2012-12-01', 'Olivera,Celio R', '0221WB', '33W0', 'A', 3, '6', '25'),
('337W0', '1158139', '2012-12-01', 'Chelatu,James', '0230WJ', '33W0', 'A', 3, '6', '25'),
('337W0', '1170815', '2012-12-01', 'Islam,MD Zabedul', '0211WA', ' ', 'A', 3, '6', '33'),
('337W0', '1186174', '2012-12-01', 'Alvarez,Celsa M', '0020W6', '33W0', 'A', 3, '6', '25'),
('337W0', '1186176', '2012-12-01', 'Vanegas,Maria', '0012W1', '33W0', 'A', 3, '6', '25'),
('337W0', '1187294', '2012-12-01', 'Bautista,Donatilda', '0012W1', '33W0', 'A', 3, '6', '25'),
('337W0', '1192222', '2012-12-01', 'Hagos,Azeb', '0271WG', '33W0', 'A', 3, '6', '25'),
('337W0', '1193328', '2012-12-01', 'Kandeh,Aminata', '0012W1', '33W0', 'A', 3, '6', '25'),
('337W0', '1196353', '2012-12-01', 'Bautista,Paulina', '0012W1', '33W0', 'A', 3, '6', '25'),
('337W0', '1210877', '2012-12-01', 'Soriagalvarro,Shirley', '0230WC', '33W0', 'A', 3, '8', '26'),
('337W0', '1222848', '2012-12-01', 'Wadud,Ashraful', '0211WA', '33W0', 'A', 3, '6', '25'),
('337W0', '1241949', '2012-12-01', 'Berhane,Nebiat', '0221WB', '33W0', 'A', 3, '6', '25'),
('337W0', '1248954', '2012-12-01', 'Lopez Orellana,Eloina Priscila', '0012W1', '33W0', 'A', 3, '6', '25'),
('337W0', '1248995', '2012-12-01', 'Hantal,Dinkinesh', '0012W1', '33W0', 'A', 3, '6', '25'),
('337W0', '1251170', '2012-12-01', 'Dawd,Zebiba A', '0012W1', '33W0', 'A', 3, '6', '25'),
('337W0', '1271964', '2012-12-01', 'Chereto,Tsehay B', '0261WF', '33W0', 'A', 3, '6', '25'),
('337W0', '1277631', '2012-12-01', 'W Giorgis,Tersit', '0271WG', '33W0', 'A', 3, '6', '25'),
('337W0', '1277633', '2012-12-01', 'Abera,Menbere C', '0240WD', '33W0', 'A', 3, '6', '25'),
('337W0', '1282127', '2012-12-01', 'Cavizza,Celia D', '0230WC', ' ', 'A', 3, '8', '26'),
('337W0', '1283146', '2012-12-01', 'Teshale,Tesfay', '0190WQ', '33W0', 'A', 3, '6', '25'),
('337W0', '1289417', '2012-12-01', 'Mansilla,Jorge', '0230WC', '33W0', 'A', 3, '8', '26'),
('337W0', '1302853', '2012-12-01', 'Zewdu,Martha', '0240WD', '33W0', 'A', 3, '6', '25'),
('337W0', '1308570', '2012-12-01', 'Wang,Feng Ting', '0012W1', '33W0', 'A', 3, '6', '25'),
('337W0', '1309429', '2012-12-01', 'Pena Orellana,Karla Fiorella', '0012W1', '33W0', 'A', 3, '6', '25'),
('337W0', '1320439', '2012-12-01', 'Scott,Rosa Gladis', '0240WD', '33W0', 'A', 3, '6', '25'),
('337W0', '1323536', '2012-12-01', 'Quinteros,Ana E', '0012W1', '33W0', 'A', 3, '6', '25'),
('337W0', '1334836', '2012-12-01', 'Ahmed,Fatma M.', '0190W9', '33W0', 'A', 3, '6', '25'),
('337W0', '1337410', '2012-12-01', 'Woldhanna,Addisalem', '021100', '33W0', 'A', 3, '6', '25'),
('337W0', '1338362', '2012-12-01', 'Guillen-Franco,Ricardo C.', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1361576', '2012-12-01', 'Tessema,Asgaredech T.', '0012W1', '33W0', 'A', 3, '6', '25'),
('337W0', '1366223', '2012-12-01', 'Baker,Franklyn Tungie', '0190WQ', '33W0', 'A', 3, '6', '25'),
('337W0', '1376522', '2012-12-01', 'Siyefyared,Abrham Miheretab', '0240WD', '33W0', 'A', 3, '6', '25'),
('337W0', '1379795', '2012-12-01', 'Ahmed,Syeed U', '0221WB', '33W0', 'A', 3, '6', '25'),
('337W0', '1388998', '2012-12-01', 'Feyessa,Kidist K', '0261WF', '33W0', 'A', 3, '6', '25'),
('337W0', '1394565', '2012-12-01', 'Kebede,Leul M', '0261WF', '33W0', 'A', 3, '6', '25'),
('337W0', '1394725', '2012-12-01', 'Egzeher,Rutha', '0261WF', '33W0', 'A', 3, '6', '25'),
('337W0', '1423038', '2012-12-01', 'Ferman,Marleni De Jesus', '0012W1', '33W0', 'A', 3, '6', '25'),
('337W0', '1436942', '2012-12-01', 'Diaz,Luis Augusto', '0230WC', '33W0', 'A', 3, '8', '26'),
('337W0', '1443390', '2012-12-01', 'Sisay,Meseret Abera', '0211WA', ' ', 'A', 3, '6', '33'),
('337W0', '1449875', '2012-12-01', 'Tune,Gada Hussen', '0221WB', '33W0', 'A', 3, '6', '25'),
('337W0', '1462417', '2012-12-01', 'Azero,Jaime Emilio', '0230WC', '33W0', 'A', 3, '6', '25'),
('337W0', '1473521', '2012-12-01', 'Zambrana,Marina', '0230WC', '33W0', 'A', 3, '8', '26'),
('337W0', '1493535', '2012-12-01', 'Tefera,Senait Gebremariam', '0221WB', '33W0', 'A', 3, '6', '25'),
('337W0', '1494119', '2012-12-01', 'Reyes,Herik', '0261WF', '33W0', 'A', 3, '6', '25'),
('337W0', '1512230', '2012-12-01', 'Ahmed,Hanan Basheir Fadl', '0240WD', ' ', 'A', 3, '6', '33'),
('337W0', '1522706', '2012-12-01', 'Chowdhury,Salim U', '0211WA', '33W0', 'A', 3, '6', '25'),
('337W0', '1547060', '2012-12-01', 'Lemus,Liliam Lisseth', '0012W1', '33W0', 'A', 3, '6', '25'),
('337W0', '1579222', '2012-12-01', 'Chowdhury,Shuhel Ahmed', '0221WB', '33W0', 'A', 3, '6', '25'),
('337W0', 'house', '2012-12-01', 'The House', '000001', '337W0', 'A', 2, '', '25'),
('33777', '10000', '2012-12-01', 'Test 777', '10000', '33777', 'A', 1, '', '25'),
('337W0', '123xxxx', '2012-12-01', 'Tewachew, N.', '0230WC', '337W0', 'A', 3, '', '25'),
('337W0', 'TmpGroup', '2012-12-01', 'Group,Temporaries', '0230WC', '337W0', 'A', 5, '', '25'),
('337W0', '1234xxx', '2012-12-01', 'Garcia,Antonio', '0230WC', ' ', 'A', 3, '6', '25'),
('337W0', '99000001', '2012-12-01', 'Batista,M.', '000000', ' ', 'A', 3, '6', '11'),
('337W0', '99000002', '2012-12-01', 'Saavedra, L', '000000', ' ', 'A', 3, '6', '11'),
('337W0', '99000003', '2012-12-01', 'Rameriz,M.', '000000', ' ', 'A', 3, '8', '11');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
