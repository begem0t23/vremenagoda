-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Авг 20 2014 г., 14:05
-- Версия сервера: 5.1.73
-- Версия PHP: 5.3.28

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `user346_vg`
--

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `creatorid` int(10) unsigned NOT NULL,
  `createdate` datetime NOT NULL,
  `clientid` int(10) unsigned NOT NULL,
  `eventdate` date NOT NULL,
  `eventtime` time NOT NULL,
  `guestcount` int(10) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `managerid` int(10) NOT NULL,
  `hallid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `creatorid`, `createdate`, `clientid`, `eventdate`, `eventtime`, `guestcount`, `status`, `managerid`, `hallid`) VALUES
(1, 1, '2014-08-01 00:00:00', 1, '2014-09-05', '00:00:00', 0, 1, 0, 1),
(2, 1, '2014-08-02 00:00:00', 2, '2014-09-06', '00:00:00', 0, 2, 1, 2),
(3, 2, '2014-08-03 00:00:00', 3, '2014-09-07', '00:00:00', 0, 4, 2, 1),
(4, 2, '2014-08-01 00:00:00', 4, '2014-09-08', '00:00:00', 0, 1, 2, 1),
(5, 1, '2014-08-02 00:00:00', 2, '2014-09-20', '00:00:00', 0, 2, 1, 2),
(7, 1, '2014-08-20 00:00:00', 3, '2020-08-20', '19:30:00', 0, 2, 1, 1),
(8, 1, '2014-08-20 00:00:00', 6, '2023-08-20', '20:00:00', 0, 2, 1, 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
