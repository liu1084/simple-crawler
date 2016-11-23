/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 10.1.10-MariaDB-log : Database - ebook
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`ebook` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;

USE `ebook`;

/*Table structure for table `books` */

DROP TABLE IF EXISTS `books`;

CREATE TABLE `books` (
  `id` bigint(30) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '书名',
  `cover` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '封面图片',
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '作者',
  `isbn` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'ISBN',
  `year` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '出版年份',
  `pages` int(10) NOT NULL DEFAULT '0' COMMENT '页数',
  `language` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'english' COMMENT '语言',
  `size` float NOT NULL DEFAULT '0' COMMENT '文件大小',
  `format` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pdf' COMMENT '文件格式',
  `category` bigint(10) NOT NULL DEFAULT '0' COMMENT '分类',
  `rating` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `books` */

/*Table structure for table `categories` */

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` bigint(30) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `categories` */

insert  into `categories`(`id`,`name`) values (1,'Web Development'),(2,'Programming'),(3,'Datebases'),(4,'Graphics & Design'),(5,'Operating Systems'),(6,'Networking & Cloud Computing'),(7,'Administration'),(8,'Certification'),(9,'Computers & Technology'),(10,'Enterprise'),(11,'Game Programming'),(12,'Hardware & DIY'),(13,'Marketing & SEO'),(14,'Security'),(15,'Software');

/*Table structure for table `comments` */

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments` (
  `id` bigint(30) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(30) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(30) unsigned NOT NULL DEFAULT '0',
  `status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'publish',
  `rating` tinyint(1) NOT NULL DEFAULT '0',
  `book_id` bigint(30) unsigned NOT NULL DEFAULT '0',
  `ip_address` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `comments` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
