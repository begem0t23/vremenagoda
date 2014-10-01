-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Окт 01 2014 г., 18:21
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
-- Структура таблицы `dishes_in_orders_history`
--

CREATE TABLE IF NOT EXISTS `dishes_in_orders_history` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `orderid` int(11) NOT NULL,
  `dishid` int(11) NOT NULL,
  `price` float(7,2) NOT NULL,
  `num` int(11) NOT NULL,
  `note` text NOT NULL,
  `kogda` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=259 ;

-- --------------------------------------------------------

--
-- Структура таблицы `services_in_orders_history`
--

CREATE TABLE IF NOT EXISTS `services_in_orders_history` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `orderid` int(10) unsigned NOT NULL,
  `serviceid` int(10) unsigned NOT NULL,
  `price` float(7,2) unsigned NOT NULL,
  `discont` int(3) unsigned NOT NULL DEFAULT '0',
  `num` float unsigned NOT NULL,
  `comment` text CHARACTER SET latin1 NOT NULL,
  `kogda` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='заказы услуг' AUTO_INCREMENT=148 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
