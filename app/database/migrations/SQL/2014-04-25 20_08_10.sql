-- --------------------------------------------------------
-- Сервер:                       127.0.0.1
-- Версія сервера:               5.5.32 - MySQL Community Server (GPL)
-- ОС сервера:                   Win32
-- HeidiSQL Версія:              8.3.0.4694
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for таблиця teil_crm_dev.migrations
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table teil_crm_dev.migrations: ~3 rows (приблизно)
DELETE FROM `migrations`;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`migration`, `batch`) VALUES
	('2013_09_08_182322_create_users_table', 1),
	('2013_09_08_184042_create_users_group_table', 1),
	('2013_09_09_065654_add_email_field_to_users_table', 1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;


-- Dumping structure for таблиця teil_crm_dev.money_account
DROP TABLE IF EXISTS `money_account`;
CREATE TABLE IF NOT EXISTS `money_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `balance` varchar(255) NOT NULL DEFAULT '0',
  `icon` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf16;

-- Dumping data for table teil_crm_dev.money_account: ~6 rows (приблизно)
DELETE FROM `money_account`;
/*!40000 ALTER TABLE `money_account` DISABLE KEYS */;
INSERT INTO `money_account` (`id`, `name`, `balance`, `icon`) VALUES
	(1, 'Наличные', '0', ''),
	(2, 'Я.Деньги', '0', ''),
	(3, 'Банк. карта', '0', ''),
	(4, 'WMR', '0', ''),
	(5, 'WMU', '0', ''),
	(6, 'WMZ', '0', '');
/*!40000 ALTER TABLE `money_account` ENABLE KEYS */;


-- Dumping structure for таблиця teil_crm_dev.project
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
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8;

-- Dumping data for table teil_crm_dev.project: ~6 rows (приблизно)
DELETE FROM `project`;
/*!40000 ALTER TABLE `project` DISABLE KEYS */;
INSERT INTO `project` (`id`, `status`, `project_priority_id`, `done_percents`, `actual_hours`, `end_date`, `created_at`, `updated_at`) VALUES
	(48, 0, 1, 10, '0', '2014-04-30', '2014-04-15', '2014-04-25'),
	(49, 0, 3, 15, '', '2014-04-30', '2014-04-25', '2014-04-25'),
	(50, 0, 1, 15, '', '2014-04-30', '2014-04-25', '2014-04-25'),
	(51, 0, 1, 15, '', '2014-04-30', '2014-04-25', '2014-04-25'),
	(52, 0, 1, 15, '', '2014-04-30', '2014-04-25', '2014-04-25'),
	(53, 0, 1, 10, '1', '2014-04-10', '2014-04-25', '2014-04-25');
/*!40000 ALTER TABLE `project` ENABLE KEYS */;


-- Dumping structure for таблиця teil_crm_dev.project_description
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
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;

-- Dumping data for table teil_crm_dev.project_description: ~6 rows (приблизно)
DELETE FROM `project_description`;
/*!40000 ALTER TABLE `project_description` DISABLE KEYS */;
INSERT INTO `project_description` (`id`, `project_id`, `name`, `desctiption_short`, `description`) VALUES
	(50, 48, 'Новый проект 1', 'Короткое 2', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
	(51, 49, 'Сайт под ключ РАСКРОЙ ДСП', 'Короткое описание', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
	(52, 50, 'Сайт под ключ Раскрой ДСП', 'Коротко', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
	(53, 51, 'Сайт под ключ Раскрой ДСП', 'Коротко', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
	(54, 52, 'Сайт под ключ Раскрой ДСП', 'Коротко', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
	(55, 53, 'demo proj', 'asdasd', 'asdasdasd');
/*!40000 ALTER TABLE `project_description` ENABLE KEYS */;


-- Dumping structure for таблиця teil_crm_dev.project_priority
DROP TABLE IF EXISTS `project_priority`;
CREATE TABLE IF NOT EXISTS `project_priority` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sort_order` int(11) NOT NULL DEFAULT '500',
  `name` varchar(255) NOT NULL DEFAULT '',
  `color` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Dumping data for table teil_crm_dev.project_priority: ~4 rows (приблизно)
DELETE FROM `project_priority`;
/*!40000 ALTER TABLE `project_priority` DISABLE KEYS */;
INSERT INTO `project_priority` (`id`, `sort_order`, `name`, `color`) VALUES
	(1, 500, 'red', '#f00'),
	(2, 500, 'gray', '#ccc'),
	(3, 500, 'green', '#0f0'),
	(4, 500, 'blue', '#00f');
/*!40000 ALTER TABLE `project_priority` ENABLE KEYS */;


-- Dumping structure for таблиця teil_crm_dev.task
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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- Dumping data for table teil_crm_dev.task: ~6 rows (приблизно)
DELETE FROM `task`;
/*!40000 ALTER TABLE `task` DISABLE KEYS */;
INSERT INTO `task` (`id`, `project_id`, `name`, `short_description`, `description`, `created_at`, `updated_at`) VALUES
	(12, 48, 'Old task123', 'Short2', 'Detail3', '2014-03-25', '2014-04-25'),
	(13, 48, 'Задача с новыми ценами', 'Короткое описание', 'Подробно', '2014-04-25', '2014-04-25'),
	(14, 48, 'Old task1', 'Short', 'Detail', '2014-04-25', '2014-04-25'),
	(15, 48, 'Old task1', 'Short', 'Detail', '2014-04-25', '2014-04-25'),
	(16, 48, 'test1', '1232', '1233', '2014-04-25', '2014-04-25'),
	(17, 53, 'Свертстать макет', '5614515', '58545', '2014-04-25', '2014-04-25');
/*!40000 ALTER TABLE `task` ENABLE KEYS */;


-- Dumping structure for таблиця teil_crm_dev.transaction
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
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf16;

-- Dumping data for table teil_crm_dev.transaction: ~17 rows (приблизно)
DELETE FROM `transaction`;
/*!40000 ALTER TABLE `transaction` DISABLE KEYS */;
INSERT INTO `transaction` (`id`, `transaction_to_money_account_id`, `transaction_object_type`, `transaction_object_id`, `updated_at`, `created_at`) VALUES
	(16, 1, 'none', 0, '2014-03-07', '2014-03-07'),
	(17, 2, 'none', 0, '2014-03-07', '2014-03-07'),
	(18, 3, 'user', 5, '2014-03-07', '2014-03-07'),
	(27, 1, 'none', 0, '2014-03-12', '2014-03-12'),
	(28, 1, 'none', 0, '2014-03-12', '2014-03-12'),
	(29, 1, 'none', 0, '2014-03-12', '2014-03-12'),
	(31, 6, 'project', 2, '2014-03-16', '2014-03-16'),
	(32, 1, 'project', 2, '2014-03-16', '2014-03-16'),
	(34, 3, 'user', 6, '2014-03-27', '2014-03-27'),
	(35, 3, 'project', 4, '2014-04-18', '2014-04-18'),
	(36, 2, 'project', 3, '2014-04-18', '2014-04-18'),
	(37, 1, 'project', 4, '2014-04-19', '2014-04-19'),
	(38, 6, 'project', 2, '2014-04-19', '2014-04-19'),
	(39, 2, 'project', 48, '2014-04-25', '2014-04-25'),
	(40, 1, 'project', 47, '2014-04-25', '2014-04-25'),
	(41, 1, 'project', 47, '2014-04-25', '2014-04-25'),
	(42, 1, 'none', 0, '2014-04-25', '2014-04-25');
/*!40000 ALTER TABLE `transaction` ENABLE KEYS */;


-- Dumping structure for таблиця teil_crm_dev.transaction_description
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
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf16;

-- Dumping data for table teil_crm_dev.transaction_description: ~17 rows (приблизно)
DELETE FROM `transaction_description`;
/*!40000 ALTER TABLE `transaction_description` DISABLE KEYS */;
INSERT INTO `transaction_description` (`id`, `transaction_id`, `transaction_purpose_id`, `name`, `value`, `is_expense`, `created_at`, `updated_at`) VALUES
	(16, 16, 2, 'oplata reconn', '5000', 0, '2014-03-07 22:33:37', '2014-03-07 22:33:37'),
	(17, 17, 2, 'oplata pimi yandex', '2500', 0, '2014-03-07 22:34:06', '2014-03-07 22:34:06'),
	(18, 18, 2, 'zarplata yrka', '3000', 1, '2014-03-07 22:34:45', '2014-03-07 22:34:45'),
	(27, 27, 2, 'predoplata bank', '5000', 0, '2014-03-12 21:52:58', '2014-03-12 21:52:58'),
	(28, 28, 2, 'assa', 'asas', 0, '2014-03-12 22:25:55', '2014-03-12 22:25:55'),
	(29, 29, 3, '12', '12', 0, '2014-03-12 22:26:39', '2014-03-12 22:26:39'),
	(31, 31, 3, 'test transaction to project', '15000', 0, '2014-03-16 21:31:40', '2014-03-16 21:31:40'),
	(32, 32, 2, 'asas', '5000', 0, '2014-03-16 22:21:50', '2014-03-16 22:21:50'),
	(34, 34, 2, 'test oleg', '7000', 0, '2014-03-27 21:02:50', '2014-03-27 21:02:50'),
	(35, 35, 3, 'Оплата чего либо', '200', 1, '2014-04-18 13:17:04', '2014-04-18 13:17:04'),
	(36, 36, 3, 'demo transaction to markup', '20000', 0, '2014-04-18 16:57:30', '2014-04-18 16:57:30'),
	(37, 37, 2, 'rrrrjjjhh', '1000', 1, '2014-04-19 14:48:49', '2014-04-19 14:48:49'),
	(38, 38, 2, 'jhjgtbbnnkjkjjk', '750', 1, '2014-04-19 14:49:21', '2014-04-19 14:49:21'),
	(39, 39, 3, 'Предоплата по верстке', '20', 0, '2014-04-25 10:50:40', '2014-04-25 10:50:40'),
	(40, 40, 2, 'asdasdasdasd', '123123', 0, '2014-04-25 13:04:43', '2014-04-25 13:04:43'),
	(41, 41, 2, 'easdasdasdasdas111', '11111', 0, '2014-04-25 13:08:05', '2014-04-25 13:08:05'),
	(42, 42, 2, 'asdasdasdasd777', '777', 0, '2014-04-25 13:13:45', '2014-04-25 13:13:45');
/*!40000 ALTER TABLE `transaction_description` ENABLE KEYS */;


-- Dumping structure for таблиця teil_crm_dev.transaction_purpose
DROP TABLE IF EXISTS `transaction_purpose`;
CREATE TABLE IF NOT EXISTS `transaction_purpose` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table teil_crm_dev.transaction_purpose: ~2 rows (приблизно)
DELETE FROM `transaction_purpose`;
/*!40000 ALTER TABLE `transaction_purpose` DISABLE KEYS */;
INSERT INTO `transaction_purpose` (`id`, `name`) VALUES
	(2, 'purpose 1'),
	(3, 'purpose 2');
/*!40000 ALTER TABLE `transaction_purpose` ENABLE KEYS */;


-- Dumping structure for таблиця teil_crm_dev.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `perm` int(11) NOT NULL DEFAULT '500',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table teil_crm_dev.users: ~2 rows (приблизно)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `email`, `perm`, `created_at`, `updated_at`) VALUES
	(5, 'yuriikrevnyi@gmail.com', 5000, '0000-00-00 00:00:00', '2014-03-07 22:00:47'),
	(6, 'djomaxxx@mail.ru', 500, '0000-00-00 00:00:00', '2014-04-20 13:22:48');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;


-- Dumping structure for таблиця teil_crm_dev.user_role
DROP TABLE IF EXISTS `user_role`;
CREATE TABLE IF NOT EXISTS `user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf16 NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- Dumping data for table teil_crm_dev.user_role: ~7 rows (приблизно)
DELETE FROM `user_role`;
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;
INSERT INTO `user_role` (`id`, `name`) VALUES
	(6, 'Designer'),
	(2, 'Developer'),
	(1, 'Junior'),
	(5, 'Manager'),
	(7, 'Senior Designer'),
	(3, 'Senior Developer'),
	(4, 'Team Lead');
/*!40000 ALTER TABLE `user_role` ENABLE KEYS */;


-- Dumping structure for таблиця teil_crm_dev.user_role_price
DROP TABLE IF EXISTS `user_role_price`;
CREATE TABLE IF NOT EXISTS `user_role_price` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_role_id` int(11) NOT NULL,
  `price_per_hour` varchar(50) NOT NULL DEFAULT '',
  `price_per_hour_payable` varchar(50) NOT NULL DEFAULT '',
  `created_at` date NOT NULL,
  `deprecated_at` date NOT NULL DEFAULT '2099-01-01',
  PRIMARY KEY (`id`),
  KEY `user_role_id` (`user_role_id`),
  CONSTRAINT `user_role_price_ibfk_1` FOREIGN KEY (`user_role_id`) REFERENCES `user_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- Dumping data for table teil_crm_dev.user_role_price: ~14 rows (приблизно)
DELETE FROM `user_role_price`;
/*!40000 ALTER TABLE `user_role_price` DISABLE KEYS */;
INSERT INTO `user_role_price` (`id`, `user_role_id`, `price_per_hour`, `price_per_hour_payable`, `created_at`, `deprecated_at`) VALUES
	(1, 1, '10', '5', '2014-04-10', '2014-04-18'),
	(2, 2, '10', '5', '2014-04-10', '2014-04-18'),
	(3, 3, '10', '5', '2014-04-10', '2014-04-18'),
	(4, 4, '10', '5', '2014-04-10', '2014-04-18'),
	(5, 5, '10', '5', '2014-04-10', '2014-04-18'),
	(6, 6, '10', '5', '2014-04-10', '2014-04-18'),
	(7, 7, '10', '5', '2014-04-10', '2014-04-18'),
	(8, 1, '20', '10', '2014-04-18', '2099-01-01'),
	(9, 2, '20', '10', '2014-04-18', '2099-01-01'),
	(10, 3, '20', '10', '2014-04-18', '2099-01-01'),
	(11, 4, '20', '10', '2014-04-18', '2099-01-01'),
	(12, 5, '20', '10', '2014-04-18', '2099-01-01'),
	(13, 6, '20', '10', '2014-04-18', '2099-01-01'),
	(14, 7, '20', '10', '2014-04-18', '2099-01-01');
/*!40000 ALTER TABLE `user_role_price` ENABLE KEYS */;


-- Dumping structure for таблиця teil_crm_dev.user_to_project
DROP TABLE IF EXISTS `user_to_project`;
CREATE TABLE IF NOT EXISTS `user_to_project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_role_id` int(11) NOT NULL,
  `payed_hours` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`),
  KEY `user_id` (`user_id`),
  KEY `user_role_id` (`user_role_id`),
  CONSTRAINT `FK_user_to_project_user_role` FOREIGN KEY (`user_role_id`) REFERENCES `user_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_to_project_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_to_project_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=116 DEFAULT CHARSET=utf8;

-- Dumping data for table teil_crm_dev.user_to_project: ~1 rows (приблизно)
DELETE FROM `user_to_project`;
/*!40000 ALTER TABLE `user_to_project` DISABLE KEYS */;
INSERT INTO `user_to_project` (`id`, `project_id`, `user_id`, `user_role_id`, `payed_hours`) VALUES
	(115, 48, 5, 6, 15);
/*!40000 ALTER TABLE `user_to_project` ENABLE KEYS */;


-- Dumping structure for таблиця teil_crm_dev.user_to_task
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
  CONSTRAINT `user_to_task_ibfk_3` FOREIGN KEY (`user_role_id`) REFERENCES `user_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_to_task_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_to_task_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- Dumping data for table teil_crm_dev.user_to_task: ~11 rows (приблизно)
DELETE FROM `user_to_task`;
/*!40000 ALTER TABLE `user_to_task` DISABLE KEYS */;
INSERT INTO `user_to_task` (`id`, `task_id`, `user_id`, `user_role_id`, `payed_hours`) VALUES
	(13, 12, 5, 3, 1),
	(14, 12, 6, 2, 1),
	(15, 13, 5, 2, 1),
	(16, 13, 5, 3, 1),
	(17, 13, 6, 2, 1),
	(18, 12, 5, 4, 0),
	(19, 16, 5, 3, 1),
	(20, 16, 5, 4, 1),
	(21, 16, 6, 2, 1),
	(22, 17, 5, 6, 10),
	(23, 17, 5, 2, 15);
/*!40000 ALTER TABLE `user_to_task` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
