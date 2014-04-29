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
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf16;

-- Дамп данных таблицы teil_crm_dev.money_account: ~5 rows (приблизительно)
DELETE FROM `money_account`;
/*!40000 ALTER TABLE `money_account` DISABLE KEYS */;
INSERT INTO `money_account` (`id`, `name`, `icon`, `created_at`, `updated_at`) VALUES
	(12, 'Счетвприватбанке_1213123123открыт_Счетвприватбанке_1213123123открыт', '', '2014-04-29 08:07:48', '2014-04-29 10:31:05'),
	(13, 'Счет_2', '', '2014-04-29 08:07:59', '2014-04-29 08:07:59'),
	(14, 'Счет_2', '', '2014-04-29 08:08:09', '2014-04-29 08:08:09'),
	(15, 'Счет_3', '', '2014-04-29 08:08:38', '2014-04-29 08:08:38'),
	(16, 'Счет_4', '', '2014-04-29 08:08:46', '2014-04-29 08:08:46');
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
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы teil_crm_dev.project: ~4 rows (приблизительно)
DELETE FROM `project`;
/*!40000 ALTER TABLE `project` DISABLE KEYS */;
INSERT INTO `project` (`id`, `status`, `project_priority_id`, `done_percents`, `actual_hours`, `end_date`, `created_at`, `updated_at`) VALUES
	(65, 0, 6, 10, '', '2014-04-28', '2014-03-30', '2014-04-29'),
	(66, 0, 6, 0, '', '2014-05-03', '2014-04-20', '2014-04-29'),
	(67, 0, 7, 0, '', '2014-05-30', '2014-04-20', '2014-04-29'),
	(68, 0, 8, 0, '', '2014-04-30', '2014-04-20', '2014-04-29');
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
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы teil_crm_dev.project_description: ~4 rows (приблизительно)
DELETE FROM `project_description`;
/*!40000 ALTER TABLE `project_description` DISABLE KEYS */;
INSERT INTO `project_description` (`id`, `project_id`, `name`, `desctiption_short`, `description`) VALUES
	(67, 65, 'Проект 1', 'Создание верстки + интеграция', 'Создание верстки + интеграция'),
	(68, 66, 'Проект 2', 'Создание верстки + интеграция', 'Создание верстки + интеграция'),
	(69, 67, 'Проект 3', 'Создание верстки + интеграция', 'Создание верстки + интеграция'),
	(70, 68, 'Проект 1', 'Проект 1', 'Проект 1');
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
	(6, 500, '2', '#09b275', '2014-04-29 08:01:26', '2014-04-29 11:44:26'),
	(7, 500, '3', '#d3c549', '2014-04-29 08:01:46', '2014-04-29 08:01:46'),
	(8, 500, '4', '#29c143', '2014-04-29 08:02:03', '2014-04-29 08:02:36'),
	(9, 500, '1', '#ed2051', '2014-04-29 08:24:22', '2014-04-29 08:24:45'),
	(10, 500, '1', '#d11341', '2014-04-29 08:33:10', '2014-04-29 11:44:18');
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
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы teil_crm_dev.task: ~5 rows (приблизительно)
DELETE FROM `task`;
/*!40000 ALTER TABLE `task` DISABLE KEYS */;
INSERT INTO `task` (`id`, `project_id`, `name`, `short_description`, `description`, `created_at`, `updated_at`) VALUES
	(27, 67, 'Сделать верстку', 'Сделать верстку 5 макетов', 'Сделать верстку 5 макетов', '2014-04-28', '2014-04-28'),
	(29, 67, 'интеграция', 'интеграция с битрикс', 'интеграция с битрикс', '2014-04-28', '2014-04-28'),
	(33, 68, 'Задание 1', 'Задание 1', 'Задание 1', '2014-04-28', '2014-04-29'),
	(34, 66, 'Задача 2', 'Задача 2', 'Задача 2', '2014-04-28', '2014-04-29'),
	(37, 68, 'фывафыва', 'фывафыва', 'фывафыва', '2014-04-29', '2014-04-29');
/*!40000 ALTER TABLE `task` ENABLE KEYS */;


-- Дамп структуры для таблица teil_crm_dev.transaction
DROP TABLE IF EXISTS `transaction`;
CREATE TABLE IF NOT EXISTS `transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_to_money_account_id` int(11) NOT NULL,
  `transaction_object_type` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `transaction_object_id` int(11) NOT NULL,
  `updated_at` date NOT NULL,
  `created_at` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_transaction_money_account` (`transaction_to_money_account_id`),
  CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`transaction_to_money_account_id`) REFERENCES `money_account` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf16;

-- Дамп данных таблицы teil_crm_dev.transaction: ~4 rows (приблизительно)
DELETE FROM `transaction`;
/*!40000 ALTER TABLE `transaction` DISABLE KEYS */;
INSERT INTO `transaction` (`id`, `transaction_to_money_account_id`, `transaction_object_type`, `transaction_object_id`, `updated_at`, `created_at`) VALUES
	(49, 13, 'none', 0, '2014-04-29', '2014-03-30'),
	(50, 12, 'none', 0, '2014-04-29', '2014-04-29'),
	(51, 13, 'none', 0, '2014-04-29', '2014-04-29'),
	(54, 13, 'project', 68, '2014-04-29', '2014-04-29');
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
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf16;

-- Дамп данных таблицы teil_crm_dev.transaction_description: ~4 rows (приблизительно)
DELETE FROM `transaction_description`;
/*!40000 ALTER TABLE `transaction_description` DISABLE KEYS */;
INSERT INTO `transaction_description` (`id`, `transaction_id`, `transaction_purpose_id`, `name`, `value`, `is_expense`, `created_at`, `updated_at`) VALUES
	(49, 49, 3, 'оплата', '1000', 0, '2014-04-29 13:34:24', '2014-04-29 13:34:24'),
	(50, 50, 3, 'Новая ', '1000', 0, '2014-04-29 13:37:40', '2014-04-29 13:37:40'),
	(51, 51, 3, 'Новая 1', '1000', 1, '2014-04-29 13:37:55', '2014-04-29 13:37:55'),
	(54, 54, 6, 'оплата', '1234', 0, '2014-04-29 15:27:55', '2014-04-29 15:27:55');
/*!40000 ALTER TABLE `transaction_description` ENABLE KEYS */;


-- Дамп структуры для таблица teil_crm_dev.transaction_purpose
DROP TABLE IF EXISTS `transaction_purpose`;
CREATE TABLE IF NOT EXISTS `transaction_purpose` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы teil_crm_dev.transaction_purpose: ~4 rows (приблизительно)
DELETE FROM `transaction_purpose`;
/*!40000 ALTER TABLE `transaction_purpose` DISABLE KEYS */;
INSERT INTO `transaction_purpose` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(3, 'Зарплата', '2014-04-29 08:05:55', '2014-04-29 08:40:11'),
	(4, 'Предоплатаповерсткезапервыйкварталгодатридцатьпроцентовстоимостипроекта', '2014-04-29 08:39:37', '2014-04-29 10:37:07'),
	(5, 'Зарплата', '2014-04-29 08:42:47', '2014-04-29 08:42:47'),
	(6, 'Аванс', '2014-04-29 08:45:00', '2014-04-29 08:45:00');
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Дамп данных таблицы teil_crm_dev.users: ~2 rows (приблизительно)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `email`, `perm`, `created_at`, `updated_at`) VALUES
	(5, 'yuriikrevnyi@gmail.com', 5000, '0000-00-00 00:00:00', '2014-03-07 22:00:47'),
	(6, 'djomaxxx@mail.ru', 5000, '0000-00-00 00:00:00', '2014-04-29 07:50:55');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;


-- Дамп структуры для таблица teil_crm_dev.user_role
DROP TABLE IF EXISTS `user_role`;
CREATE TABLE IF NOT EXISTS `user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf16 NOT NULL,
  `percents` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы teil_crm_dev.user_role: ~6 rows (приблизительно)
DELETE FROM `user_role`;
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;
INSERT INTO `user_role` (`id`, `name`, `percents`, `created_at`, `updated_at`) VALUES
	(14, 'Designer', 0, '2014-04-29 07:53:55', '2014-04-29 07:53:55'),
	(17, 'DeveloperSenior', 0, '2014-04-29 07:56:37', '2014-04-29 07:56:37'),
	(18, 'DeveloperSenior1', 0, '2014-04-29 07:57:23', '2014-04-29 07:57:23'),
	(19, 'DeveloperSenior2', 0, '2014-04-29 07:58:16', '2014-04-29 07:58:16'),
	(20, 'TeamL', 1, '2014-04-29 07:58:53', '2014-04-29 07:58:53'),
	(24, 'PM1', 1, '2014-04-29 08:22:09', '2014-04-29 08:22:09');
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
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы teil_crm_dev.user_role_price: ~8 rows (приблизительно)
DELETE FROM `user_role_price`;
/*!40000 ALTER TABLE `user_role_price` DISABLE KEYS */;
INSERT INTO `user_role_price` (`id`, `user_role_id`, `price_per_hour`, `price_per_hour_payable`, `created_at`, `deprecated_at`) VALUES
	(36, 14, '50', '35', '2014-01-04', '2014-04-29'),
	(37, 17, '50', '40', '2014-01-04', '2099-01-01'),
	(38, 18, '20', '40', '2014-01-04', '2099-01-01'),
	(39, 19, '50', '40', '2014-01-04', '2099-01-01'),
	(40, 20, '5', '5', '2014-01-04', '2099-01-01'),
	(41, 24, '50', '30', '2014-01-04', '2099-01-01'),
	(47, 14, '40', '30', '2014-04-29', '2014-04-29'),
	(48, 14, '40', '30', '2014-04-29', '2099-01-01');
/*!40000 ALTER TABLE `user_role_price` ENABLE KEYS */;


-- Дамп структуры для таблица teil_crm_dev.user_to_task
DROP TABLE IF EXISTS `user_to_task`;
CREATE TABLE IF NOT EXISTS `user_to_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_role_id` int(11) NOT NULL,
  `payed_hours` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `task_id` (`task_id`),
  KEY `user_id` (`user_id`),
  KEY `user_role_id` (`user_role_id`),
  CONSTRAINT `user_to_task_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_to_task_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_to_task_ibfk_3` FOREIGN KEY (`user_role_id`) REFERENCES `user_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы teil_crm_dev.user_to_task: ~11 rows (приблизительно)
DELETE FROM `user_to_task`;
/*!40000 ALTER TABLE `user_to_task` DISABLE KEYS */;
INSERT INTO `user_to_task` (`id`, `task_id`, `user_id`, `user_role_id`, `payed_hours`) VALUES
	(44, 29, 5, 14, 1),
	(49, 27, 5, 14, 10),
	(50, 29, 5, 17, 2),
	(51, 27, 6, 14, 10),
	(52, 33, 5, 14, 10),
	(57, 34, 5, 19, 10),
	(64, 33, 6, 20, 0),
	(65, 34, 5, 20, 0),
	(66, 37, 6, 14, 1),
	(67, 33, 6, 24, 0),
	(68, 34, 6, 20, 0);
/*!40000 ALTER TABLE `user_to_task` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
