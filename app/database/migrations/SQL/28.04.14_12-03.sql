# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.6.16)
# Database: teil_crm_dev
# Generation Time: 2014-04-28 09:03:13 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`migration`, `batch`)
VALUES
	('2013_09_08_182322_create_users_table',1),
	('2013_09_08_184042_create_users_group_table',1),
	('2013_09_09_065654_add_email_field_to_users_table',1);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table money_account
# ------------------------------------------------------------

DROP TABLE IF EXISTS `money_account`;

CREATE TABLE `money_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `icon` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

LOCK TABLES `money_account` WRITE;
/*!40000 ALTER TABLE `money_account` DISABLE KEYS */;

INSERT INTO `money_account` (`id`, `name`, `icon`, `created_at`, `updated_at`)
VALUES
	(1,'Наличные','',NULL,'2014-04-27 11:53:00'),
	(2,'Я.Деньги','',NULL,NULL),
	(3,'Банк. карта','',NULL,NULL),
	(4,'WMR','',NULL,NULL),
	(5,'WMU','',NULL,NULL),
	(9,'WMZ','','2014-04-27 13:59:38','2014-04-27 13:59:38');

/*!40000 ALTER TABLE `money_account` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table project
# ------------------------------------------------------------

DROP TABLE IF EXISTS `project`;

CREATE TABLE `project` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `project` WRITE;
/*!40000 ALTER TABLE `project` DISABLE KEYS */;

INSERT INTO `project` (`id`, `status`, `project_priority_id`, `done_percents`, `actual_hours`, `end_date`, `created_at`, `updated_at`)
VALUES
	(54,0,2,15,'','2014-04-30','2014-04-24','2014-04-24'),
	(55,0,1,0,'','2014-05-01','2014-04-26','2014-04-26');

/*!40000 ALTER TABLE `project` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table project_description
# ------------------------------------------------------------

DROP TABLE IF EXISTS `project_description`;

CREATE TABLE `project_description` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `desctiption_short` text NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`),
  CONSTRAINT `project_description_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `project_description` WRITE;
/*!40000 ALTER TABLE `project_description` DISABLE KEYS */;

INSERT INTO `project_description` (`id`, `project_id`, `name`, `desctiption_short`, `description`)
VALUES
	(56,54,'Тестовый проект №1','Верстка + разработка шаблона UMI.CMS','Ознакомился с предложением, есть вопросы и пояснения.\r\nДля наглядности прилагаю таблицу в экселе. Легенда цветных строк внизу страницы.\r\nОдностраничное приложение (далее ОП) точно делать не будем, потому что не уложимся в бюджет и потому что это будет плохо для SEO, а продвижение — ключевой момент в этом проекте.'),
	(57,55,'demoad','test','test test');

/*!40000 ALTER TABLE `project_description` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table project_priority
# ------------------------------------------------------------

DROP TABLE IF EXISTS `project_priority`;

CREATE TABLE `project_priority` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sort_order` int(11) NOT NULL DEFAULT '500',
  `name` varchar(255) NOT NULL DEFAULT '',
  `color` varchar(255) NOT NULL DEFAULT '',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `project_priority` WRITE;
/*!40000 ALTER TABLE `project_priority` DISABLE KEYS */;

INSERT INTO `project_priority` (`id`, `sort_order`, `name`, `color`, `created_at`, `updated_at`)
VALUES
	(1,500,'red','#bc1717',NULL,'2014-04-27 14:34:02'),
	(2,500,'gray','#ccc',NULL,NULL),
	(3,500,'green','#0f0',NULL,NULL),
	(4,500,'blue','#00f',NULL,NULL);

/*!40000 ALTER TABLE `project_priority` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table task
# ------------------------------------------------------------

DROP TABLE IF EXISTS `task`;

CREATE TABLE `task` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `task` WRITE;
/*!40000 ALTER TABLE `task` DISABLE KEYS */;

INSERT INTO `task` (`id`, `project_id`, `name`, `short_description`, `description`, `created_at`, `updated_at`)
VALUES
	(18,54,'Составить тех. задание','Необходимо составить КП (смету) и тех. задание к проекту','Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.','2014-04-14','2014-04-26'),
	(19,54,'Сверстать макет (адаптивно)','Нужно сверстать макет на twitter bootstrap 3','Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.','2014-04-26','2014-04-26'),
	(20,54,'Добавить зеленую кнопку в хедер','Ничего не работает! Нужно зеленая кнопка - срочно!!!','Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.','2014-04-26','2014-04-26'),
	(21,55,'Сверстать макет','Сверстать макет HTML5','Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.','2014-04-26','2014-04-26');

/*!40000 ALTER TABLE `task` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table transaction
# ------------------------------------------------------------

DROP TABLE IF EXISTS `transaction`;

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_to_money_account_id` int(11) NOT NULL,
  `transaction_object_type` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `transaction_object_id` int(11) NOT NULL,
  `updated_at` date NOT NULL,
  `created_at` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_transaction_money_account` (`transaction_to_money_account_id`),
  CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`transaction_to_money_account_id`) REFERENCES `money_account` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

LOCK TABLES `transaction` WRITE;
/*!40000 ALTER TABLE `transaction` DISABLE KEYS */;

INSERT INTO `transaction` (`id`, `transaction_to_money_account_id`, `transaction_object_type`, `transaction_object_id`, `updated_at`, `created_at`)
VALUES
	(43,1,'user',5,'2014-04-26','2014-04-26'),
	(44,1,'project',55,'2014-04-26','2014-04-26');

/*!40000 ALTER TABLE `transaction` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table transaction_description
# ------------------------------------------------------------

DROP TABLE IF EXISTS `transaction_description`;

CREATE TABLE `transaction_description` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

LOCK TABLES `transaction_description` WRITE;
/*!40000 ALTER TABLE `transaction_description` DISABLE KEYS */;

INSERT INTO `transaction_description` (`id`, `transaction_id`, `transaction_purpose_id`, `name`, `value`, `is_expense`, `created_at`, `updated_at`)
VALUES
	(43,43,2,'Аванс','200',1,'2014-04-26 13:21:18','2014-04-26 13:21:18'),
	(44,44,2,'Предоплата по верстке','250',0,'2014-04-26 13:25:00','2014-04-26 13:25:00');

/*!40000 ALTER TABLE `transaction_description` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table transaction_purpose
# ------------------------------------------------------------

DROP TABLE IF EXISTS `transaction_purpose`;

CREATE TABLE `transaction_purpose` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `transaction_purpose` WRITE;
/*!40000 ALTER TABLE `transaction_purpose` DISABLE KEYS */;

INSERT INTO `transaction_purpose` (`id`, `name`, `created_at`, `updated_at`)
VALUES
	(2,'purpose 1',NULL,NULL);

/*!40000 ALTER TABLE `transaction_purpose` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user_role
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_role`;

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf16 NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `user_role` WRITE;
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;

INSERT INTO `user_role` (`id`, `name`, `created_at`, `updated_at`)
VALUES
	(1,'Junior','2014-04-28 08:56:35','2014-04-28 08:56:35'),
	(2,'Developer','2014-04-28 08:56:35','2014-04-28 08:56:35'),
	(3,'Senior Developer','2014-04-28 08:56:35','2014-04-28 08:56:35'),
	(4,'Team Lead','2014-04-28 08:56:35','2014-04-28 08:56:35'),
	(5,'Manager','2014-04-28 08:56:35','2014-04-28 08:56:35'),
	(6,'Designer1','2014-04-28 08:56:35','2014-04-28 08:56:35'),
	(7,'Senior Designer','2014-04-28 08:56:35','2014-04-28 08:56:35'),
	(8,'test','2014-04-28 08:56:35','2014-04-28 08:56:35');

/*!40000 ALTER TABLE `user_role` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user_role_price
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_role_price`;

CREATE TABLE `user_role_price` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_role_id` int(11) NOT NULL,
  `price_per_hour` varchar(50) NOT NULL DEFAULT '',
  `price_per_hour_payable` varchar(50) NOT NULL DEFAULT '',
  `created_at` date NOT NULL,
  `deprecated_at` date DEFAULT '2099-01-01',
  PRIMARY KEY (`id`),
  KEY `user_role_id` (`user_role_id`),
  CONSTRAINT `user_role_price_ibfk_1` FOREIGN KEY (`user_role_id`) REFERENCES `user_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `user_role_price` WRITE;
/*!40000 ALTER TABLE `user_role_price` DISABLE KEYS */;

INSERT INTO `user_role_price` (`id`, `user_role_id`, `price_per_hour`, `price_per_hour_payable`, `created_at`, `deprecated_at`)
VALUES
	(1,1,'10','5','2014-04-10','2014-04-25'),
	(2,2,'10','5','2014-04-10','2014-04-25'),
	(3,3,'10','5','2014-04-10','2014-04-25'),
	(4,4,'10','5','2014-04-10','2014-04-25'),
	(5,5,'10','5','2014-04-10','2014-04-25'),
	(6,6,'10','5','2014-04-10','2014-04-25'),
	(7,7,'10','5','2014-04-10','2014-04-25'),
	(8,1,'20','10','2014-04-25','2099-01-01'),
	(9,2,'20','10','2014-04-25','2099-01-01'),
	(10,3,'20','10','2014-04-25','2099-01-01'),
	(11,4,'20','10','2014-04-25','2099-01-01'),
	(12,5,'20','10','2014-04-25','2099-01-01'),
	(13,6,'20','10','2014-04-25','2014-04-26'),
	(14,7,'20','10','2014-04-25','2099-01-01'),
	(15,8,'20','5','2014-04-28','2014-04-28'),
	(16,6,'55','18','2014-04-26','2014-04-28'),
	(17,6,'32','2','2014-04-28','2014-04-28'),
	(18,6,'32','2','2014-04-28','2099-01-01'),
	(19,8,'20','5','2014-04-28','2099-01-01'),
	(20,8,'25','5','2014-04-28','2099-01-01');

/*!40000 ALTER TABLE `user_role_price` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user_to_task
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_to_task`;

CREATE TABLE `user_to_task` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `user_to_task` WRITE;
/*!40000 ALTER TABLE `user_to_task` DISABLE KEYS */;

INSERT INTO `user_to_task` (`id`, `task_id`, `user_id`, `user_role_id`, `payed_hours`)
VALUES
	(24,18,5,4,0),
	(25,18,5,3,1),
	(26,19,5,4,0),
	(27,19,5,3,10),
	(28,20,5,3,5),
	(29,21,5,2,10),
	(30,21,5,3,15),
	(31,21,5,4,0),
	(32,21,6,2,25);

/*!40000 ALTER TABLE `user_to_task` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `perm` int(11) NOT NULL DEFAULT '500',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `email`, `perm`, `created_at`, `updated_at`)
VALUES
	(5,'yuriikrevnyi@gmail.com',5000,'0000-00-00 00:00:00','2014-03-07 22:00:47'),
	(6,'djomaxxx@mail.ru',500,'0000-00-00 00:00:00','2014-04-26 08:50:43');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
