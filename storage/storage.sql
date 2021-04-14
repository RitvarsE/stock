-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for stock
CREATE DATABASE IF NOT EXISTS `stock` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `stock`;

-- Dumping structure for table stock.stock
CREATE TABLE IF NOT EXISTS `stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL DEFAULT '',
  `stock_name` varchar(50) NOT NULL DEFAULT '',
  `stock_price_bought` varchar(50) NOT NULL DEFAULT '',
  `stock_amount` varchar(50) NOT NULL DEFAULT '',
  `stock_price_now` varchar(50) NOT NULL DEFAULT '',
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `stock_sold` float DEFAULT NULL,
  `timestamp_buy` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `timestamp_sold` timestamp NULL DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;

-- Dumping data for table stock.stock: ~8 rows (approximately)
/*!40000 ALTER TABLE `stock` DISABLE KEYS */;
INSERT INTO `stock` (`id`, `user_name`, `stock_name`, `stock_price_bought`, `stock_amount`, `stock_price_now`, `active`, `stock_sold`, `timestamp_buy`, `timestamp_sold`) VALUES
	(44, 'Agnese', 'PKI', '13243', '3', '13243', 1, NULL, '2021-04-14 21:44:47', NULL),
	(45, 'Agnese', 'TWTR', '7054', '3', '7054', 1, NULL, '2021-04-14 21:45:19', NULL),
	(46, 'Agnese', 'WFC', '4196.5', '5', '4196.5', 1, NULL, '2021-04-14 21:45:41', NULL),
	(47, 'Agnese', 'FCX', '3666.5', '4.94', '3666.5', 1, NULL, '2021-04-14 21:46:26', NULL),
	(48, 'Ritvars', 'HPQ', '3339.5', '10', '3339.5', 1, NULL, '2021-04-14 21:48:37', NULL),
	(49, 'Ritvars', 'RACE', '20818.5', '2', '20818.5', 1, NULL, '2021-04-14 21:49:55', NULL),
	(50, 'Ritvars', 'DOGE-USD', '12.519315', '1000', '12.519315', 1, NULL, '2021-04-14 21:50:54', NULL),
	(51, 'Ritvars', 'BAC', '3990.57', '3.11', '3990.57', 1, NULL, '2021-04-14 21:52:43', NULL);
/*!40000 ALTER TABLE `stock` ENABLE KEYS */;

-- Dumping structure for table stock.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) COLLATE utf8_bin NOT NULL,
  `password` varchar(1000) COLLATE utf8_bin NOT NULL,
  `wallet` float NOT NULL DEFAULT '0',
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Dumping data for table stock.user: ~2 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `user_name`, `password`, `wallet`) VALUES
	(1, 'Agnese', '$2y$10$kClrTdGcZlok38Jx9O4AJ.0vtMTfO4EhCMhwIuVHnTx9CF7ZyALdG', 13.99),
	(2, 'Ritvars', '$2y$10$wdwOYW9svDflkll1KGoWAu4N0T0bG7hZBZMBg0DTnrUArBu9K8pcK', 38.0273);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
