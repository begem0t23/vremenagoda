-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 06, 2014 at 03:28 AM
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
-- Table structure for table `dishes`
--

CREATE TABLE IF NOT EXISTS `dishes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `weight` text NOT NULL,
  `price` float NOT NULL,
  `menu_section` int(11) NOT NULL,
  `createdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=337 ;

--
-- Dumping data for table `dishes`
--

INSERT INTO `dishes` (`id`, `title`, `description`, `weight`, `price`, `menu_section`, `createdate`) VALUES
(1, 'Судак фаршированный муссом из семги, судака и креветок', '', '3,9-4,2 кг', 9500, 1, '2014-08-05 22:47:45'),
(2, 'Сёмга запеченая целиком', '', '4,5-5,0 кг', 7500, 1, '2014-08-05 22:47:45'),
(3, 'Стерлядь запеченая', '', '1,3 кг', 6500, 1, '2014-08-05 22:47:45'),
(4, 'Осетрина целиком', '', '3,5-4,0 кг', 28000, 1, '2014-08-05 22:47:45'),
(5, 'Поросёнок, жареный целиком "по-боярски" ', '', '4,5-5 кг', 24000, 1, '2014-08-05 22:47:45'),
(6, 'Поросенок жареный целиком ', '', '3-3,5 кг', 17000, 1, '2014-08-05 22:47:45'),
(7, 'Нога телячья, запеченая целиком', '', '4,0-4,5 кг', 19000, 1, '2014-08-05 22:47:45'),
(8, 'Нога ягненка запеченая целиком', '', '2-2,3 кг', 7500, 1, '2014-08-05 22:47:45'),
(9, 'Индейка, запеченная с фруктами', '', '2,2-2,5 кг', 6500, 1, '2014-08-05 22:47:45'),
(10, 'Индейка, запеченная с фруктами', '', '3,2-3,5 кг', 9800, 1, '2014-08-05 22:47:45'),
(11, 'Курица запеченая, фаршированная потрахами ', '', '1,0-1,2 кг', 3500, 1, '2014-08-05 22:47:45'),
(12, 'Цесарка, запеченая с прованскими травами', '', '0,6-0,8 кг', 3800, 1, '2014-08-05 22:47:45'),
(13, 'Утка запеченая (подается с карамелизированным яблоком)', '', '1,3-1,5 кг', 5500, 1, '2014-08-05 22:47:45'),
(14, 'Кулебяка с капустой, яйцом и блинами (по-русски)', '', '2,0 кг', 3000, 1, '2014-08-05 22:47:45'),
(15, 'Икра кетовая       ', '', '50/25', 510, 2, '2014-08-05 22:47:45'),
(16, 'Осетрина заливная - с 01.10.2013', '', '150', 610, 2, '2014-08-05 22:47:45'),
(17, 'Севрюга горячего копчения, оливки, лимон', '', '100', 650, 2, '2014-08-05 22:47:45'),
(18, 'Балык из белуги, оливки, лимон', '', '100', 850, 2, '2014-08-05 22:47:45'),
(19, 'Сёмга слабой соли', '', '100', 440, 2, '2014-08-05 22:47:45'),
(20, 'Ассорти рыбное', '', '50/50/50/', 1350, 2, '2014-08-05 22:47:45'),
(21, 'Севрюга горячего копчения, белужий балык, угорь горячего копчения, ', '', '50/15', 0, 2, '2014-08-05 22:47:45'),
(22, 'Сельдь слабой соли бочковая ', '', '100/120', 450, 2, '2014-08-05 22:47:45'),
(23, 'Холодец домашний - с 01.10.2013', '', '200', 300, 2, '2014-08-05 22:47:45'),
(24, 'Витки из ветчины, фаршированные сыром с чесноком и грецким орехом ', '', '150', 390, 2, '2014-08-05 22:47:45'),
(25, 'Витки из сыра с ветчиной и грибами', '', '150', 390, 2, '2014-08-05 22:47:45'),
(26, 'Хамон с чесночными гренками ', '', '100/100', 610, 2, '2014-08-05 22:47:45'),
(27, 'Буженина запечёная домашняя', '', '85/25/25', 350, 2, '2014-08-05 22:47:45'),
(28, 'Язык говяжий заливной - с 01.10.2013', '', '75/75', 410, 2, '2014-08-05 22:47:45'),
(29, 'Язык говяжий отварной', '', '85/25/25', 400, 2, '2014-08-05 22:47:45'),
(30, 'Ростбиф запечёный по-домашнему', '', '85/25/25', 400, 2, '2014-08-05 22:47:45'),
(31, 'Ассорти колбас элитных сортов', '', '50/50/50/50', 1250, 2, '2014-08-05 22:47:45'),
(32, 'Ассорти мясных деликатесов приготовленных по-домашнему', '', '50/50/50/50/', 1500, 2, '2014-08-05 22:47:45'),
(33, 'Ростбиф, буженина по-домашнему, язык говяжий, ', '', '50/50', 0, 2, '2014-08-05 22:47:45'),
(34, 'Рулет из кролика с черносливом в беконе', '', '150', 510, 2, '2014-08-05 22:47:45'),
(35, 'Рулет из курицы с курагой и грецким орехом', '', '150', 390, 2, '2014-08-05 22:47:45'),
(36, 'Галантин из утки с фисташками', '', '150', 450, 2, '2014-08-05 22:47:45'),
(37, 'Рулетики из баклажан с томатами, грецким орехом и кинзой                          ', '', '150', 430, 2, '2014-08-05 22:47:45'),
(38, 'Рулетики из баклажан с курицей и грецким орехом ', '', '150', 450, 2, '2014-08-05 22:47:45'),
(39, 'Рулетики из баклажан с сыром Фета и зеленью', '', '150', 430, 2, '2014-08-05 22:47:45'),
(40, 'Бакинские помидоры, фаршированные сыром,', '', '200', 450, 2, '2014-08-05 22:47:45'),
(41, 'Бакинские помидоры, фаршированные с куриным мясом,', '', '200', 470, 2, '2014-08-05 22:47:45'),
(42, 'Овощи натуральные со свежей зеленью', '', '50/50/30/', 390, 2, '2014-08-05 22:47:45'),
(43, 'Свежие помидоры, огурцы, редис, ', '', '50/20', 0, 2, '2014-08-05 22:47:45'),
(44, 'Овощи бакинские с букетом ароматных трав', '', '50/50/', 450, 2, '2014-08-05 22:47:45'),
(45, 'Свежие бакинские помидоры и огурцы, ', '', '20/20/20/20', 0, 2, '2014-08-05 22:47:45'),
(46, 'Соленья "по-домашнему"', '', '100/100/100/', 350, 2, '2014-08-05 22:47:45'),
(47, 'Огурцы малосольные и солёные, квашенная капуста,', '', '100/100', 0, 2, '2014-08-05 22:47:45'),
(48, 'Белые маринованные грибы " Премиум"', '', '100', 430, 2, '2014-08-05 22:47:45'),
(49, 'Ассорти из лесных маринованные грибов', '', '100', 410, 2, '2014-08-05 22:47:45'),
(50, 'Маслины и оливки " Maestro de Oliva" Испания', '', '150', 250, 2, '2014-08-05 22:47:45'),
(51, 'Сыр Сулугини с бакинскими помидорами и свежей зеленью', '', '100/100/10', 420, 2, '2014-08-05 22:47:45'),
(52, 'Блины с красной икрой', '', '150/30', 480, 2, '2014-08-05 22:47:45'),
(53, 'Сёмга "под шубой"', '', '240', 480, 3, '2014-08-05 22:47:45'),
(54, 'Cельдь "под шубой"', '', '240', 460, 3, '2014-08-05 22:47:45'),
(55, 'Салат "Мимоза"', '', '240', 460, 3, '2014-08-05 22:47:45'),
(56, 'Салат с тунцом', '', '250', 390, 3, '2014-08-05 22:47:45'),
(57, 'Салат Брунуаз из осетрины', '', '200', 610, 3, '2014-08-05 22:47:46'),
(58, 'Салат "Оливье"', '', '200', 0, 3, '2014-08-05 22:47:46'),
(59, 'Салат из камчатских крабов ', '', '200/20', 630, 3, '2014-08-05 22:47:46'),
(60, 'Салат “Руккола” с тигровыми креветками ', '', '190', 530, 3, '2014-08-05 22:47:46'),
(61, 'Салат "Цезарь"', '', '200', 0, 3, '2014-08-05 22:47:46'),
(62, 'Салат из свиной вырезки с овощами, кедровым орехом и ', '', '250', 530, 3, '2014-08-05 22:47:46'),
(63, 'Салат с телятиной, белыми грибами и шампиньонами', '', '200', 480, 3, '2014-08-05 22:47:46'),
(64, 'Салат с говядиной, дайкон и маринованными опятами', '', '250', 510, 3, '2014-08-05 22:47:46'),
(65, 'Салат с ростбифом, маринованными огурчиками и опятами', '', '250', 430, 3, '2014-08-05 22:47:46'),
(66, 'Салат с говяжим языком и бакинскими томатами', '', '250', 530, 3, '2014-08-05 22:47:46'),
(67, 'Салат с куриной печенью, грушей и сыром фета', '', '300', 610, 3, '2014-08-05 22:47:46'),
(68, 'Салат c сыром Моццарелла, баклажанами гриль ', '', '220', 520, 3, '2014-08-05 22:47:46'),
(69, 'Салат "Капрезе" с сыром Моццарелла, помидорами и базиликом', '', '220', 510, 3, '2014-08-05 22:47:46'),
(70, 'Греческий салат с сыром Фета и цитрусовой запрвкой', '', '200', 440, 3, '2014-08-05 22:47:46'),
(71, 'Салат Винегрет с белыми грибами', '', '250', 250, 3, '2014-08-05 22:47:46'),
(72, 'Филе лосося в хрустящем тесте с розовым имбирем ', '', '100', 340, 4, '2014-08-05 22:47:46'),
(73, 'Кулебяка с лососем и шпинатом', '', '300', 480, 4, '2014-08-05 22:47:46'),
(74, 'Креветки в корзиночках из рисового теста со спаржей и', '', '100', 370, 4, '2014-08-05 22:47:46'),
(75, 'Жульен из даров моря в кокотнице', '', '90', 310, 4, '2014-08-05 22:47:46'),
(76, 'Жульен из даров моря в корзиночках из слоёного теста', '', '190', 490, 4, '2014-08-05 22:47:46'),
(77, 'Жульен грибной в кокотнице', '', '90', 280, 4, '2014-08-05 22:47:46'),
(78, 'Жульен из курицы в кокотнице', '', '90', 290, 4, '2014-08-05 22:47:46'),
(79, 'Жульен из курицы в корзиночках из слоёного теста', '', '190', 420, 4, '2014-08-05 22:47:46'),
(80, 'Жареные кольца кальмара с соусом "тар-тар"', '', '120/30', 350, 4, '2014-08-05 22:47:46'),
(81, 'со свининой и соусом чили', '', '260/30', 450, 4, '2014-08-05 22:47:46'),
(82, 'с говяжьей вырезкой и соусом чили', '', '260/30', 470, 4, '2014-08-05 22:47:46'),
(83, 'с бараниной и соусом чили', '', '260/30', 450, 4, '2014-08-05 22:47:46'),
(84, 'Перепелка, запеченая в духовке на овощном жульене ', '', '50/45/10', 370, 4, '2014-08-05 22:47:46'),
(85, 'Штрудель с шампиньонами, сыром и овощами', '', '120', 320, 4, '2014-08-05 22:47:46'),
(86, 'Баклажаны, запеченые со спелыми томатами, базиликом и', '', '120', 340, 4, '2014-08-05 22:47:46'),
(87, 'Стейк из осетрины по-московски', '', '180', 840, 5, '2014-08-05 22:47:46'),
(88, 'Стейк из осетрины с грибами и имбирным соусом', '', '180/50', 860, 5, '2014-08-05 22:47:46'),
(89, 'Филе судака с соусом Терияки', '', '170/30', 620, 5, '2014-08-05 22:47:46'),
(90, 'Форель запечёная в духовке', '', '1 шт', 470, 5, '2014-08-05 22:47:46'),
(91, 'Филе палтуса в рисовом тесте', '', '130/50', 590, 5, '2014-08-05 22:47:46'),
(92, 'Стейк из лосося', '', '150', 590, 5, '2014-08-05 22:47:46'),
(93, 'Стейк из лосося с шампиньонами и сыром', '', '180', 620, 5, '2014-08-05 22:47:46'),
(94, 'Стейк из лосося с крабовым мясом', '', '160', 710, 5, '2014-08-05 22:47:46'),
(95, 'Дорада с ароматом тимьяна', '', '200', 590, 5, '2014-08-05 22:47:46'),
(96, 'Филе сибаса с анисовым соусом', '', '1 шт/50', 590, 5, '2014-08-05 22:47:46'),
(97, 'Стейк из свиной вырезки с домашней аджикой', '', '170/40', 570, 6, '2014-08-05 22:47:46'),
(98, 'Каре свинины с грибным соусом', '', '180/30', 620, 6, '2014-08-05 22:47:46'),
(99, 'Медальоны из свинины в сливочном соусе', '', '140/60', 590, 6, '2014-08-05 22:47:46'),
(100, 'Вырезка из говядины', '', '150/50', 790, 6, '2014-08-05 22:47:46'),
(101, 'Риб-ай стейк из мраморной говядины', '', '300/50/15', 1790, 6, '2014-08-05 22:47:46'),
(102, 'Голень ягненка, тушеная с овощами с мясным соусом', '', '240/30', 1100, 6, '2014-08-05 22:47:46'),
(103, 'Каре ягнёнка с запеченое в слоеном тесте с горчичным соусом', '', '200/40', 1750, 6, '2014-08-05 22:47:46'),
(104, 'Каре ягнёнка с запечёными овощами (НОВАЯ ЗЕЛАНДИЯ )', '', '180/50', 1510, 6, '2014-08-05 22:47:46'),
(105, 'Цыплёнок "Табака"', '', '350', 480, 7, '2014-08-05 22:47:46'),
(106, 'Курица, запеченая в фольге с грибным соусом', '', '250/40', 530, 7, '2014-08-05 22:47:46'),
(107, 'Цесарка запеченая с ароматными травами, с соусом из дичи', '', '230/40', 580, 7, '2014-08-05 22:47:46'),
(108, 'Перепелка на гриле с перечным соусом', '', '150/30', 660, 7, '2014-08-05 22:47:46'),
(109, 'Утиная грудка с кунжутным соусом', '', '120/40', 780, 7, '2014-08-05 22:47:46'),
(110, 'Филе оленины с ягодным соусом', '', '160/30', 1850, 8, '2014-08-05 22:47:46'),
(111, 'Ножка зайца, тушеная в сметане с грибами', '', '160', 1150, 8, '2014-08-05 22:47:46'),
(112, 'Молочная телятина на косточке  с домашней аджикой с чесноком', '', '170/50/40', 810, 9, '2014-08-05 22:47:46'),
(113, 'Ягнятины на косточке с домашней аджикой с чесноком', '', '180/50/40', 870, 9, '2014-08-05 22:47:46'),
(114, 'Люля-кебаб из баранины с домашней аджикой с чесноком', '', '120/50/40', 530, 9, '2014-08-05 22:47:46'),
(115, 'Куриное бедро маринованое в соевом соусе с домашней аджикой с чесноком', '', '180/40', 520, 9, '2014-08-05 22:47:46'),
(116, 'из даров моря  с острым соусом ', '', '35/35/35/50', 690, 10, '2014-08-05 22:47:46'),
(117, 'из осетрины с соусом тар-тар', '', '150/40', 850, 10, '2014-08-05 22:47:46'),
(118, 'из свинины   с домашней аджикой с чесноком', '', '150/40', 540, 10, '2014-08-05 22:47:46'),
(119, 'из говяжьей вырезки  с домашней аджикой с чесноком', '', '150/40', 710, 10, '2014-08-05 22:47:46'),
(120, 'Картофель жаренный', '', '150', 200, 11, '2014-08-05 22:47:46'),
(121, 'Картофель фри', '', '150', 200, 11, '2014-08-05 22:47:46'),
(122, 'Картофель запечёный', '', '150', 200, 11, '2014-08-05 22:47:46'),
(123, 'Овощи на гриле', '', '150', 200, 11, '2014-08-05 22:47:46'),
(124, 'Овощи на пару', '', '150', 200, 11, '2014-08-05 22:47:46'),
(125, 'Ассорти из запеченых овощей с ароматом чеснока и тимьяна', '', '350', 480, 11, '2014-08-05 22:47:46'),
(126, 'Рис Басмати на пару', '', '150', 200, 11, '2014-08-05 22:47:46'),
(127, 'Булочка французская белая с кунжутом', '', '10', 15, 12, '2014-08-05 22:47:46'),
(128, 'Булочка французская чёрная с кориандром', '', '10', 15, 12, '2014-08-05 22:47:46'),
(129, 'Домашний каравай ( для свадьбы)', '', '1000', 1200, 12, '2014-08-05 22:47:46'),
(130, '', '', '1шт /грамм', 0, 13, '2014-08-05 22:47:46'),
(131, 'С капустой', '', '40', 50, 13, '2014-08-05 22:47:46'),
(132, 'С грибами', '', '40', 50, 13, '2014-08-05 22:47:46'),
(133, 'С мясом', '', '40', 50, 13, '2014-08-05 22:47:46'),
(134, 'С капустой', '', '50', 70, 14, '2014-08-05 22:47:46'),
(135, 'С грибами', '', '50', 70, 14, '2014-08-05 22:47:46'),
(136, 'С мясом', '', '50', 70, 14, '2014-08-05 22:47:46'),
(137, 'Расстегаи', '', '40', 60, 14, '2014-08-05 22:47:46'),
(138, 'Кулебяка из лосося и шпината', '', '290', 480, 14, '2014-08-05 22:47:46'),
(139, 'Торт на заказ от 1 кг.', '', '1000', 1900, 15, '2014-08-05 22:47:46'),
(140, 'Мини-пирожные', '', '1шт. /г', 0, 15, '2014-08-05 22:47:46'),
(141, 'Йогуртовые', '', '30', 150, 15, '2014-08-05 22:47:46'),
(142, 'Медовые', '', '30', 150, 15, '2014-08-05 22:47:46'),
(143, 'Шоколадные', '', '30', 150, 15, '2014-08-05 22:47:46'),
(144, 'Мини-эклеры', '', '1шт. /г', 0, 15, '2014-08-05 22:47:46'),
(145, 'Ореховые', '', '20', 100, 15, '2014-08-05 22:47:46'),
(146, 'Ванильные', '', '20', 100, 15, '2014-08-05 22:47:46'),
(147, 'Шоколадные', '', '20', 100, 15, '2014-08-05 22:47:46'),
(148, 'Ассорти из разнообразных сыров', '', '30/30/30/30/', 670, 16, '2014-08-05 22:47:46'),
(149, 'Камамбер, Грана Подана, Дор Блю,Чеддер, козий сыр', '', '15/30/30', 0, 16, '2014-08-05 22:47:46'),
(150, 'Ваза с фруктами', '', '1600', 2100, 16, '2014-08-05 22:47:46'),
(151, 'Ягодная тарелка', '', '250', 1300, 16, '2014-08-05 22:47:46'),
(152, 'Замок из ананаса', '', '1 шт.', 1150, 16, '2014-08-05 22:47:46'),
(153, 'Арбуз "Цветочная корзина" (по сезону)', '', '1 шт.', 1500, 16, '2014-08-05 22:47:46'),
(154, 'Дыня "Ладья" (по сезону)', '', '1 шт.', 2500, 16, '2014-08-05 22:47:46'),
(155, 'Российское Шампанское. Санкт-Питербург', '', '750 мл', 690, 18, '2014-08-05 22:47:46'),
(156, 'Российск. Шампанское Абрау -Дюрсо, Белое, золотой брют', '', '750 мл', 950, 18, '2014-08-05 22:47:46'),
(157, 'Российское Шампанское Абрау -Дюрсо, Красное, полусладкое', '', '750 мл', 950, 18, '2014-08-05 22:47:46'),
(158, 'Де Перрьер Блан де Блан. Брют. Эф. Джи. Ви. Эс .Франция', '', '750 мл', 1550, 18, '2014-08-05 22:47:46'),
(159, 'Вальдо Просекко Экстра Драй Док. Венето. Италия', '', '750 мл', 1950, 18, '2014-08-05 22:47:46'),
(160, 'Мартини Асти (сладкое). Песьоне, Турин. Италия', '', '750 мл', 2500, 18, '2014-08-05 22:47:46'),
(161, 'Мартини Просекко. Венето. Италия', '', '750 мл', 2300, 18, '2014-08-05 22:47:46'),
(162, 'Креман д’Эльзас Деми-сек. Рене Мюре. Франция', '', '750 мл', 2800, 18, '2014-08-05 22:47:46'),
(163, 'Лансон Блэк Лейбл Брют. Лансон. Франция', '', '750 мл', 4300, 18, '2014-08-05 22:47:46'),
(164, 'Лансон Розе Лейбл Брют Розе. Лансон. Франция', '', '750 мл', 6300, 18, '2014-08-05 22:47:46'),
(165, 'Моэт Шандон. Брют Империал. Франция', '', '750 мл', 6900, 18, '2014-08-05 22:47:46'),
(166, 'Пеш Рок Блан. (полусухое)', '', '750 мл', 950, 35, '2014-08-05 22:47:46'),
(167, 'Шато Мейн Паргад. Бордо ', '', '750 мл', 950, 35, '2014-08-05 22:47:46'),
(168, 'Бордо. Барон Филипп де Ротшильд Блан', '', '750 мл', 1150, 35, '2014-08-05 22:47:46'),
(169, 'Шардонне."Шевалье Лакассан"', '', '750 мл', 1200, 35, '2014-08-05 22:47:46'),
(170, 'Шардонне. Ла Гаре. Жорж Дюбеф', '', '750 мл', 1490, 35, '2014-08-05 22:47:46'),
(171, 'Совиньон "Таркет". Кот де Гасконь', '', '750 мл', 1900, 35, '2014-08-05 22:47:46'),
(172, 'Сансерр Блан "Ле Кайотт". Жан-Макс Роже ', '', '750 мл', 3750, 35, '2014-08-05 22:47:46'),
(173, 'Шабли. Ларош ', '', '750 мл', 3700, 35, '2014-08-05 22:47:46'),
(174, 'Шабли Премьер Крю. Симоне-Февр. Бургундия', '', '750 мл', 3950, 35, '2014-08-05 22:47:46'),
(175, 'Шабли Премьер Крю. Домейн Ларош. ', '', '750 мл', 5925, 35, '2014-08-05 22:47:46'),
(176, 'Орвието. Минини', '', '750 мл', 1280, 36, '2014-08-05 22:47:46'),
(177, 'Пино Гриджио. Конте Фоско делле Венецие', '', '750 мл', 1300, 36, '2014-08-05 22:47:46'),
(178, 'Соаве Классико Корте Менини ', '', '750 мл', 2100, 36, '2014-08-05 22:47:46'),
(179, 'Ла Сегрета. Планета. Сицилия', '', '750 мл', 2300, 36, '2014-08-05 22:47:46'),
(180, 'Мастро. Мастроберардино. Кампания', '', '750 мл', 2400, 36, '2014-08-05 22:47:46'),
(181, 'Гави ди Гави. Вилла Спарина ', '', '750 мл', 2690, 36, '2014-08-05 22:47:46'),
(182, 'Маркес де Касерес Бланко', '', '750 мл', 1450, 37, '2014-08-05 22:47:46'),
(183, 'Шардоне Монтемар Андес. Централ Вэлли ', '', '750 мл', 1190, 38, '2014-08-05 22:47:46'),
(184, 'Мапу Совиньон Блан. Барон Филипп де Ротшильд ', '', '750 мл', 980, 38, '2014-08-05 22:47:46'),
(185, 'Савиньон Блан  "Такун". Резерва. Централ Вэлли ', '', '750 мл', 1200, 38, '2014-08-05 22:47:46'),
(186, 'Шардоне Эскудо Рохо. Барон Филипп де Ротшильд', '', '750 мл', 2690, 38, '2014-08-05 22:47:46'),
(187, 'Бордо. Барон Филипп де Ротшильд Розе.Франция', '', '750 мл', 1150, 39, '2014-08-05 22:47:46'),
(188, 'Тускулум Бьянко. Казама. Италия (полусладкое)', '', '750 мл', 950, 40, '2014-08-05 22:47:46'),
(189, 'Бордо. Барон Филипп де Ротшильд Руж', '', '750 мл', 1150, 42, '2014-08-05 22:47:46'),
(190, 'Мерло "Шевалье Лакассан". Лангедок-Руссильон', '', '750 мл', 1200, 42, '2014-08-05 22:47:46'),
(191, 'Шато Де Креси. Бордо', '', '750 мл', 1450, 42, '2014-08-05 22:47:46'),
(192, 'Каберне Совиньон. Жорж Дюбеф ', '', '750 мл', 2100, 42, '2014-08-05 22:47:46'),
(193, 'Бургонь Пино Нуар. Шарль Эне', '', '750 мл', 2200, 42, '2014-08-05 22:47:46'),
(194, 'Бруйи. Анри Фесси. Бургундия', '', '750 мл', 2450, 42, '2014-08-05 22:47:46'),
(195, 'Кот дю Рон. Долина Роны. Е. Гигаль', '', '750 мл', 3150, 42, '2014-08-05 22:47:46'),
(196, 'Шато Гайар. Гран Крю. Сэнт-Эмильон. Бордо ', '', '750 мл', 5250, 42, '2014-08-05 22:47:46'),
(197, 'Терре Аллегре. Санджовезе. Апулия (полусладкое)', '', '750 мл', 950, 43, '2014-08-05 22:47:46'),
(198, 'Терре Аллегре. Санджовезе. Апулия (полусухое)', '', '750 мл', 950, 43, '2014-08-05 22:47:46'),
(199, 'Кьянти. Минини. Тоскана. Италия ', '', '750 мл', 1300, 43, '2014-08-05 22:47:46'),
(200, 'Ла Сегрета. Планета. Сицилия', '', '750 мл', 2300, 43, '2014-08-05 22:47:46'),
(201, 'Мастро. Мастроберардино. Кампания', '', '750 мл', 2400, 43, '2014-08-05 22:47:46'),
(202, 'Вальполичелла Классико', '', '750 мл', 3200, 43, '2014-08-05 22:47:46'),
(203, 'Кьянти Классико. Иль Молино ди Граче', '', '750 мл', 5400, 43, '2014-08-05 22:47:46'),
(204, 'Брунелло Ди Монтальчино. Капарцо ', '', '750 мл', 8900, 43, '2014-08-05 22:47:46'),
(205, 'Ла Вендимия. Риоха. Бодегас Паласиос Ремондо', '', '750 мл', 2400, 44, '2014-08-05 22:47:46'),
(206, 'Маркиз де Касерес Резерва. Риоха  ', '', '750 мл', 4750, 44, '2014-08-05 22:47:46'),
(207, 'Карменер Резерва.  Барон Филипп де Ротшильд    ', '', '750 мл', 2690, 45, '2014-08-05 22:47:46'),
(208, 'МАПУ Мерло. Барон Филипп де Ротшильд    ', '', '750 мл', 980, 45, '2014-08-05 22:47:46'),
(209, 'Эскудо Рохо.  Барон Филипп де Ротшильд ', '', '750 мл', 2710, 45, '2014-08-05 22:47:46'),
(210, 'Мерло, Монтес Альфа , Колчагуа Вэлли', '', '750 мл', 3200, 45, '2014-08-05 22:47:46'),
(211, 'Мальбек. Финка ла Линда. Мендоса', '', '750 мл', 1150, 46, '2014-08-05 22:47:46'),
(212, 'Ла Капра Пинотаж. Паарл. Фэирвью', '', '750 мл', 1800, 47, '2014-08-05 22:47:46'),
(213, 'Эвиан ', '', '330 мл', 190, 19, '2014-08-05 22:47:46'),
(214, 'Вода "Арджи" б/г', '', '500 мл', 150, 19, '2014-08-05 22:47:46'),
(215, 'Вода Архыз Б/Г', '', '500 мл', 150, 19, '2014-08-05 22:47:46'),
(216, 'Вита "Архыз" с/г', '', '500 мл', 150, 19, '2014-08-05 22:47:46'),
(217, 'Клюквенный морс', '', '250 мл', 90, 19, '2014-08-05 22:47:46'),
(218, 'Перрье ', '', '330 мл', 150, 19, '2014-08-05 22:47:46'),
(219, 'Борожоми', '', '500 мл', 190, 19, '2014-08-05 22:47:46'),
(220, 'Нарзан Элит ', '', '330 мл', 140, 19, '2014-08-05 22:47:46'),
(221, 'Ессентуки № 4 ', '', '500 мл', 150, 19, '2014-08-05 22:47:46'),
(222, 'Кока-Кола', '', '250 мл', 120, 19, '2014-08-05 22:47:46'),
(223, 'Кока-Кола лайт ', '', '250 мл', 120, 19, '2014-08-05 22:47:46'),
(224, 'Спрайт ', '', '250 мл', 120, 19, '2014-08-05 22:47:46'),
(225, 'Швепс Тоник ', '', '250 мл', 120, 19, '2014-08-05 22:47:46'),
(226, 'Апельсиновый  ', '', '200 мл', 300, 48, '2014-08-05 22:47:46'),
(227, 'Грейпфрутовый ', '', '200 мл', 300, 48, '2014-08-05 22:47:46'),
(228, 'Апельсиново-грейпфрутовый ', '', '200 мл', 300, 48, '2014-08-05 22:47:46'),
(229, 'Яблочный', '', '200 мл', 300, 48, '2014-08-05 22:47:46'),
(230, 'Морковный ', '', '200 мл', 200, 48, '2014-08-05 22:47:46'),
(231, 'Яблочно-морковный ', '', '200 мл', 300, 48, '2014-08-05 22:47:46'),
(232, 'Ананасовый ', '', '200 мл', 350, 48, '2014-08-05 22:47:46'),
(233, 'Сок сельдерея ', '', '200 мл', 250, 48, '2014-08-05 22:47:46'),
(234, 'Лимонный', '', '200 мл', 350, 48, '2014-08-05 22:47:46'),
(235, 'Гранатовый ', '', '200 мл', 450, 48, '2014-08-05 22:47:46'),
(236, 'СОКИ "RICH" В АСCОРТИМЕНТЕ ', '', '1л', 300, 49, '2014-08-05 22:47:46'),
(237, 'Клюквенный морс', '', '1л', 360, 49, '2014-08-05 22:47:46'),
(238, 'Апельсиновый ', '', '1,5 л', 800, 50, '2014-08-05 22:47:46'),
(239, 'Грейпфрутовый ', '', '1,5 л', 800, 50, '2014-08-05 22:47:46'),
(240, 'Мандариновый ', '', '1,5 л', 850, 50, '2014-08-05 22:47:46'),
(241, 'Яблочный ', '', '1,5 л', 800, 50, '2014-08-05 22:47:46'),
(242, 'Ананасовый  ', '', '1,5 л', 850, 50, '2014-08-05 22:47:46'),
(243, 'Лимонный ', '', '1,5 л', 800, 50, '2014-08-05 22:47:46'),
(244, 'Имбирный с лимоном  ', '', '1,5 л', 900, 50, '2014-08-05 22:47:46'),
(245, 'Безалкогольный Мохито ', '', '300 мл', 290, 20, '2014-08-05 22:47:46'),
(246, 'Безалкогольный Мохито - Клубничный', '', '300 мл', 340, 20, '2014-08-05 22:47:46'),
(247, 'Имбирный коктейль ', '', '300 мл', 180, 20, '2014-08-05 22:47:46'),
(248, 'Ванильный Молочный Коктейль ', '', '300 мл', 250, 20, '2014-08-05 22:47:46'),
(249, 'Шоколадный Молочный Коктейль ', '', '300 мл', 250, 20, '2014-08-05 22:47:46'),
(250, 'Клубничный Молочный Коктейль ', '', '300 мл', 350, 20, '2014-08-05 22:47:46'),
(251, 'Крушовице Империал светлое', '', '500 мл', 350, 21, '2014-08-05 22:47:46'),
(252, 'Велкопоповицкий Козел светлое ', '', '500 мл', 260, 21, '2014-08-05 22:47:46'),
(253, 'Велкопоповицкий Козел тёмное ', '', '500 мл', 240, 21, '2014-08-05 22:47:46'),
(254, '"Гролш" безалкогольное ', '', '330 мл', 290, 21, '2014-08-05 22:47:46'),
(255, 'Глинтвейн ', '', '200 мл', 290, 22, '2014-08-05 22:47:46'),
(256, 'Кир Ройал ', '', '150 мл', 250, 22, '2014-08-05 22:47:46'),
(257, 'Кровавая Мэри ', '', '200 мл', 190, 22, '2014-08-05 22:47:46'),
(258, 'Кампари Оранж ', '', '200 мл', 250, 22, '2014-08-05 22:47:46'),
(259, 'Куба Либре (Ром Кола) ', '', '300 мл', 360, 22, '2014-08-05 22:47:46'),
(260, 'Голубая Лагуна', '', '130 мл', 300, 22, '2014-08-05 22:47:46'),
(261, 'Джин Тоник ', '', '300 мл', 360, 22, '2014-08-05 22:47:46'),
(262, 'Виски Кола ', '', '300 мл', 360, 22, '2014-08-05 22:47:46'),
(263, 'Лонг Айленд Айс Ти ', '', '300 мл', 450, 22, '2014-08-05 22:47:46'),
(264, 'Мохито ', '', '300 мл', 360, 22, '2014-08-05 22:47:46'),
(265, 'Мохито Клубничный ', '', '300 мл', 410, 22, '2014-08-05 22:47:46'),
(266, 'Маргарита Классическая ', '', '120 мл', 300, 22, '2014-08-05 22:47:46'),
(267, 'Маргарита Клубничная', '', '130 мл', 390, 22, '2014-08-05 22:47:46'),
(268, 'Космополитен ', '', '130 мл', 300, 22, '2014-08-05 22:47:46'),
(269, 'Б-52 ', '', '45 мл', 290, 22, '2014-08-05 22:47:46'),
(270, 'Кампари', '', '1,0 л', 3800, 23, '2014-08-05 22:47:46'),
(271, 'Мартини Бьянко или Розе ', '', '1,0 л', 4000, 23, '2014-08-05 22:47:46'),
(272, 'Мартини Россо ', '', '1,0 л', 4400, 23, '2014-08-05 22:47:46'),
(273, 'Фернет Бранка ', '', '0,7л', 4620, 23, '2014-08-05 22:47:46'),
(274, 'Фернет Бранка Менте ', '', '0,7 л', 4760, 23, '2014-08-05 22:47:46'),
(275, 'Порто Рамош Пинто Руби', '', '0,75 л', 3700, 24, '2014-08-05 22:47:46'),
(276, 'Самбука ', '', '0,7 л', 2800, 25, '2014-08-05 22:47:46'),
(277, 'Крем де Кассис (Чёрная смородина)', '', '0,7 л', 2800, 25, '2014-08-05 22:47:46'),
(278, 'Бейлиз ', '', '1,0 л', 5600, 25, '2014-08-05 22:47:46'),
(279, 'Куантро ', '', '1,0 л', 7000, 25, '2014-08-05 22:47:46'),
(280, 'Калуа ', '', '1,0 л', 6000, 25, '2014-08-05 22:47:46'),
(281, 'Ягермайстер', '', '1,0 л', 3900, 25, '2014-08-05 22:47:46'),
(282, 'Биффитер', '', '1,0 л', 6000, 26, '2014-08-05 22:47:46'),
(283, 'Столичная ', '', '0,5 л', 1200, 26, '2014-08-05 22:47:46'),
(284, 'Русский Стандарт ', '', '0,5 л', 1600, 26, '2014-08-05 22:47:46'),
(285, 'Русский Стандарт Платинум ', '', '0,5 л', 2300, 26, '2014-08-05 22:47:46'),
(286, 'Белое Золото ', '', '0,7 л', 2380, 26, '2014-08-05 22:47:46'),
(287, 'Белое Золото ', '', '0,5 л', 1700, 26, '2014-08-05 22:47:46'),
(288, 'Белое Золото Премиум', '', '0,5 л', 2400, 26, '2014-08-05 22:47:46'),
(289, 'Белуга ', '', '0,5 л', 2500, 26, '2014-08-05 22:47:46'),
(290, 'Камино Реал Бланко ', '', '0,750 л', 3000, 27, '2014-08-05 22:47:46'),
(291, 'Текила Ольмека Серебряная ', '', '1,0 л', 7200, 27, '2014-08-05 22:47:46'),
(292, 'Текила Ольмека Золотая', '', '1,0 л', 7600, 27, '2014-08-05 22:47:46'),
(293, 'Бакарди Белый ', '', '1 л', 5000, 28, '2014-08-05 22:47:46'),
(294, 'Бакарди Чёрный', '', '1 л', 6000, 28, '2014-08-05 22:47:46'),
(295, 'Бакарди Оакхарт Пряный ', '', '1 л', 6000, 28, '2014-08-05 22:47:46'),
(296, 'Бакарди Золотой ', '', '0,75 л', 4125, 28, '2014-08-05 22:47:46'),
(297, 'Джеймесон', '', '1,0 л', 7600, 29, '2014-08-05 22:47:46'),
(298, 'Вильям Лоусонс', '', '0,75 л', 2250, 29, '2014-08-05 22:47:46'),
(299, 'Дюарс Уайт Лейбл', '', '1 л', 4980, 29, '2014-08-05 22:47:46'),
(300, 'Баллантайнс ', '', '1,0 л', 7600, 29, '2014-08-05 22:47:46'),
(301, 'Джек Дениэлс', '', '1,0 л', 8400, 29, '2014-08-05 22:47:46'),
(302, 'Джонни Уокер Ред Лэйбл ', '', '1,0 л', 7600, 29, '2014-08-05 22:47:46'),
(303, 'Джонни Уокер Блэк Лэйбл ', '', '1,0 л', 11200, 29, '2014-08-05 22:47:46'),
(304, 'Чивас Ригал 12 л. ', '', '1,0 л', 11800, 29, '2014-08-05 22:47:46'),
(305, 'Чивас Ригал 18 л. ', '', '1,0 л', 19800, 29, '2014-08-05 22:47:46'),
(306, 'Мартель V.S.O.P.', '', '1,0 л', 17000, 30, '2014-08-05 22:47:46'),
(307, 'Мартель V.S.O.P.', '', '0,7 л', 11900, 30, '2014-08-05 22:47:46'),
(308, 'Мартель ХО', '', '1 л', 37000, 30, '2014-08-05 22:47:46'),
(309, 'Мартель X.O. ', '', '0,7 л', 25900, 30, '2014-08-05 22:47:46'),
(310, 'Хеннесси V.S.O.P. ', '', '1,0 л', 18000, 30, '2014-08-05 22:47:46'),
(311, 'Хеннесси V.S.O.P. ', '', '0,7 л', 12600, 30, '2014-08-05 22:47:46'),
(312, 'Хеннесси X.O. ', '', '0,7 л', 35560, 30, '2014-08-05 22:47:46'),
(313, 'Арарат ***** 5л.  ', '', '0,5 л', 3500, 31, '2014-08-05 22:47:46'),
(314, 'Арарат "Ани"  6 л. ', '', '0,5 л', 3700, 31, '2014-08-05 22:47:46'),
(315, 'Арарат "Отборный" 7 л.', '', '0,5 л', 4200, 31, '2014-08-05 22:47:46'),
(316, 'Ристретто ', '', '15 мл', 150, 32, '2014-08-05 22:47:46'),
(317, 'Эспрессо ', '', '40 мл', 150, 32, '2014-08-05 22:47:46'),
(318, 'Двойной эспрессо ', '', '80 мл', 250, 32, '2014-08-05 22:47:46'),
(319, 'Американо ', '', '100 мл', 150, 32, '2014-08-05 22:47:46'),
(320, 'Каппучино ', '', '220 мл', 220, 32, '2014-08-05 22:47:46'),
(321, 'Латте', '', '250 мл', 220, 32, '2014-08-05 22:47:46'),
(322, 'По-восточному ', '', '200 мл', 160, 32, '2014-08-05 22:47:46'),
(323, 'Ирландский Кофе ', '', '200 мл', 320, 32, '2014-08-05 22:47:46'),
(324, 'Кофе “Бейлиз”', '', '200 мл', 320, 32, '2014-08-05 22:47:46'),
(325, 'Какао ', '', '200 мл', 210, 32, '2014-08-05 22:47:46'),
(326, 'Цейлон ', '', '400 мл', 290, 51, '2014-08-05 22:47:46'),
(327, 'Чёрный байховый с чабрецом ', '', '400 мл', 290, 51, '2014-08-05 22:47:46'),
(328, 'Дарджилинг ', '', '400 мл', 290, 51, '2014-08-05 22:47:46'),
(329, 'Эрл Грей ', '', '400 мл', 290, 51, '2014-08-05 22:47:46'),
(330, 'Пуэр Императорский ', '', '400 мл', 350, 51, '2014-08-05 22:47:46'),
(331, 'Чунь-Ми', '', '400 мл', 290, 52, '2014-08-05 22:47:46'),
(332, 'Жасмин Чунг Хао', '', '400 мл', 350, 52, '2014-08-05 22:47:46'),
(333, 'Молочный Улун', '', '400 мл', 350, 52, '2014-08-05 22:47:46'),
(334, 'Серебряные Иглы ', '', '400 мл', 350, 53, '2014-08-05 22:47:46'),
(335, 'Земляника со сливками', '', '400 мл', 350, 54, '2014-08-05 22:47:46'),
(336, 'Мятный отвар ', '', '400 мл', 290, 55, '2014-08-05 22:47:46');

-- --------------------------------------------------------

--
-- Table structure for table `menu_sections`
--

CREATE TABLE IF NOT EXISTS `menu_sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section_name` text NOT NULL,
  `level` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `menu_type_id` int(11) NOT NULL,
  `sortid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=56 ;

--
-- Dumping data for table `menu_sections`
--

INSERT INTO `menu_sections` (`id`, `section_name`, `level`, `parent_id`, `menu_type_id`, `sortid`) VALUES
(1, ' СПЕЦИАЛЬНЫЕ БАНКЕТНЫЕ БЛЮДА И ЗАКУСКИ  ОТ ШЕФ-ПОВАРА РЕСТОРАНА "ВРЕМЕНА ГОДА"', 0, 0, 1, 0),
(2, 'ХОЛОДНЫЕ ЗАКУСКИ', 0, 0, 1, 0),
(3, 'САЛАТЫ', 0, 0, 1, 0),
(4, 'ГОРЯЧИЕ ЗАКУСКИ', 0, 0, 1, 0),
(5, 'ГОРЯЧИЕ БЛЮДА ИЗ РЫБЫ', 0, 0, 1, 0),
(6, 'ГОРЯЧИЕ БЛЮДА ИЗ МЯСА', 0, 0, 1, 0),
(7, 'ГОРЯЧИЕ БЛЮДА ИЗ ПТИЦЫ', 0, 0, 1, 0),
(8, 'ГОРЯЧИЕ БЛЮДА ИЗ ДИЧИ', 0, 0, 1, 0),
(9, 'БЛЮДА НА МАНГАЛЕ', 0, 0, 1, 0),
(10, 'ШАШЛЫК', 0, 0, 1, 0),
(11, 'ГАРНИРЫ', 0, 0, 1, 0),
(12, 'ДОМАШНЯЯ ВЫПЕЧКА', 0, 0, 1, 0),
(13, 'ПИРОЖКИ ПЕЧЁНЫЕ', 1, 12, 1, 0),
(14, 'ПИРОЖКИ СЛОЕНЫЕ', 1, 12, 1, 0),
(15, 'ТОРТЫ И ПИРОЖНЫЕ НА ЗАКАЗ от Шефа-Кондитера ресторана " Времена Года"', 0, 0, 1, 0),
(16, 'СЫР И ДЕСЕРТЫ', 0, 0, 1, 0),
(17, 'Сорбеты и мороженое "Mövenpick"', 0, 0, 1, 0),
(18, 'Шампанское, Просекко  и Игристые Вина', 0, 0, 2, 0),
(19, 'БЕЗАЛКОГОЛЬНЫЕ НАПИТКИ ', 0, 0, 2, 0),
(20, ' БЕЗАЛКОГОЛЬНЫЕ КОКТЕЙЛИ', 1, 19, 2, 0),
(21, 'ПИВО БУТЫЛОЧНОЕ /РАЗЛИВНОЕ ', 0, 0, 2, 0),
(22, 'КОКТЕЙЛИ ', 0, 0, 2, 0),
(23, 'АППЕРИТИВЫ ', 0, 0, 2, 0),
(24, 'ПОРТО ', 0, 0, 2, 0),
(25, 'ЛИКЕРЫ ', 0, 0, 2, 0),
(26, 'ДЖИН/ВОДКА', 0, 0, 2, 0),
(27, 'ТЕКИЛА', 0, 0, 2, 0),
(28, 'РОМ ', 0, 0, 2, 0),
(29, 'ВИСКИ', 0, 0, 2, 0),
(30, 'КОНЬЯК', 0, 0, 2, 0),
(31, 'АРМЯНСКИЕ', 0, 0, 2, 0),
(32, 'КОФЕ ', 0, 0, 2, 0),
(33, 'ЧАЙ в чайнике  ', 0, 0, 2, 0),
(34, 'БЕЛОЕ ВИНО', 0, 0, 2, 0),
(35, 'Франция', 1, 34, 2, 0),
(36, 'Италия', 1, 34, 2, 0),
(37, 'Испания', 1, 34, 2, 0),
(38, 'Чили', 1, 34, 2, 0),
(39, 'РОЗОВОЕ ВИНО', 0, 0, 2, 0),
(40, 'ДЕСЕРТНОЕ ВИНО', 0, 0, 2, 0),
(41, 'КРАСНОЕ ВИНО', 0, 0, 2, 0),
(42, 'Франция', 1, 41, 2, 0),
(43, 'Италия', 1, 41, 2, 0),
(44, 'Испания ', 1, 41, 2, 0),
(45, 'Чили ', 1, 41, 2, 0),
(46, 'Аргентина ', 1, 41, 2, 0),
(47, 'ЮАР', 1, 41, 2, 0),
(48, 'СВЕЖЕВЫЖАТЫЙ СОК ', 1, 19, 2, 0),
(49, 'СОКИ', 1, 19, 2, 0),
(50, 'ДОМАШНИЙ ЛИМОНАД ', 1, 19, 2, 0),
(51, 'Черный', 1, 33, 2, 0),
(52, 'Зелёный чай ', 1, 33, 2, 0),
(53, 'Белый чай ', 1, 33, 2, 0),
(54, 'Фруктовый чай ', 1, 33, 2, 0),
(55, 'Мятный чай', 1, 33, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `menu_types`
--

CREATE TABLE IF NOT EXISTS `menu_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `menu_types`
--

INSERT INTO `menu_types` (`id`, `type_name`) VALUES
(1, 'Банкетное Меню'),
(2, 'Фуршетное Меню'),
(3, 'Меню Для Зала');

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
  `login` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `pass` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `realname` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `field` int(11) NOT NULL,
  `isactive` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `login`, `pass`, `realname`, `field`, `isactive`) VALUES
(1, 'aabogachev@gmail.com', '6c14da109e294d1e8155be8aa4b1ce8e', 'Bogachev', 0, 1),
(2, 'petervolok@yandex.ru', '827ccb0eea8a706c4c34a16891f84e7b', 'PVolok', 0, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
