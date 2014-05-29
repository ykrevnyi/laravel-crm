-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.6.16 - MySQL Community Server (GPL)
-- ОС Сервера:                   Win32
-- HeidiSQL Версия:              8.3.0.4694
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры для таблица teil_crm_dev.currencies
DROP TABLE IF EXISTS `currencies`;
CREATE TABLE IF NOT EXISTS `currencies` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `unit` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы teil_crm_dev.currencies: ~3 rows (приблизительно)
DELETE FROM `currencies`;
/*!40000 ALTER TABLE `currencies` DISABLE KEYS */;
INSERT INTO `currencies` (`id`, `name`, `unit`) VALUES
	(1, 'USD', '$'),
	(2, 'Гривна', 'грн.'),
	(3, 'Рубль', 'руб.');
/*!40000 ALTER TABLE `currencies` ENABLE KEYS */;


-- Дамп структуры для таблица teil_crm_dev.currency_history
DROP TABLE IF EXISTS `currency_history`;
CREATE TABLE IF NOT EXISTS `currency_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `currency_id` int(11) unsigned NOT NULL,
  `price` varchar(50) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `deprecated_at` datetime DEFAULT '2099-01-01 00:00:00',
  PRIMARY KEY (`id`),
  KEY `currency_id` (`currency_id`),
  CONSTRAINT `FK_currency_history_currencies` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы teil_crm_dev.currency_history: ~3 rows (приблизительно)
DELETE FROM `currency_history`;
/*!40000 ALTER TABLE `currency_history` DISABLE KEYS */;
INSERT INTO `currency_history` (`id`, `currency_id`, `price`, `created_at`, `deprecated_at`) VALUES
	(2, 2, '1', '2014-01-01 00:00:00', '2099-01-01 00:00:00'),
	(3, 3, '0.31', '2014-01-01 00:00:00', '2099-01-01 00:00:00'),
	(7, 1, '13', '2014-01-01 00:00:00', '2099-01-01 00:00:00');
/*!40000 ALTER TABLE `currency_history` ENABLE KEYS */;


-- Дамп структуры для таблица teil_crm_dev.migrations
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Дамп данных таблицы teil_crm_dev.migrations: ~3 rows (приблизительно)
DELETE FROM `migrations`;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`migration`, `batch`) VALUES
	('2013_09_08_182322_create_users_table', 1),
	('2013_09_08_184042_create_users_group_table', 1),
	('2013_09_09_065654_add_email_field_to_users_table', 1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;


-- Дамп структуры для таблица teil_crm_dev.money_account
DROP TABLE IF EXISTS `money_account`;
CREATE TABLE IF NOT EXISTS `money_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `icon` text NOT NULL,
  `losses` float NOT NULL DEFAULT '0',
  `currency_id` int(11) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `currency_id` (`currency_id`),
  CONSTRAINT `money_account_ibfk_1` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы teil_crm_dev.money_account: ~9 rows (приблизительно)
DELETE FROM `money_account`;
/*!40000 ALTER TABLE `money_account` DISABLE KEYS */;
INSERT INTO `money_account` (`id`, `name`, `icon`, `losses`, `currency_id`, `created_at`, `updated_at`) VALUES
	(12, 'ЯД. Шкабко', '', 4, 3, '2014-04-29 08:07:48', '2014-05-14 09:57:25'),
	(13, 'WebMoney RUB', '', 10, 3, '2014-04-29 08:07:59', '2014-05-12 21:43:01'),
	(14, 'WebMoney UAH', '', 0, 2, '2014-04-29 08:08:09', '2014-05-02 11:13:45'),
	(15, 'ЯД. Босько', '', 0, 2, '2014-04-29 08:08:38', '2014-05-02 11:13:59'),
	(16, 'УкрСибБанк', '', 0, 2, '2014-04-29 08:08:46', '2014-05-02 11:14:20'),
	(17, 'Приват Банк', '', 0, 2, '2014-05-02 11:14:28', '2014-05-02 11:14:28'),
	(18, 'Qiwi', '', 4, 3, '2014-05-16 15:18:57', '2014-05-16 15:18:57'),
	(19, 'Интеркасса', '', 9, 2, '2014-05-21 09:07:23', '2014-05-21 09:07:23'),
	(20, 'Приват Банк (Юра)', '', 0, 2, '2014-05-26 12:50:16', '2014-05-26 12:50:16');
/*!40000 ALTER TABLE `money_account` ENABLE KEYS */;


-- Дамп структуры для таблица teil_crm_dev.project
DROP TABLE IF EXISTS `project`;
CREATE TABLE IF NOT EXISTS `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(1) NOT NULL DEFAULT '0',
  `project_priority_id` int(11) NOT NULL,
  `done_percents` int(11) NOT NULL,
  `actual_hours` varchar(255) NOT NULL DEFAULT '0',
  `end_date` date NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `project_priority_id` (`project_priority_id`),
  CONSTRAINT `project_ibfk_1` FOREIGN KEY (`project_priority_id`) REFERENCES `project_priority` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы teil_crm_dev.project: ~19 rows (приблизительно)
DELETE FROM `project`;
/*!40000 ALTER TABLE `project` DISABLE KEYS */;
INSERT INTO `project` (`id`, `status`, `project_priority_id`, `done_percents`, `actual_hours`, `end_date`, `created_at`, `updated_at`) VALUES
	(65, 0, 6, 10, '', '2014-04-28', '2014-03-30', '2014-04-29'),
	(69, 0, 8, 0, '0', '2014-06-12', '2014-05-02', '2014-05-02'),
	(70, 0, 8, 5, '0', '2014-06-06', '2014-05-02', '2014-05-02'),
	(71, 0, 6, 100, '0', '2014-05-07', '2014-05-07', '2014-05-07'),
	(72, 0, 6, 100, '0', '2014-05-12', '2014-05-12', '2014-05-12'),
	(73, 0, 9, 50, '0', '2014-05-25', '2014-05-13', '2014-05-13'),
	(74, 0, 6, 100, '0', '2014-04-30', '2014-05-13', '2014-05-13'),
	(75, 0, 6, 100, '0', '2014-02-15', '2014-05-13', '2014-05-13'),
	(76, 0, 8, 0, '0', '2014-06-30', '2014-05-14', '2014-05-14'),
	(77, 1, 6, 100, '0', '2014-05-16', '2014-05-16', '2014-05-16'),
	(78, 0, 8, 0, '0', '2014-05-18', '2014-05-16', '2014-05-16'),
	(79, 0, 8, 2, '0', '2014-06-14', '2014-05-21', '2014-05-21'),
	(80, 0, 8, 0, '0', '2014-05-23', '2014-05-22', '2014-05-22'),
	(81, 0, 8, 30, '0', '2014-05-23', '2014-05-22', '2014-05-22'),
	(82, 0, 9, 0, '0', '2014-05-27', '2014-05-23', '2014-05-23'),
	(83, 0, 8, 0, '0', '2014-06-14', '2014-05-23', '2014-05-23'),
	(84, 0, 8, 50, '0', '2014-06-13', '2014-05-26', '2014-05-26'),
	(85, 0, 6, 100, '0', '2014-02-28', '2014-05-28', '2014-05-28'),
	(86, 0, 8, 0, '0', '2014-05-30', '2014-05-28', '2014-05-28');
/*!40000 ALTER TABLE `project` ENABLE KEYS */;


-- Дамп структуры для таблица teil_crm_dev.project_description
DROP TABLE IF EXISTS `project_description`;
CREATE TABLE IF NOT EXISTS `project_description` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `desctiption_short` text NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`),
  CONSTRAINT `project_description_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы teil_crm_dev.project_description: ~19 rows (приблизительно)
DELETE FROM `project_description`;
/*!40000 ALTER TABLE `project_description` DISABLE KEYS */;
INSERT INTO `project_description` (`id`, `project_id`, `name`, `desctiption_short`, `description`) VALUES
	(67, 65, 'Проект 1', 'Создание верстки + интеграция', 'Создание верстки + интеграция'),
	(71, 69, 'FASPA', 'Сайт "под ключ" на CMS Битрикс', 'Сайт "под ключ" на CMS Битрикс'),
	(72, 70, 'ЦЗИ', 'Сайт "под ключ" на CMS Битрикс', 'Сайт "под ключ" на CMS Битрикс для компании, которая специализируется на заточке инструментов. '),
	(73, 71, 'LP Михаила Бакунина', 'Верстка и перенос на хостинг тренирга', 'Верстка и перенос на хостинг тренирга'),
	(74, 72, 'Прометей', 'Сайт на WordPress ', 'Сайт на WordPress '),
	(75, 73, 'Пироговый дворик', 'Верстка и программирование на 1С Битрикс: Малый Бизнес', 'Верстка и программирование на 1С Битрикс: Малый Бизнес'),
	(76, 74, 'PIMI', 'Верстка и программирование на 1С Битрикс: Малый бизнес', 'Верстка и программирование на 1С Битрикс: Малый бизнес'),
	(77, 75, 'Vokistore', 'Интернет-магазин на UMI.CMS', 'Интернет-магазин на UMI.CMS'),
	(78, 76, 'ТЕРЕС', 'Сайт-каталог "под ключ" на WordPress', 'Сайт-каталог "под ключ" на WordPress'),
	(79, 77, 'Reg-firm', 'Поддержка сайта на WP', 'Поддержка сайта на WP'),
	(80, 78, 'Shower Agency', 'Выполнить верстку полученных макетов', 'Выполнить верстку полученных макетов'),
	(81, 79, 'Занино', 'Верстка и программирование на 1С-Битрикс', 'Верстка и программирование на 1С-Битрикс'),
	(82, 80, 'Лендинг чехлы iPhone', 'Вёрстка лендинга:  www.t-k.bz', 'Вёрстка лендинга:  www.t-k.bz'),
	(83, 81, 'Лендинг ЖК "Городок"', 'Разработка лендинга ', 'Разработка лендинга '),
	(84, 82, 'Отель "Relax"', 'Верстка и программирование WP', 'Верстка и программирование WP'),
	(85, 83, 'BPrix', 'Доработки сайта на OpenCart', 'Доработки сайта на OpenCart'),
	(86, 84, 'Модна Дива', 'Сайт на OpenCart', 'Сайт на OpenCart'),
	(87, 85, 'Тат Подарки', 'Интернет-магазин на Simpla CMS', 'Интернет-магазин на Simpla CMS'),
	(88, 86, 'Лендинг "Melliot"', 'Выполнить верстку ', 'Выполнить верстку ');
/*!40000 ALTER TABLE `project_description` ENABLE KEYS */;


-- Дамп структуры для таблица teil_crm_dev.project_priority
DROP TABLE IF EXISTS `project_priority`;
CREATE TABLE IF NOT EXISTS `project_priority` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sort_order` int(11) NOT NULL DEFAULT '500',
  `name` varchar(255) NOT NULL DEFAULT '',
  `color` varchar(255) NOT NULL DEFAULT '',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы teil_crm_dev.project_priority: ~5 rows (приблизительно)
DELETE FROM `project_priority`;
/*!40000 ALTER TABLE `project_priority` DISABLE KEYS */;
INSERT INTO `project_priority` (`id`, `sort_order`, `name`, `color`, `created_at`, `updated_at`) VALUES
	(6, 500, 'Завершено', '#05e123', '2014-04-29 08:01:26', '2014-05-02 11:37:18'),
	(7, 500, 'Низкий', '#f1e366', '2014-04-29 08:01:46', '2014-05-02 11:36:50'),
	(8, 500, 'Нормальный', '#f3b800', '2014-04-29 08:02:03', '2014-05-02 11:36:33'),
	(9, 500, 'Высокий', '#ed2051', '2014-04-29 08:24:22', '2014-05-02 11:35:28'),
	(10, 500, 'Немедленно', '#d11241', '2014-04-29 08:33:10', '2014-05-02 11:35:40');
/*!40000 ALTER TABLE `project_priority` ENABLE KEYS */;


-- Дамп структуры для таблица teil_crm_dev.task
DROP TABLE IF EXISTS `task`;
CREATE TABLE IF NOT EXISTS `task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL DEFAULT '',
  `short_description` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`),
  CONSTRAINT `task_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы teil_crm_dev.task: ~31 rows (приблизительно)
DELETE FROM `task`;
/*!40000 ALTER TABLE `task` DISABLE KEYS */;
INSERT INTO `task` (`id`, `project_id`, `name`, `short_description`, `description`, `created_at`, `updated_at`) VALUES
	(40, 69, 'Разработка ТЗ', 'Разработать ТЗ ', 'Разработать ТЗ на основании полученной информации', '2014-05-02', '2014-05-02'),
	(42, 70, 'Разработка прототипов', 'Разработать прототипы', 'Разработать прототипы на основе полученной информации', '2014-05-02', '2014-05-02'),
	(44, 70, 'Дизайн', 'Разработать дизайн', 'Разработать дизайн', '2014-05-02', '2014-05-02'),
	(45, 71, 'Верстка', 'Верстка', 'Верстка', '2014-05-07', '2014-05-07'),
	(46, 72, 'Доработки (Прометей)', 'Сделать доработки', 'Прометей(доработки):\r\n1) Нужно дополнить главную страницу, сертификаты сделать кликабельными, чтобы всплывали документы большего размера.\r\n\r\n2) Сделать, чтобы по клику на адресе эл.почты в заголовке всплывало окно заявки\r\n\r\nПо форме заявки: \r\n1) я дополнил поля, просьба проверить корректность кода \r\n2) Убрать проверку валидности номера телефона  \r\n3) Сделать чек-боксы с новой строки', '2014-05-12', '2014-05-16'),
	(61, 73, 'Интеграция с Битрикс', 'Сделать интеграцию с Битрикс', 'Сделать интеграцию с Битрикс', '2014-05-13', '2014-05-13'),
	(67, 74, 'Доработки ', 'Сделать доработки PIMI:\r\n1) Новинки на Главной - админ формирует сам, что туда выводить.\r\n2) Доработки ссылок\r\nПисьмо на почте.\r\n', 'Сделать доработки PIMI:\r\n1) Новинки на Главной - админ формирует сам, что туда выводить.\r\n2) Доработки ссылок\r\nПисьмо на почте.', '2014-05-13', '2014-05-13'),
	(72, 75, 'Доработки', 'Сделать доработки', '1) Сделать так, чтобы у товаров с меткой «Товар в пути» не было кнопки «Добавить в корзину». П.С. Пока у товаров стоит метка «Товар в пути» их купить нельзя.\r\n2) В футере сайта ошибка в поле где надо вводить е-маил для подписки. Написано «адресс», а надо «адрес»\r\n3) Сертификаты – это должен быть альбом с картинками (сканы сертификатов, документы). На данный момент картинки не отображаются.\r\n4) Опрос – убрать возможность голосовать несколько раз если это возможно. Сейчас голосовать получается КАЖДЫЙ раз когда заходишь на сайт.', '2014-05-13', '2014-05-16'),
	(73, 76, 'Разработка прототипов', 'Разработать прототипы на основе полученной информации', 'Разработать прототипы на основе полученной информации', '2014-05-14', '2014-05-14'),
	(74, 76, 'Разработка макетов', 'Разработать макеты на основании прототипов и полученного ТЗ', 'Разработать макеты на основании прототипов и полученного ТЗ', '2014-05-14', '2014-05-14'),
	(75, 76, 'Верстка макетов', 'Сделать верстку макетов', 'Сделать верстку макетов', '2014-05-14', '2014-05-14'),
	(76, 76, 'Программирование ', 'Выполнить интеграцию верстки с WordPress', 'Выполнить интеграцию верстки с WordPress', '2014-05-14', '2014-05-14'),
	(77, 76, 'Тестирование ', 'Провести тестирование проекта', 'Провести тестирование проекта', '2014-05-14', '2014-05-14'),
	(78, 77, 'Доработки ', 'Доработки калькулятора', 'Сделать доработки калькулятора', '2014-05-16', '2014-05-16'),
	(79, 77, 'Доработки калькулятора 14_05_2014', 'Сделать доработки калькулятора', 'Сделать доработки калькулятора', '2014-05-16', '2014-05-16'),
	(80, 78, 'Верстка', 'Выполнить верстку полученных макетов', 'Выполнить верстку полученных макетов', '2014-05-16', '2014-05-16'),
	(81, 79, 'Верстка макетов', 'Выполнить верстку', 'Выполнить верстку ', '2014-05-21', '2014-05-23'),
	(82, 77, 'Исправить цены в калькуляторе ', 'http://regfirm-online.ru/test-3/ вот тут и тут http://regfirm-online.ru/yuridicheskie-uslugi/registratsiya-yuridicheskih-lits/\r\nТолько подготовка документов\r\n(2500 р.) - делаем 3000\r\nНесколько учередителей\r\n(+500 р.) - делаем 1000\r\nавтомат (+500 р.) - дел', 'http://regfirm-online.ru/test-3/ вот тут и тут http://regfirm-online.ru/yuridicheskie-uslugi/registratsiya-yuridicheskih-lits/\r\nТолько подготовка документов\r\n(2500 р.) - делаем 3000\r\nНесколько учередителей\r\n(+500 р.) - делаем 1000\r\nавтомат (+500 р.) - делаем 800\r\nи вот тут http://regfirm-online.ru/yuridicheskie-uslugi/registratsiya-individualnyih-predprinimateley/ и тут http://regfirm-online.ru/registratsiya-ip/ меняем печать-автомат(+500р.) - делаем 800\r\n', '2014-05-22', '2014-05-22'),
	(83, 80, 'Выполнить верстку ', 'Сделать вёрстку лендинга:  www.t-k.bz', 'Сделать вёрстку лендинга:  www.t-k.bz\r\nТЗ и макеты доступны по ссылке http://yadi.sk/d/tty-JHSpQz3fr\r\nЗадача в редмайн http://rm.xmarkup.ru/issues/3738', '2014-05-22', '2014-05-22'),
	(84, 81, 'Адаптивная верстка', 'Сейчас он выглядит вот так:\r\ngorodok39.ru/\r\n\r\nА будет выглядеть вот так\r\ni.imgur.com/8CgbTfN.png\r\n\r\n\r\n', 'Что нужно добавить или изменить к тому, что уже есть?\r\n\r\n0. Сделать вёрстку адаптивной под планшеты.\r\n\r\n1. Слайдер на первом экране\r\nЗдесь будет 2-3 картинки и смена текста.\r\n- Картинки должны листаться сами с паузой в 5 секунд, но при пролистывании вручную автолисталка должна отключаться.\r\n- Листалка должна работать на планшетах тоже\r\n\r\n2. Блок «Преимущества»\r\nПри наведении на блок он раскрывается и появляется дополнительная информация.\r\nДля планшетов надо сделать раскрытие по клику.\r\n\r\n3. Генплан\r\nГенплан слегка поменялся, поэтому его нужно будет переработать.\r\nЗдесь нужен скрипт.\r\n- Раскрашиваем блоки в 3 варианта – «Куплен», «Забронирован», «Свободен».\r\n- По клику показываем всплывашку с планировкой, ценой и вкладками «Забронировать/Записаться на показ».\r\nЕсли дом уже куплен или забронирован, то вкладки не показываем. По умолчанию вкладки неактивны. По клику форма появляется поверх картинки.\r\nВ каждой всплывашке контент будет отличаться: текстовая инфа, статус дома (куплен/забронирова/свободен), картинка планировки.\r\nНа почту в этом случае отправляем письмо с выбранным домом.\r\n\r\n4. Скрипты всплывашек.\r\nСкрипт всплывашки бажит в гуглехроме – зачастую не появляется фоновое затемнение.\r\nПоэтому надо подключить другой скрипт\r\n\r\n5. Скрипт галереи фотографий\r\nАдаптировать переключение фотографий под планшеты.\r\n\r\nЗадача в редмайн http://rm.xmarkup.ru/issues/3720', '2014-05-22', '2014-05-22'),
	(85, 82, 'Верстка ', 'Выполнить верстку ', 'Выполнить верстку, макеты и ТЗ доступны по ссылке http://yadi.sk/d/NRaT1sBYR68Zv', '2014-05-23', '2014-05-23'),
	(86, 82, 'Программирование ', 'Разработать шаблон под WP', 'Разработать шаблон под WP', '2014-05-23', '2014-05-23'),
	(87, 83, 'Разработка прототипов ', 'Задача в редмайн http://rm.xmarkup.ru/issues/3761', 'Задача в редмайн http://rm.xmarkup.ru/issues/3761', '2014-05-23', '2014-05-23'),
	(88, 83, 'Разработка дизайна', 'Разработка дизайна http://rm.xmarkup.ru/issues/3762', 'Разработка дизайна http://rm.xmarkup.ru/issues/3762', '2014-05-23', '2014-05-23'),
	(89, 83, 'Верстка макетов ', 'Сделать верстку макетов, задача в редмайн http://rm.xmarkup.ru/issues/3763', 'Сделать верстку макетов, задача в редмайн http://rm.xmarkup.ru/issues/3763', '2014-05-23', '2014-05-23'),
	(90, 72, 'Доработки Главной ', 'Сделать доработки Главной', 'Сделать доработки Главной', '2014-05-23', '2014-05-23'),
	(91, 83, 'Программирование', 'Разработать фильтр по разделу Двери', 'Разработать фильтр по разделу Двери', '2014-05-23', '2014-05-23'),
	(92, 84, 'Верстка', 'Сделать верстку макетов', 'Сделать верстку макетов', '2014-05-26', '2014-05-27'),
	(93, 84, 'Программирование ', 'Разработать шаблон под OC', 'Разработать шаблон под OC', '2014-05-27', '2014-05-27'),
	(94, 85, 'Сделать доработки', 'Сделать доработки, задача редмайн http://rm.xmarkup.ru/issues/3798', 'Сделать доработки, задача редмайн http://rm.xmarkup.ru/issues/3798', '2014-05-28', '2014-05-28'),
	(95, 86, 'Верстка целевой страницы "Melliot"', 'Ссылка на макет https://www.dropbox.com/s/maltkhf1rbi3k37/landingmaket.psd\r\nДополнения к макету https://www.dropbox.com/sh/a9m8nse69pea4bv/AADc_4ynzkacJAHpuucueKFGa', 'Ссылка на макет https://www.dropbox.com/s/maltkhf1rbi3k37/landingmaket.psd\r\nДополнения к макету https://www.dropbox.com/sh/a9m8nse69pea4bv/AADc_4ynzkacJAHpuucueKFGa', '2014-05-28', '2014-05-28');
/*!40000 ALTER TABLE `task` ENABLE KEYS */;


-- Дамп структуры для таблица teil_crm_dev.transaction
DROP TABLE IF EXISTS `transaction`;
CREATE TABLE IF NOT EXISTS `transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_to_money_account_id` int(11) NOT NULL,
  `transaction_object_type` varchar(100) NOT NULL DEFAULT '',
  `transaction_object_id` int(11) NOT NULL,
  `updated_at` date NOT NULL,
  `created_at` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_transaction_money_account` (`transaction_to_money_account_id`),
  CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`transaction_to_money_account_id`) REFERENCES `money_account` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы teil_crm_dev.transaction: ~24 rows (приблизительно)
DELETE FROM `transaction`;
/*!40000 ALTER TABLE `transaction` DISABLE KEYS */;
INSERT INTO `transaction` (`id`, `transaction_to_money_account_id`, `transaction_object_type`, `transaction_object_id`, `updated_at`, `created_at`) VALUES
	(49, 13, 'none', 0, '2014-04-29', '2014-03-30'),
	(55, 12, 'project', 69, '2014-05-02', '2014-05-02'),
	(56, 12, 'project', 71, '2014-05-07', '2014-05-07'),
	(59, 12, 'project', 73, '2014-05-13', '2014-05-13'),
	(60, 12, 'project', 73, '2014-05-13', '2014-05-13'),
	(61, 12, 'project', 76, '2014-05-14', '2014-05-14'),
	(64, 12, 'project', 72, '2014-05-16', '2014-05-16'),
	(65, 12, 'project', 77, '2014-05-16', '2014-05-16'),
	(66, 12, 'project', 77, '2014-05-16', '2014-05-16'),
	(67, 12, 'project', 78, '2014-05-16', '2014-05-16'),
	(68, 18, 'project', 75, '2014-05-16', '2014-05-16'),
	(69, 19, 'project', 79, '2014-05-21', '2014-05-21'),
	(70, 13, 'project', 77, '2014-05-22', '2014-05-22'),
	(71, 13, 'project', 74, '2014-05-22', '2014-05-22'),
	(73, 19, 'project', 80, '2014-05-22', '2014-05-22'),
	(74, 19, 'project', 74, '2014-05-23', '2014-05-23'),
	(76, 19, 'project', 82, '2014-05-23', '2014-05-23'),
	(77, 19, 'project', 83, '2014-05-23', '2014-05-23'),
	(78, 13, 'project', 72, '2014-05-23', '2014-05-23'),
	(79, 19, 'project', 79, '2014-05-23', '2014-05-23'),
	(80, 13, 'project', 73, '2014-05-26', '2014-05-26'),
	(81, 20, 'project', 84, '2014-05-27', '2014-05-27'),
	(82, 13, 'project', 85, '2014-05-28', '2014-05-28'),
	(83, 19, 'project', 86, '2014-05-28', '2014-05-28');
/*!40000 ALTER TABLE `transaction` ENABLE KEYS */;


-- Дамп структуры для таблица teil_crm_dev.transaction_description
DROP TABLE IF EXISTS `transaction_description`;
CREATE TABLE IF NOT EXISTS `transaction_description` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_id` int(11) NOT NULL,
  `transaction_purpose_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `is_expense` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `transaction_id` (`transaction_id`),
  KEY `transaction_purpose_id` (`transaction_purpose_id`),
  CONSTRAINT `transaction_description_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `transaction` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `transaction_description_ibfk_2` FOREIGN KEY (`transaction_purpose_id`) REFERENCES `transaction_purpose` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы teil_crm_dev.transaction_description: ~24 rows (приблизительно)
DELETE FROM `transaction_description`;
/*!40000 ALTER TABLE `transaction_description` DISABLE KEYS */;
INSERT INTO `transaction_description` (`id`, `transaction_id`, `transaction_purpose_id`, `name`, `value`, `is_expense`, `created_at`, `updated_at`) VALUES
	(49, 49, 3, 'оплата', '1000', 0, '2014-04-29 13:34:24', '2014-04-29 13:34:24'),
	(55, 55, 4, 'Предоплата за ТЗ и прототипы', '7500', 0, '2014-05-02 12:10:24', '2014-05-02 12:10:24'),
	(56, 56, 8, 'Оплата верстки LP', '1827', 0, '2014-05-07 15:45:06', '2014-05-07 15:45:06'),
	(59, 59, 4, 'Предоплата за программирование 25%', '10000', 0, '2014-05-13 09:57:19', '2014-05-13 09:57:19'),
	(60, 60, 4, 'Предоплата за программирование 25%', '10000', 0, '2014-05-13 15:04:13', '2014-05-13 15:04:13'),
	(61, 61, 4, 'Предоплата за прототипы', '5000', 0, '2014-05-14 08:37:22', '2014-05-14 08:37:22'),
	(64, 64, 8, 'Оплата за доработки', '1400', 0, '2014-05-16 15:04:44', '2014-05-16 15:04:44'),
	(65, 65, 8, 'Доработки калькулятора', '400', 0, '2014-05-16 15:05:56', '2014-05-16 15:05:56'),
	(66, 66, 8, 'Доработки калькулятора', '400', 0, '2014-05-16 15:09:06', '2014-05-16 15:09:06'),
	(67, 67, 8, 'Оплата за верстку', '4000', 0, '2014-05-16 15:10:41', '2014-05-16 15:10:41'),
	(68, 68, 8, 'Оплата за доработки', '1200', 0, '2014-05-16 15:24:15', '2014-05-16 15:24:15'),
	(69, 69, 4, 'Прдеоплата за верстку Главной', '626', 0, '2014-05-21 09:08:23', '2014-05-21 09:08:23'),
	(70, 70, 8, 'Правки цен', '300', 0, '2014-05-22 11:01:30', '2014-05-22 11:01:30'),
	(71, 71, 8, 'Оплата за доработки', '7000', 0, '2014-05-22 11:15:08', '2014-05-22 11:15:08'),
	(73, 73, 4, 'Предоплата за верстку', '645', 0, '2014-05-22 11:55:31', '2014-05-22 11:55:31'),
	(74, 74, 8, 'Оплата за доработки', '968', 0, '2014-05-23 08:06:53', '2014-05-23 08:06:53'),
	(76, 76, 4, 'Предоплата', '1613', 0, '2014-05-23 10:45:57', '2014-05-23 10:45:57'),
	(77, 77, 4, 'Предоплата за прототипы', '1613', 0, '2014-05-23 12:24:56', '2014-05-23 12:24:56'),
	(78, 78, 8, 'Оплата за доработки', '350', 0, '2014-05-23 12:34:32', '2014-05-23 12:34:32'),
	(79, 79, 8, 'Часть оплаты за верстку', '939', 0, '2014-05-23 13:36:57', '2014-05-23 13:36:57'),
	(80, 80, 8, 'Оплата за проект', '9800', 0, '2014-05-26 09:58:31', '2014-05-26 09:58:31'),
	(81, 81, 8, 'Оплата за верстку + предоплата за программирование 50%', '8000', 0, '2014-05-27 12:12:26', '2014-05-27 12:12:26'),
	(82, 82, 4, 'Предоплата за доработки 50%', '2000', 0, '2014-05-28 12:12:47', '2014-05-28 12:12:47'),
	(83, 83, 4, 'Предоплата 50%', '782', 0, '2014-05-28 13:28:27', '2014-05-28 13:28:27');
/*!40000 ALTER TABLE `transaction_description` ENABLE KEYS */;


-- Дамп структуры для таблица teil_crm_dev.transaction_purpose
DROP TABLE IF EXISTS `transaction_purpose`;
CREATE TABLE IF NOT EXISTS `transaction_purpose` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы teil_crm_dev.transaction_purpose: ~4 rows (приблизительно)
DELETE FROM `transaction_purpose`;
/*!40000 ALTER TABLE `transaction_purpose` DISABLE KEYS */;
INSERT INTO `transaction_purpose` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(3, 'Зарплата', '2014-04-29 08:05:55', '2014-04-29 08:40:11'),
	(4, 'Предоплата', '2014-04-29 08:39:37', '2014-05-02 11:39:59'),
	(6, 'Аренда', '2014-04-29 08:45:00', '2014-05-02 11:40:26'),
	(8, 'Поступление', '2014-05-02 11:41:09', '2014-05-02 11:41:09');
/*!40000 ALTER TABLE `transaction_purpose` ENABLE KEYS */;


-- Дамп структуры для таблица teil_crm_dev.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `perm` int(11) NOT NULL DEFAULT '500',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Дамп данных таблицы teil_crm_dev.users: ~11 rows (приблизительно)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `email`, `perm`, `created_at`, `updated_at`) VALUES
	(5, 'yuriikrevnyi@gmail.com', 5000, '0000-00-00 00:00:00', '2014-03-07 22:00:47'),
	(6, 'djomaxxx@mail.ru', 5000, '0000-00-00 00:00:00', '2014-04-29 07:50:55'),
	(7, 'r.shkabko@teil.com.ua', 500, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(8, 'm.polazhynets@teil.com.ua', 500, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(9, 'v.marmooliak@gmail.com', 500, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(10, 'pada2sh@mail.ru', 500, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(11, 'o.ruzhytskyy@teil.com.ua', 500, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(12, 'andrew9965@gmail.com', 500, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(13, 'andriy.mbilyak@gmail.com', 500, '0000-00-00 00:00:00', '2014-05-29 13:29:14'),
	(14, 'kostya_lebedynskiy@ukr.net', 500, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(15, 'mylogin222@gmail.com', 500, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;


-- Дамп структуры для таблица teil_crm_dev.user_role
DROP TABLE IF EXISTS `user_role`;
CREATE TABLE IF NOT EXISTS `user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `percents` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы teil_crm_dev.user_role: ~13 rows (приблизительно)
DELETE FROM `user_role`;
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;
INSERT INTO `user_role` (`id`, `name`, `percents`, `created_at`, `updated_at`) VALUES
	(14, 'Менеджер', 1, '2014-04-29 07:53:55', '2014-05-02 11:51:48'),
	(25, 'Team Lead', 1, '2014-05-02 12:14:15', '2014-05-02 12:14:15'),
	(26, 'Верстальщик (Dev)', 0, '2014-05-02 12:14:27', '2014-05-02 12:14:27'),
	(27, 'Верстальщик (Sen)', 0, '2014-05-02 12:14:39', '2014-05-02 12:14:39'),
	(28, 'Open Source (Dev)', 0, '2014-05-02 12:15:36', '2014-05-02 12:15:36'),
	(29, 'Open Source (Sen)', 0, '2014-05-02 12:16:03', '2014-05-02 12:16:03'),
	(30, 'Коробка (Dev)', 0, '2014-05-02 12:17:32', '2014-05-02 12:17:32'),
	(31, 'Коробка (Sen)', 0, '2014-05-02 12:18:34', '2014-05-02 12:18:34'),
	(32, 'Дизайнер (Dev) ', 0, '2014-05-02 12:19:17', '2014-05-02 12:19:17'),
	(33, 'Дизайнер (Sen) ', 0, '2014-05-02 12:19:45', '2014-05-02 12:19:45'),
	(34, 'Тестер', 0, '2014-05-02 12:20:42', '2014-05-02 12:20:42'),
	(35, 'Проектировщик', 0, '2014-05-02 12:22:48', '2014-05-02 12:22:48'),
	(36, 'Копирайтер', 0, '2014-05-02 12:23:24', '2014-05-02 12:23:24');
/*!40000 ALTER TABLE `user_role` ENABLE KEYS */;


-- Дамп структуры для таблица teil_crm_dev.user_role_price
DROP TABLE IF EXISTS `user_role_price`;
CREATE TABLE IF NOT EXISTS `user_role_price` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_role_id` int(11) NOT NULL,
  `price_per_hour` varchar(50) NOT NULL DEFAULT '',
  `price_per_hour_payable` varchar(50) NOT NULL DEFAULT '',
  `created_at` date NOT NULL,
  `deprecated_at` date DEFAULT '2099-01-01',
  PRIMARY KEY (`id`),
  KEY `user_role_id` (`user_role_id`),
  CONSTRAINT `user_role_price_ibfk_1` FOREIGN KEY (`user_role_id`) REFERENCES `user_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы teil_crm_dev.user_role_price: ~18 rows (приблизительно)
DELETE FROM `user_role_price`;
/*!40000 ALTER TABLE `user_role_price` DISABLE KEYS */;
INSERT INTO `user_role_price` (`id`, `user_role_id`, `price_per_hour`, `price_per_hour_payable`, `created_at`, `deprecated_at`) VALUES
	(36, 14, '50', '35', '2014-01-04', '2014-04-29'),
	(47, 14, '40', '30', '2014-03-01', '2014-03-15'),
	(48, 14, '40', '30', '2014-03-15', '2014-03-25'),
	(49, 14, '14', '7', '2014-03-25', '2014-04-20'),
	(50, 14, '72', '50', '2014-04-20', '2014-05-02'),
	(51, 14, '5', '5', '2014-05-02', '2099-01-01'),
	(57, 25, '5', '5', '2014-05-02', '2099-01-01'),
	(58, 26, '183', '58', '2014-05-02', '2099-01-01'),
	(59, 27, '261', '83', '2014-05-02', '2099-01-01'),
	(60, 28, '221', '70', '2014-05-02', '2099-01-01'),
	(61, 29, '315', '100', '2014-05-02', '2099-01-01'),
	(62, 30, '299', '95', '2014-05-02', '2099-01-01'),
	(63, 31, '360', '112', '2014-05-02', '2099-01-01'),
	(64, 32, '252', '80', '2014-05-02', '2099-01-01'),
	(65, 33, '360', '112', '2014-05-02', '2099-01-01'),
	(66, 34, '183', '58', '2014-05-02', '2099-01-01'),
	(67, 35, '299', '95', '2014-05-02', '2099-01-01'),
	(68, 36, '221', '70', '2014-05-02', '2099-01-01');
/*!40000 ALTER TABLE `user_role_price` ENABLE KEYS */;


-- Дамп структуры для таблица teil_crm_dev.user_to_task
DROP TABLE IF EXISTS `user_to_task`;
CREATE TABLE IF NOT EXISTS `user_to_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_role_id` int(11) NOT NULL,
  `payed_hours` float NOT NULL,
  PRIMARY KEY (`id`),
  KEY `task_id` (`task_id`),
  KEY `user_id` (`user_id`),
  KEY `user_role_id` (`user_role_id`),
  CONSTRAINT `user_to_task_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_to_task_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_to_task_ibfk_3` FOREIGN KEY (`user_role_id`) REFERENCES `user_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=143 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы teil_crm_dev.user_to_task: ~65 rows (приблизительно)
DELETE FROM `user_to_task`;
/*!40000 ALTER TABLE `user_to_task` DISABLE KEYS */;
INSERT INTO `user_to_task` (`id`, `task_id`, `user_id`, `user_role_id`, `payed_hours`) VALUES
	(75, 40, 8, 14, 0),
	(77, 40, 8, 35, 4),
	(78, 42, 9, 32, 5),
	(79, 42, 8, 14, 0),
	(80, 44, 9, 32, 28),
	(81, 44, 8, 14, 0),
	(82, 45, 10, 27, 7),
	(83, 46, 11, 28, 2),
	(84, 61, 5, 14, 0),
	(85, 61, 8, 14, 0),
	(86, 61, 6, 30, 2),
	(87, 61, 5, 31, 33.9),
	(88, 67, 5, 31, 8.5),
	(89, 67, 8, 14, 0),
	(91, 72, 8, 14, 0),
	(92, 73, 9, 32, 10),
	(93, 73, 8, 14, 0),
	(94, 74, 8, 14, 0),
	(95, 74, 9, 32, 21),
	(96, 75, 11, 26, 17),
	(97, 75, 8, 14, 0),
	(98, 76, 8, 14, 0),
	(99, 76, 11, 28, 35),
	(100, 77, 8, 14, 0),
	(101, 77, 13, 34, 10),
	(102, 78, 11, 28, 0.55),
	(103, 78, 8, 14, 0),
	(104, 46, 8, 14, 0),
	(105, 79, 8, 14, 0),
	(106, 79, 11, 28, 0.55),
	(107, 80, 8, 14, 0),
	(108, 80, 11, 26, 6.8),
	(109, 72, 12, 30, 1),
	(110, 81, 11, 26, 18),
	(111, 81, 8, 14, 0),
	(112, 82, 11, 26, 0.5),
	(113, 82, 8, 14, 0),
	(114, 83, 14, 26, 6.79),
	(115, 83, 8, 14, 0),
	(116, 84, 8, 14, 0),
	(117, 84, 6, 26, 8.48),
	(119, 85, 8, 14, 0),
	(120, 85, 14, 26, 6),
	(121, 86, 8, 14, 0),
	(122, 86, 11, 28, 9.8),
	(123, 87, 8, 14, 0),
	(124, 87, 9, 32, 0),
	(125, 88, 8, 14, 0),
	(126, 88, 9, 32, 0),
	(127, 89, 10, 26, 0),
	(128, 89, 8, 14, 0),
	(129, 90, 8, 14, 0),
	(130, 90, 11, 26, 0.6),
	(131, 91, 8, 14, 0),
	(132, 91, 10, 28, 0),
	(133, 92, 5, 25, 0),
	(134, 92, 8, 14, 0),
	(135, 92, 15, 26, 28),
	(136, 93, 8, 14, 0),
	(137, 93, 5, 29, 28),
	(138, 93, 15, 28, 11),
	(139, 94, 8, 14, 0),
	(140, 94, 10, 30, 4),
	(141, 95, 8, 14, 0),
	(142, 95, 10, 26, 8.5);
/*!40000 ALTER TABLE `user_to_task` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
