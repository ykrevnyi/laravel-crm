# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.6.16)
# Database: teil_crm_dev
# Generation Time: 2014-04-20 11:24:29 +0000
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
  `balance` varchar(255) NOT NULL DEFAULT '0',
  `icon` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

LOCK TABLES `money_account` WRITE;
/*!40000 ALTER TABLE `money_account` DISABLE KEYS */;

INSERT INTO `money_account` (`id`, `name`, `balance`, `icon`)
VALUES
	(1,'Наличные','0',''),
	(2,'Я.Деньги','0',''),
	(3,'Банк. карта','0',''),
	(4,'WMR','0',''),
	(5,'WMU','0',''),
	(6,'WMZ','0','');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `project` WRITE;
/*!40000 ALTER TABLE `project` DISABLE KEYS */;

INSERT INTO `project` (`id`, `status`, `project_priority_id`, `done_percents`, `price`, `price_per_hour`, `billed_hours`, `actual_hours`, `end_date`, `created_at`, `updated_at`)
VALUES
	(2,1,1,20,'30','40','50','60','0000-00-00','0000-00-00 00:00:00','2014-03-27 22:09:08'),
	(3,0,3,0,'10 000','10','25','0','2014-04-18','0000-00-00 00:00:00','2014-04-19 22:38:25'),
	(4,0,1,0,'','','','','0000-00-00','0000-00-00 00:00:00','2014-04-18 13:15:39'),
	(5,0,1,0,'','','','','0000-00-00','0000-00-00 00:00:00','2014-04-19 21:36:10'),
	(6,0,1,0,'','','','','0000-00-00','0000-00-00 00:00:00','2014-04-19 21:36:40'),
	(7,0,1,0,'','','','','0000-00-00','0000-00-00 00:00:00','2014-04-19 21:37:23'),
	(8,0,1,0,'','','','','0000-00-00','0000-00-00 00:00:00','2014-04-19 21:39:13'),
	(9,0,1,0,'','','','','0000-00-00','0000-00-00 00:00:00','2014-04-19 21:40:05'),
	(10,0,1,0,'','','','','0000-00-00','0000-00-00 00:00:00','2014-04-19 21:42:22'),
	(11,0,1,0,'','','','','0000-00-00','0000-00-00 00:00:00','2014-04-19 21:43:06'),
	(12,0,1,0,'','','','','0000-00-00','0000-00-00 00:00:00','2014-04-19 21:43:15'),
	(13,0,1,0,'','','','','0000-00-00','0000-00-00 00:00:00','2014-04-19 21:43:54'),
	(14,0,1,0,'','','','','0000-00-00','0000-00-00 00:00:00','2014-04-19 21:44:33'),
	(15,0,1,0,'','','','','0000-00-00','0000-00-00 00:00:00','2014-04-19 21:46:05'),
	(16,0,1,0,'','','','','0000-00-00','0000-00-00 00:00:00','2014-04-19 21:47:50'),
	(17,0,1,0,'','','','','0000-00-00','0000-00-00 00:00:00','2014-04-19 21:50:25'),
	(18,0,1,0,'','','','','0000-00-00','0000-00-00 00:00:00','2014-04-19 22:02:32'),
	(19,0,1,0,'','','','','0000-00-00','0000-00-00 00:00:00','2014-04-19 22:04:32'),
	(20,0,1,0,'','','','','0000-00-00','0000-00-00 00:00:00','2014-04-19 22:07:37'),
	(21,0,1,0,'','','','','0000-00-00','0000-00-00 00:00:00','2014-04-19 22:08:58'),
	(22,0,1,0,'','','','','0000-00-00','0000-00-00 00:00:00','2014-04-19 22:12:02'),
	(23,0,1,0,'','','','','0000-00-00','0000-00-00 00:00:00','2014-04-19 22:12:30'),
	(24,0,1,0,'','','','','0000-00-00','0000-00-00 00:00:00','2014-04-19 22:13:03'),
	(25,0,1,0,'','','','','0000-00-00','0000-00-00 00:00:00','2014-04-19 22:13:27'),
	(26,0,1,0,'','','','','0000-00-00','0000-00-00 00:00:00','2014-04-19 22:13:48'),
	(27,0,1,0,'','','','','0000-00-00','0000-00-00 00:00:00','2014-04-19 22:14:11'),
	(28,0,1,0,'','','','','0000-00-00','0000-00-00 00:00:00','2014-04-19 22:15:12'),
	(29,0,1,0,'','','','','0000-00-00','0000-00-00 00:00:00','2014-04-19 22:15:25'),
	(30,0,1,0,'','','','','0000-00-00','0000-00-00 00:00:00','2014-04-19 22:15:58'),
	(31,0,1,0,'','','','','0000-00-00','0000-00-00 00:00:00','2014-04-19 22:16:18'),
	(32,0,1,0,'','','','','0000-00-00','0000-00-00 00:00:00','2014-04-19 22:16:33'),
	(33,0,1,0,'','','','','0000-00-00','0000-00-00 00:00:00','2014-04-19 22:17:59'),
	(34,0,1,0,'','','','','0000-00-00','0000-00-00 00:00:00','2014-04-19 22:36:18'),
	(35,0,1,0,'','','','','0000-00-00','0000-00-00 00:00:00','2014-04-19 22:50:31'),
	(36,0,1,0,'','','','','0000-00-00','0000-00-00 00:00:00','2014-04-20 09:53:39'),
	(37,0,1,0,'','','','','0000-00-00','0000-00-00 00:00:00','2014-04-20 11:13:20'),
	(38,0,1,0,'','','','','0000-00-00','0000-00-00 00:00:00','2014-04-20 11:13:33'),
	(39,0,1,0,'','','','','0000-00-00','0000-00-00 00:00:00','2014-04-20 11:13:52'),
	(40,0,1,0,'','','','','0000-00-00','0000-00-00 00:00:00','2014-04-20 11:16:05'),
	(41,0,1,0,'','','','','0000-00-00','0000-00-00 00:00:00','2014-04-20 11:19:28'),
	(42,0,1,0,'','','','','0000-00-00','0000-00-00 00:00:00','2014-04-20 11:19:42'),
	(43,0,1,0,'','','','','0000-00-00','0000-00-00 00:00:00','2014-04-20 11:20:17'),
	(44,0,1,0,'','','','','0000-00-00','0000-00-00 00:00:00','2014-04-20 11:20:32'),
	(45,0,1,0,'','','','','0000-00-00','0000-00-00 00:00:00','2014-04-20 11:20:53');

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
	(4,2,'1221sdsd24','111\r\n','222'),
	(5,3,'Сверстать макет1','Описание короткое1','Полное описание проекта1'),
	(6,4,'asd12','',''),
	(7,5,'','',''),
	(8,6,'','',''),
	(9,7,'','',''),
	(10,8,'','',''),
	(11,9,'','',''),
	(12,10,'','',''),
	(13,11,'','',''),
	(14,12,'','',''),
	(15,13,'','',''),
	(16,14,'','',''),
	(17,15,'','',''),
	(18,16,'','',''),
	(19,17,'','',''),
	(20,18,'','',''),
	(21,19,'','',''),
	(22,20,'','',''),
	(23,21,'','',''),
	(24,22,'','',''),
	(25,23,'','',''),
	(26,24,'','',''),
	(27,25,'','',''),
	(28,26,'','',''),
	(29,27,'','',''),
	(30,28,'','',''),
	(31,29,'','',''),
	(32,30,'','',''),
	(33,31,'','',''),
	(34,32,'','',''),
	(35,33,'','',''),
	(36,34,'','',''),
	(37,35,'','',''),
	(38,36,'','',''),
	(39,37,'vvv','',''),
	(40,38,'','',''),
	(41,39,'','',''),
	(42,40,'','',''),
	(43,41,'','',''),
	(44,42,'','',''),
	(45,43,'','',''),
	(46,44,'','',''),
	(47,45,'','','');

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `project_priority` WRITE;
/*!40000 ALTER TABLE `project_priority` DISABLE KEYS */;

INSERT INTO `project_priority` (`id`, `sort_order`, `name`, `color`)
VALUES
	(1,500,'red','#f00'),
	(2,500,'gray','#ccc'),
	(3,500,'green','#0f0'),
	(4,500,'blue','#00f');

/*!40000 ALTER TABLE `project_priority` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table transaction
# ------------------------------------------------------------

DROP TABLE IF EXISTS `transaction`;

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_to_money_account_id` int(11) NOT NULL,
  `transaction_object_type` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `transaction_object_id` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_transaction_money_account` (`transaction_to_money_account_id`),
  CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`transaction_to_money_account_id`) REFERENCES `money_account` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

LOCK TABLES `transaction` WRITE;
/*!40000 ALTER TABLE `transaction` DISABLE KEYS */;

INSERT INTO `transaction` (`id`, `transaction_to_money_account_id`, `transaction_object_type`, `transaction_object_id`, `updated_at`, `created_at`)
VALUES
	(16,1,'none',0,'2014-03-07 22:33:37','2014-03-07 22:33:37'),
	(17,2,'none',0,'2014-03-07 22:34:06','2014-03-07 22:34:06'),
	(18,3,'user',5,'2014-03-07 22:34:45','2014-03-07 22:34:44'),
	(27,1,'none',0,'2014-03-12 21:52:58','2014-03-12 21:52:58'),
	(28,1,'none',0,'2014-03-12 22:25:55','2014-03-12 22:25:55'),
	(29,1,'none',0,'2014-03-12 22:26:39','2014-03-12 22:26:39'),
	(31,6,'project',2,'2014-03-16 21:31:40','2014-03-16 21:31:40'),
	(32,1,'project',2,'2014-03-16 22:21:50','2014-03-16 22:21:50'),
	(33,1,'project',2,'2014-03-16 22:22:43','2014-03-16 22:22:43'),
	(34,3,'user',6,'2014-03-27 21:02:50','2014-03-27 21:02:50'),
	(35,3,'project',4,'2014-04-18 13:17:04','2014-04-18 13:17:04'),
	(36,2,'project',3,'2014-04-18 16:57:30','2014-04-18 16:57:30'),
	(37,1,'project',4,'2014-04-19 14:48:49','2014-04-19 14:48:49'),
	(38,6,'project',2,'2014-04-19 14:49:21','2014-04-19 14:49:21');

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
	(16,16,2,'oplata reconn','5000',0,'2014-03-07 22:33:37','2014-03-07 22:33:37'),
	(17,17,2,'oplata pimi yandex','2500',0,'2014-03-07 22:34:06','2014-03-07 22:34:06'),
	(18,18,2,'zarplata yrka','3000',1,'2014-03-07 22:34:45','2014-03-07 22:34:45'),
	(27,27,2,'predoplata bank','5000',0,'2014-03-12 21:52:58','2014-03-12 21:52:58'),
	(28,28,2,'assa','asas',0,'2014-03-12 22:25:55','2014-03-12 22:25:55'),
	(29,29,3,'12','12',0,'2014-03-12 22:26:39','2014-03-12 22:26:39'),
	(31,31,3,'test transaction to project','15000',0,'2014-03-16 21:31:40','2014-03-16 21:31:40'),
	(32,32,2,'asas','5000',0,'2014-03-16 22:21:50','2014-03-16 22:21:50'),
	(33,33,2,'trans to proj 3','1400',0,'2014-03-16 22:22:43','2014-03-16 22:22:43'),
	(34,34,2,'test oleg','7000',0,'2014-03-27 21:02:50','2014-03-27 21:02:50'),
	(35,35,3,'Оплата чего либо','200',1,'2014-04-18 13:17:04','2014-04-18 13:17:04'),
	(36,36,3,'demo transaction to markup','20000',0,'2014-04-18 16:57:30','2014-04-18 16:57:30'),
	(37,37,2,'rrrrjjjhh','1000',1,'2014-04-19 14:48:49','2014-04-19 14:48:49'),
	(38,38,2,'jhjgtbbnnkjkjjk','750',1,'2014-04-19 14:49:21','2014-04-19 14:49:21');

/*!40000 ALTER TABLE `transaction_description` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table transaction_purpose
# ------------------------------------------------------------

DROP TABLE IF EXISTS `transaction_purpose`;

CREATE TABLE `transaction_purpose` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `transaction_purpose` WRITE;
/*!40000 ALTER TABLE `transaction_purpose` DISABLE KEYS */;

INSERT INTO `transaction_purpose` (`id`, `name`)
VALUES
	(2,'purpose 1'),
	(3,'purpose 2');

/*!40000 ALTER TABLE `transaction_purpose` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user_role
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_role`;

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf16 NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `user_role` WRITE;
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;

INSERT INTO `user_role` (`id`, `name`)
VALUES
	(6,'Designer'),
	(2,'Developer'),
	(1,'Junior'),
	(5,'Manager'),
	(7,'Senior Designer'),
	(3,'Senior Developer'),
	(4,'Team Lead');

/*!40000 ALTER TABLE `user_role` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user_to_project
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_to_project`;

CREATE TABLE `user_to_project` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `user_to_project` WRITE;
/*!40000 ALTER TABLE `user_to_project` DISABLE KEYS */;

INSERT INTO `user_to_project` (`id`, `project_id`, `user_id`, `user_role_id`, `payed_hours`)
VALUES
	(107,2,5,3,10),
	(108,45,5,2,5);

/*!40000 ALTER TABLE `user_to_project` ENABLE KEYS */;
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
	(6,'djomaxxx@mail.ru',500,'0000-00-00 00:00:00','0000-00-00 00:00:00');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
