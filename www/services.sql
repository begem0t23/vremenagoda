-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 16, 2014 at 07:47 PM
-- Server version: 5.5.25
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `user346_vg`
--

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE IF NOT EXISTS `services` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `description` text NOT NULL,
  `price` float(9,2) unsigned NOT NULL,
  `createdate` datetime NOT NULL,
  `isactive` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `description`, `price`, `createdate`, `isactive`, `order`) VALUES
(1, 'Музыкальная программа Диджей', '', 40000.00, '2014-08-14 00:00:00', 1, 1),
(2, 'Аренда зала (100 руб с человека)', '', 0.00, '2014-08-14 00:00:00', 0, 2),
(3, 'Аренда сцены (свет и мощность подключения)', '', 20000.00, '2014-08-14 00:00:00', 1, 3),
(4, 'Аренда балкона', '', 20000.00, '2014-08-14 00:00:00', 1, 4),
(5, 'Аренда зала после 24 часов (в час) 20000 рублей', '', 0.00, '2014-08-14 00:00:00', 1, 5),
(13, 'Аренда зала', '100 руб с человека', 0.00, '2014-08-16 19:39:11', 1, 2),
(17, 'Новая услуга', 'Описание новой услуги', 3123123.00, '2014-08-16 19:45:24', 1, 6);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
