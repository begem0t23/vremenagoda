-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Сен 09 2014 г., 16:05
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
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `pass` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `realname` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `role` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `isactive` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `pass`, `realname`, `role`, `isactive`) VALUES
(1, 'aabogachev@gmail.com', '6c14da109e294d1e8155be8aa4b1ce8e', 'Bogachev', 5, 1),
(2, 'petervolok@yandex.ru', '827ccb0eea8a706c4c34a16891f84e7b', 'PVolok', 5, 1),
(3, 'igor_pronin@mail.ru', '6c14da109e294d1e8155be8aa4b1ce8e', 'Pronin', 5, 1),
(4, 'eee@yandex.ru', '3d2172418ce305c7d16d4b05597c6a59', 'qqq', 2, 0),
(5, '123@123.com', 'b0baee9d279d34fa1dfd71aadb908c3f', 'user1', 1, 0),
(6, '123@123.com', '3d2172418ce305c7d16d4b05597c6a59', 'user1', 1, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
