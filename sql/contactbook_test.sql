-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июл 28 2023 г., 08:38
-- Версия сервера: 5.7.33
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `contactbook_test`
--

-- --------------------------------------------------------

--
-- Структура таблицы `test_contacts`
--

CREATE TABLE `test_contacts` (
  `id` int(10) UNSIGNED NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `contact_code` char(3) NOT NULL,
  `contact_phone` char(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `test_contacts`
--

INSERT INTO `test_contacts` (`id`, `contact_name`, `contact_code`, `contact_phone`) VALUES
(36, 'Карим Бензема', '800', '1111111'),
(38, 'Тибо Куртуа', '800', '1111122'),
(48, 'Анхель Ди Мария', '423', '2222222'),
(50, 'Лука Модрич', '800', '2222222'),
(52, 'Садио Мане', '800', '1111133'),
(53, 'Лаутаро Мартинес', '495', '3333333'),
(55, 'Неймар', '555', '4444444');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `test_contacts`
--
ALTER TABLE `test_contacts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `contact_code` (`contact_code`,`contact_phone`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `test_contacts`
--
ALTER TABLE `test_contacts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
