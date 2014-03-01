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


-- Dumping structure for таблиця teil_crm_dev.transaction
DROP TABLE IF EXISTS `transaction`;
CREATE TABLE IF NOT EXISTS `transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_description_id` int(11) NOT NULL,
  `transaction_to_project_id` int(11) NOT NULL,
  `transaction_to_money_account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_transaction_transaction_description` (`transaction_description_id`),
  KEY `FK_transaction_money_account` (`transaction_to_money_account_id`),
  CONSTRAINT `FK_transaction_money_account` FOREIGN KEY (`transaction_to_money_account_id`) REFERENCES `money_account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_transaction_transaction_description` FOREIGN KEY (`transaction_description_id`) REFERENCES `transaction_description` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

-- Dumping data for table teil_crm_dev.transaction: ~0 rows (приблизно)
DELETE FROM `transaction`;
/*!40000 ALTER TABLE `transaction` DISABLE KEYS */;
/*!40000 ALTER TABLE `transaction` ENABLE KEYS */;


-- Dumping structure for таблиця teil_crm_dev.transaction_description
DROP TABLE IF EXISTS `transaction_description`;
CREATE TABLE IF NOT EXISTS `transaction_description` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `is_expense` tinyint(4) NOT NULL DEFAULT '0',
  `purpose` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

-- Dumping data for table teil_crm_dev.transaction_description: ~0 rows (приблизно)
DELETE FROM `transaction_description`;
/*!40000 ALTER TABLE `transaction_description` DISABLE KEYS */;
/*!40000 ALTER TABLE `transaction_description` ENABLE KEYS */;


-- Dumping structure for таблиця teil_crm_dev.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `perm` int(11) NOT NULL DEFAULT '500',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table teil_crm_dev.users: ~1 rows (приблизно)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `email`, `perm`, `created_at`, `updated_at`) VALUES
	(5, 'yuriikrevnyi@gmail.com', 500, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
