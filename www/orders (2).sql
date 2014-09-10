-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Сен 10 2014 г., 07:48
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
  `type` text NOT NULL,
  `comment` text NOT NULL,
  `totaltime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `creatorid`, `createdate`, `clientid`, `eventdate`, `eventtime`, `guestcount`, `status`, `managerid`, `hallid`, `type`, `comment`, `totaltime`) VALUES
(1, 2, '2014-09-09 00:00:00', 1, '2013-09-20', '00:00:00', 18, 2, 2, 1, 'юбилей', 'проверить все', 0),
(2, 2, '2014-09-09 00:00:00', 2, '2020-09-20', '17:00:00', 34, 2, 2, 1, 'вечер', 'паварпарпропроролродлдлододжодолд', 0),
(3, 2, '2014-09-10 00:00:00', 2, '2025-09-20', '00:00:00', 33, 2, 2, 2, 'ааааааааааа', 'мммммммммммм', 0),
(4, 2, '2014-09-10 00:00:00', 2, '2028-09-20', '00:00:00', 35, 2, 2, 1, 'вываыаы', 'ывавыаыаы', 0),
(5, 2, '2014-09-10 00:00:00', 2, '2028-09-20', '00:00:00', 35, 2, 2, 1, 'вываыаы', 'ывавыаыаы', 0),
(6, 2, '2014-09-10 00:00:00', 2, '2028-09-20', '00:00:00', 35, 2, 2, 1, 'вываыаы', 'ывавыаыаы', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
