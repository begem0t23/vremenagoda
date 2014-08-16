-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Авг 16 2014 г., 18:59
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
-- Структура таблицы `services`
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `services`
--

INSERT INTO `services` (`id`, `name`, `description`, `price`, `byguestcount`, `createdate`, `isactive`, `orderby`) VALUES
(1, 'Музыкальная программа Диджей', '', 40000.00, 0, '2014-08-14 00:00:00', 1, 0),
(2, 'Аренда зала (100 руб с человека)', '', 100.00, 1, '2014-08-14 00:00:00', 1, 0),
(3, 'Аренда сцены (свет и мощность подключения)', '', 20000.00, 0, '2014-08-14 00:00:00', 1, 0),
(4, 'Аренда балкона', '', 20000.00, 0, '2014-08-14 00:00:00', 1, 0),
(5, 'Аренда зала после 24 часов (в час) 20000 рублей', '', 20000.00, 0, '2014-08-14 00:00:00', 1, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
