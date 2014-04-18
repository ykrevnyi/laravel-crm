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
  `price` varchar(255) NOT NULL DEFAULT '0',
  `price_per_hour` varchar(255) NOT NULL DEFAULT '0',
  `billed_hours` varchar(255) NOT NULL DEFAULT '0',
  `actual_hours` varchar(255) NOT NULL DEFAULT '0',
  `end_date` date NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `project_priority_id` (`project_priority_id`),
  CONSTRAINT `project_ibfk_1` FOREIGN KEY (`project_priority_id`) REFERENCES `project_priority` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Dumping data for table teil_crm_dev.project: ~3 rows (приблизно)
DELETE FROM `project`;
/*!40000 ALTER TABLE `project` DISABLE KEYS */;
INSERT INTO `project` (`id`, `status`, `project_priority_id`, `done_percents`, `price`, `price_per_hour`, `billed_hours`, `actual_hours`, `end_date`, `created_at`, `updated_at`) VALUES
	(2, 1, 1, 20, '30', '40', '50', '60', '0000-00-00', '0000-00-00 00:00:00', '2014-03-27 22:09:08'),
	(3, 0, 3, 0, '10 000', '10', '25', '0', '2014-04-18', '0000-00-00 00:00:00', '2014-04-18 14:43:36'),
	(4, 0, 1, 0, '', '', '', '', '0000-00-00', '0000-00-00 00:00:00', '2014-04-18 13:15:39');
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Dumping data for table teil_crm_dev.project_description: ~3 rows (приблизно)
DELETE FROM `project_description`;
/*!40000 ALTER TABLE `project_description` DISABLE KEYS */;
INSERT INTO `project_description` (`id`, `project_id`, `name`, `desctiption_short`, `description`) VALUES
	(4, 2, '1221sdsd24', '111\r\n', '222'),
	(5, 3, 'Сверстать макет1', 'Описание короткое1', 'Полное описание проекта1'),
	(6, 4, 'asd12', '', '');
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


-- Dumping structure for таблиця teil_crm_dev.transaction
DROP TABLE IF EXISTS `transaction`;
CREATE TABLE IF NOT EXISTS `transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_to_money_account_id` int(11) NOT NULL,
  `transaction_object_type` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `transaction_object_id` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_transaction_money_account` (`transaction_to_money_account_id`),
  CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`transaction_to_money_account_id`) REFERENCES `money_account` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf16;

-- Dumping data for table teil_crm_dev.transaction: ~12 rows (приблизно)
DELETE FROM `transaction`;
/*!40000 ALTER TABLE `transaction` DISABLE KEYS */;
INSERT INTO `transaction` (`id`, `transaction_to_money_account_id`, `transaction_object_type`, `transaction_object_id`, `updated_at`, `created_at`) VALUES
	(16, 1, 'none', 0, '2014-03-07 22:33:37', '2014-03-07 22:33:37'),
	(17, 2, 'none', 0, '2014-03-07 22:34:06', '2014-03-07 22:34:06'),
	(18, 3, 'user', 5, '2014-03-07 22:34:45', '2014-03-07 22:34:44'),
	(27, 1, 'none', 0, '2014-03-12 21:52:58', '2014-03-12 21:52:58'),
	(28, 1, 'none', 0, '2014-03-12 22:25:55', '2014-03-12 22:25:55'),
	(29, 1, 'none', 0, '2014-03-12 22:26:39', '2014-03-12 22:26:39'),
	(31, 6, 'project', 2, '2014-03-16 21:31:40', '2014-03-16 21:31:40'),
	(32, 1, 'project', 2, '2014-03-16 22:21:50', '2014-03-16 22:21:50'),
	(33, 1, 'project', 2, '2014-03-16 22:22:43', '2014-03-16 22:22:43'),
	(34, 3, 'user', 6, '2014-03-27 21:02:50', '2014-03-27 21:02:50'),
	(35, 3, 'project', 4, '2014-04-18 13:17:04', '2014-04-18 13:17:04'),
	(36, 2, 'project', 3, '2014-04-18 16:57:30', '2014-04-18 16:57:30');
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
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf16;

-- Dumping data for table teil_crm_dev.transaction_description: ~12 rows (приблизно)
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
	(33, 33, 2, 'trans to proj 3', '1400', 0, '2014-03-16 22:22:43', '2014-03-16 22:22:43'),
	(34, 34, 2, 'test oleg', '7000', 0, '2014-03-27 21:02:50', '2014-03-27 21:02:50'),
	(35, 35, 3, 'Оплата чего либо', '200', 1, '2014-04-18 13:17:04', '2014-04-18 13:17:04'),
	(36, 36, 3, 'demo transaction to markup', '20000', 0, '2014-04-18 16:57:30', '2014-04-18 16:57:30');
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
	(6, 'djomaxxx@mail.ru', 500, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
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


-- Dumping structure for таблиця teil_crm_dev.user_to_project
DROP TABLE IF EXISTS `user_to_project`;
CREATE TABLE IF NOT EXISTS `user_to_project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_role_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`),
  KEY `user_id` (`user_id`),
  KEY `user_role_id` (`user_role_id`),
  CONSTRAINT `FK_user_to_project_user_role` FOREIGN KEY (`user_role_id`) REFERENCES `user_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_to_project_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_to_project_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8;

-- Dumping data for table teil_crm_dev.user_to_project: ~16 rows (приблизно)
DELETE FROM `user_to_project`;
/*!40000 ALTER TABLE `user_to_project` DISABLE KEYS */;
INSERT INTO `user_to_project` (`id`, `project_id`, `user_id`, `user_role_id`) VALUES
	(15, 2, 6, 2),
	(46, 2, 5, 2),
	(47, 2, 5, 2),
	(48, 2, 5, 2),
	(49, 2, 5, 2),
	(52, 2, 5, 2),
	(53, 2, 5, 2),
	(54, 2, 5, 2),
	(55, 2, 5, 2),
	(56, 2, 5, 2),
	(57, 2, 5, 2),
	(58, 2, 5, 2),
	(59, 2, 5, 2),
	(61, 3, 5, 3),
	(64, 3, 5, 4),
	(72, 3, 6, 2);
/*!40000 ALTER TABLE `user_to_project` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
