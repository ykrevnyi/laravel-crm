# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.6.16)
# Database: teil_crm_dev
# Generation Time: 2014-05-12 21:38:16 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table currencies
# ------------------------------------------------------------

DROP TABLE IF EXISTS `currencies`;

CREATE TABLE `currencies` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `price` varchar(100) NOT NULL DEFAULT '0',
  `unit` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `currencies` WRITE;
/*!40000 ALTER TABLE `currencies` DISABLE KEYS */;

INSERT INTO `currencies` (`id`, `name`, `price`, `unit`, `created_at`, `updated_at`)
VALUES
	(1,'USD','13','$','2014-05-12 20:15:07','2014-05-12 21:10:09'),
	(2,'Гривна','1','грн.','2014-05-12 20:21:32','2014-05-12 21:10:22'),
	(3,'Рубль','0,25','руб.','2014-05-12 20:21:48','2014-05-12 21:10:30');

/*!40000 ALTER TABLE `currencies` ENABLE KEYS */;
UNLOCK TABLES;


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
  `losses` float NOT NULL DEFAULT '0',
  `currency_id` int(11) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `currency_id` (`currency_id`),
  CONSTRAINT `money_account_ibfk_1` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `money_account` WRITE;
/*!40000 ALTER TABLE `money_account` DISABLE KEYS */;

INSERT INTO `money_account` (`id`, `name`, `icon`, `losses`, `currency_id`, `created_at`, `updated_at`)
VALUES
	(12,'ЯД. Шкабко','',12,2,'2014-04-29 08:07:48','2014-05-12 21:26:27'),
	(13,'WebMoney RUB','',10,2,'2014-04-29 08:07:59','2014-05-12 21:21:45'),
	(14,'WebMoney UAH','',0,2,'2014-04-29 08:08:09','2014-05-02 11:13:45'),
	(15,'ЯД. Босько','',0,2,'2014-04-29 08:08:38','2014-05-02 11:13:59'),
	(16,'УкрСибБанк','',0,2,'2014-04-29 08:08:46','2014-05-02 11:14:20'),
	(17,'Приват Банк','',0,2,'2014-05-02 11:14:28','2014-05-02 11:14:28');

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
	(65,0,6,10,'','2014-04-28','2014-03-30','2014-04-29'),
	(69,0,8,0,'0','2014-06-12','2014-05-02','2014-05-02'),
	(70,0,8,5,'0','2014-06-06','2014-05-02','2014-05-02'),
	(71,0,6,100,'0','2014-05-07','2014-05-07','2014-05-07'),
	(72,0,6,100,'0','2014-05-12','2014-05-12','2014-05-12');

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
	(67,65,'Проект 1','Создание верстки + интеграция','Создание верстки + интеграция'),
	(71,69,'FASPA','Сайт \"под ключ\" на CMS Битрикс','Сайт \"под ключ\" на CMS Битрикс'),
	(72,70,'ЦЗИ','Сайт \"под ключ\" на CMS Битрикс','Сайт \"под ключ\" на CMS Битрикс для компании, которая специализируется на заточке инструментов. '),
	(73,71,'LP Михаила Бакунина','Верстка и перенос на хостинг тренирга','Верстка и перенос на хостинг тренирга'),
	(74,72,'Прометей','Сайт на WordPress ','Сайт на WordPress ');

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
	(6,500,'Завершено','#05e123','2014-04-29 08:01:26','2014-05-02 11:37:18'),
	(7,500,'Низкий','#f1e366','2014-04-29 08:01:46','2014-05-02 11:36:50'),
	(8,500,'Нормальный','#f3b800','2014-04-29 08:02:03','2014-05-02 11:36:33'),
	(9,500,'Высокий','#ed2051','2014-04-29 08:24:22','2014-05-02 11:35:28'),
	(10,500,'Немедленно','#d11241','2014-04-29 08:33:10','2014-05-02 11:35:40');

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
	(40,69,'Разработка ТЗ','Разработать ТЗ ','Разработать ТЗ на основании полученной информации','2014-05-02','2014-05-02'),
	(42,70,'Разработка прототипов','Разработать прототипы','Разработать прототипы на основе полученной информации','2014-05-02','2014-05-02'),
	(44,70,'Дизайн','Разработать дизайн','Разработать дизайн','2014-05-02','2014-05-02'),
	(45,71,'Верстка','Верстка','Верстка','2014-05-07','2014-05-07'),
	(46,72,'Доработки (Прометей)','Сделать доработки','Прометей(доработки):\r\n1) Нужно дополнить главную страницу, сертификаты сделать кликабельными, чтобы всплывали документы большего размера.\r\n\r\n2) Сделать, чтобы по клику на адресе эл.почты в заголовке всплывало окно заявки\r\n\r\nПо форме заявки: \r\n1) я дополнил поля, просьба проверить корректность кода \r\n2) Убрать проверку валидности номера телефона  \r\n3) Сделать чек-боксы с новой строки','2014-05-12','2014-05-12');

/*!40000 ALTER TABLE `task` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table transaction
# ------------------------------------------------------------

DROP TABLE IF EXISTS `transaction`;

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_to_money_account_id` int(11) NOT NULL,
  `transaction_object_type` varchar(100) NOT NULL DEFAULT '',
  `transaction_object_id` int(11) NOT NULL,
  `updated_at` date NOT NULL,
  `created_at` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_transaction_money_account` (`transaction_to_money_account_id`),
  CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`transaction_to_money_account_id`) REFERENCES `money_account` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `transaction` WRITE;
/*!40000 ALTER TABLE `transaction` DISABLE KEYS */;

INSERT INTO `transaction` (`id`, `transaction_to_money_account_id`, `transaction_object_type`, `transaction_object_id`, `updated_at`, `created_at`)
VALUES
	(49,13,'none',0,'2014-04-29','2014-03-30'),
	(55,12,'project',69,'2014-05-02','2014-05-02'),
	(56,12,'project',71,'2014-05-07','2014-05-07'),
	(57,12,'project',72,'2014-05-12','2014-05-12');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `transaction_description` WRITE;
/*!40000 ALTER TABLE `transaction_description` DISABLE KEYS */;

INSERT INTO `transaction_description` (`id`, `transaction_id`, `transaction_purpose_id`, `name`, `value`, `is_expense`, `created_at`, `updated_at`)
VALUES
	(49,49,3,'оплата','1000',0,'2014-04-29 13:34:24','2014-04-29 13:34:24'),
	(55,55,4,'Предоплата за ТЗ и прототипы','7500',0,'2014-05-02 12:10:24','2014-05-02 12:10:24'),
	(56,56,8,'Оплата верстки LP','1827',0,'2014-05-07 15:45:06','2014-05-07 15:45:06'),
	(57,57,4,'sdasd','111',0,'2014-05-12 21:30:52','2014-05-12 21:30:52');

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
	(3,'Зарплата','2014-04-29 08:05:55','2014-04-29 08:40:11'),
	(4,'Предоплата','2014-04-29 08:39:37','2014-05-02 11:39:59'),
	(6,'Аренда','2014-04-29 08:45:00','2014-05-02 11:40:26'),
	(8,'Поступление','2014-05-02 11:41:09','2014-05-02 11:41:09');

/*!40000 ALTER TABLE `transaction_purpose` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user_role
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_role`;

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `percents` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `user_role` WRITE;
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;

INSERT INTO `user_role` (`id`, `name`, `percents`, `created_at`, `updated_at`)
VALUES
	(14,'Менеджер',1,'2014-04-29 07:53:55','2014-05-02 11:51:48'),
	(25,'Team Lead',1,'2014-05-02 12:14:15','2014-05-02 12:14:15'),
	(26,'Верстальщик (Dev)',0,'2014-05-02 12:14:27','2014-05-02 12:14:27'),
	(27,'Верстальщик (Sen)',0,'2014-05-02 12:14:39','2014-05-02 12:14:39'),
	(28,'Open Source (Dev)',0,'2014-05-02 12:15:36','2014-05-02 12:15:36'),
	(29,'Open Source (Sen)',0,'2014-05-02 12:16:03','2014-05-02 12:16:03'),
	(30,'Коробка (Dev)',0,'2014-05-02 12:17:32','2014-05-02 12:17:32'),
	(31,'Коробка (Sen)',0,'2014-05-02 12:18:34','2014-05-02 12:18:34'),
	(32,'Дизайнер (Dev) ',0,'2014-05-02 12:19:17','2014-05-02 12:19:17'),
	(33,'Дизайнер (Sen) ',0,'2014-05-02 12:19:45','2014-05-02 12:19:45'),
	(34,'Тестер',0,'2014-05-02 12:20:42','2014-05-02 12:20:42'),
	(35,'Проектировщик',0,'2014-05-02 12:22:48','2014-05-02 12:22:48'),
	(36,'Копирайтер',0,'2014-05-02 12:23:24','2014-05-02 12:23:24');

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
	(36,14,'50','35','2014-01-04','2014-04-29'),
	(47,14,'40','30','2014-03-01','2014-03-15'),
	(48,14,'40','30','2014-03-15','2014-03-25'),
	(49,14,'14','7','2014-03-25','2014-04-20'),
	(50,14,'72','50','2014-04-20','2014-05-02'),
	(51,14,'5','5','2014-05-02','2099-01-01'),
	(57,25,'5','5','2014-05-02','2099-01-01'),
	(58,26,'183','58','2014-05-02','2099-01-01'),
	(59,27,'261','83','2014-05-02','2099-01-01'),
	(60,28,'221','70','2014-05-02','2099-01-01'),
	(61,29,'315','100','2014-05-02','2099-01-01'),
	(62,30,'299','95','2014-05-02','2099-01-01'),
	(63,31,'360','112','2014-05-02','2099-01-01'),
	(64,32,'252','80','2014-05-02','2099-01-01'),
	(65,33,'360','112','2014-05-02','2099-01-01'),
	(66,34,'183','58','2014-05-02','2099-01-01'),
	(67,35,'299','95','2014-05-02','2099-01-01'),
	(68,36,'221','70','2014-05-02','2099-01-01');

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
	(75,40,8,14,0),
	(77,40,8,35,4),
	(78,42,9,32,5),
	(79,42,8,14,0),
	(80,44,9,32,28),
	(81,44,8,14,0),
	(82,45,10,27,7),
	(83,46,11,28,2);

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
	(6,'djomaxxx@mail.ru',5000,'0000-00-00 00:00:00','2014-04-29 07:50:55'),
	(7,'r.shkabko@teil.com.ua',500,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(8,'m.polazhynets@teil.com.ua',500,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(9,'v.marmooliak@gmail.com',500,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(10,'pada2sh@mail.ru',500,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(11,'o.ruzhytskyy@teil.com.ua',500,'0000-00-00 00:00:00','0000-00-00 00:00:00');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
