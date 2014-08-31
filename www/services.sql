-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 31, 2014 at 07:25 PM
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
  `price` float(7,2) unsigned NOT NULL,
  `byguestcount` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `createdate` datetime NOT NULL,
  `isactive` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `orderby` int(11) NOT NULL,
  `tocalculate` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `description`, `price`, `byguestcount`, `createdate`, `isactive`, `orderby`, `tocalculate`) VALUES
(1, 'Музыкальная программа Диджей', '', 40000.00, 0, '2014-08-14 00:00:00', 1, 1, 0),
(2, 'Аренда зала (100 руб с человека)', '', 100.00, 1, '2014-08-14 00:00:00', 0, 0, 0),
(3, 'Аренда сцены (свет и мощность подключения)', '', 20000.00, 0, '2014-08-14 00:00:00', 1, 2, 0),
(4, 'Аренда балкона', '', 20000.00, 0, '2014-08-14 00:00:00', 1, 3, 0),
(5, 'Аренда зала после 24 часов (в час) 20000 рублей', '', 20000.00, 0, '2014-08-14 00:00:00', 1, 4, 0),
(6, 'Аренда зала', '100 руб с человека', 100.00, 0, '2014-08-17 11:29:13', 0, 0, 0),
(7, 'Аренда зала', '100 руб с человека', 100.00, 1, '2014-08-17 11:31:42', 1, 5, 0),
(8, 'Пробковый сбор', 'добавляется если клиент приходит со своим спиртым', 200.00, 1, '2014-08-26 15:00:11', 0, 6, 0),
(9, 'Скидка на кухню', 'Скидка на все блюда без учета чаевых', 10.00, 0, '2014-08-27 11:48:27', 1, 1, 1),
(10, 'Скидка на бар', 'Скидка на все напитки без учета чаевых', 10.00, 0, '2014-08-27 11:49:05', 1, 2, 1),
(12, 'Чаевые', 'Наценка за обслуживание кухни и бара без учета скидок', 10.00, 0, '2014-08-27 11:50:08', 1, 3, 1),
(13, 'Пробковый сбор', 'добавляется если клиент приходит со своим спиртным', 200.00, 1, '2014-08-31 18:39:25', 0, 6, 0),
(14, 'Пробковый сбор', 'добавляется если клиент приходит со своим спиртным', 300.00, 1, '2014-08-31 19:21:19', 1, 6, 0),
(15, 'ууу', 'ууу33333333', 333.00, 1, '2014-08-31 19:23:06', 0, 7, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
