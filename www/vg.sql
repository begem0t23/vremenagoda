-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2014 at 06:35 PM
-- Server version: 5.5.25
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `vg`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `phone` tinytext NOT NULL,
  `email` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `phone`, `email`) VALUES
(1, 'Иванов', '1234567', ''),
(2, 'Школа №1231', '2772727272', ''),
(3, 'Петров', '11111111111', ''),
(4, 'Джон Смит', '98879279428', '');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `creatorid` int(10) unsigned NOT NULL,
  `createdate` datetime NOT NULL,
  `clientid` int(10) unsigned NOT NULL,
  `eventdate` datetime NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `managerid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `creatorid`, `createdate`, `clientid`, `eventdate`, `status`, `managerid`) VALUES
(1, 1, '2014-08-01 00:00:00', 1, '2014-08-05 00:00:00', 1, 0),
(2, 1, '2014-08-02 00:00:00', 2, '2014-08-06 00:00:00', 2, 1),
(3, 2, '2014-08-03 00:00:00', 3, '2014-08-07 00:00:00', 4, 2),
(4, 2, '2014-08-01 00:00:00', 4, '2014-08-08 00:00:00', 1, 2),
(5, 1, '2014-08-02 00:00:00', 2, '2014-08-20 00:00:00', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `name`) VALUES
(0, 'Отмена'),
(1, 'Новый'),
(2, 'В Работе'),
(4, 'Получена Предоплата'),
(6, 'Полная Оплата'),
(8, 'Выполнен');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` tinytext NOT NULL,
  `pass` tinytext NOT NULL,
  `realname` tinytext NOT NULL,
  `field` int(11) NOT NULL,
  `isactive` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `login`, `pass`, `realname`, `field`, `isactive`) VALUES
(1, 'aabogachev@gmail.com', '6c14da109e294d1e8155be8aa4b1ce8e', 'Bogachev', 0, 1),
(2, 'petervolok@yandex.ru', '827ccb0eea8a706c4c34a16891f84e7b', 'PVolok', 0, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
