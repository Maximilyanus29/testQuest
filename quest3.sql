-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Июл 25 2020 г., 16:23
-- Версия сервера: 10.4.11-MariaDB
-- Версия PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `quest3`
--

-- --------------------------------------------------------

--
-- Структура таблицы `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL,
  `nickname` varchar(50) CHARACTER SET utf8 NOT NULL,
  `rating` int(1) NOT NULL,
  `description` text NOT NULL,
  `link_photo1` varchar(255) CHARACTER SET utf8 NOT NULL,
  `link_photo2` varchar(255) CHARACTER SET utf8 NOT NULL,
  `link_photo3` varchar(255) CHARACTER SET utf8 NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `review`
--

INSERT INTO `review` (`id`, `nickname`, `rating`, `description`, `link_photo1`, `link_photo2`, `link_photo3`, `date`) VALUES
(1, 'sdfg', 1, 'ewfgrdhtfygmuhynfhtdgrsfergdtf', 'qwfegthf', 'qwdfegrt', 'wefrt', '2020-07-25 14:54:35'),
(21, '&#1094;', 2, 'r324tg35ht', '4wegrth', '4egrth', '3r4tgerht', '2020-07-25 15:56:01'),
(22, '&#1094;', 2, 'r324tg35ht', '4wegrth', '4egrth', '3r4tgerht', '2020-07-25 15:56:01'),
(23, '&#1094;wfaegsr', 2, 'r324tg35ht', '4wegrth', '4egrth', '3r4tgerht', '2020-07-25 15:56:55'),
(24, '&#1094;wfaegsr', 2, 'r324tg35ht', '4wegrth', '4egrth', '3r4tgerht', '2020-07-25 15:56:55'),
(25, 'wefgrth', 2, 'efwgrthbny', 'fewgrbt', 'wafesgr', 'aegsrbdtf', '2020-07-25 15:57:15'),
(26, 'wefgrth', 2, 'efwgrthbny', 'fewgrbt', 'wafesgr', 'aegsrbdtf', '2020-07-25 15:57:15'),
(27, 'max', 2, '3r24gretbgbdfrvse', 'r324t5htrnbrg', '234twgfedqs', 'w4t3e5rhtnfgbdvg', '2020-07-25 16:15:54'),
(28, 'egwrhtfnyguyjf', 2, 'efsgrdht', 'fesgrdht', 'segrdhtf', 'esgrdf', '2020-07-25 17:17:31'),
(29, 'egwrhtfnyguyjf', 2, 'efsgrdht', 'fesgrdht', 'segrdhtf', 'esgrdf', '2020-07-25 17:18:22');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
