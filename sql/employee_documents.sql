-- Adminer 4.3.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `employee_documents`;
CREATE TABLE `employee_documents` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(10) unsigned NOT NULL,
  `file_type_id` int(11) DEFAULT NULL,
  `file_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_documents_employee_id_foreign` (`employee_id`),
  CONSTRAINT `employee_documents_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `employee_documents` (`id`, `employee_id`, `file_type_id`, `file_path`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1,	1,	1,	'uploads/photos/11512410421.jpg',	'2017-12-04 12:00:21',	'2017-12-04 12:00:21',	NULL,	NULL,	NULL,	NULL),
(2,	1,	2,	'uploads/signatures/11512410421.jpg',	'2017-12-04 12:00:21',	'2017-12-04 12:00:21',	NULL,	NULL,	NULL,	NULL),
(3,	1,	1,	'uploads/files/1-1-1512410444.jpg',	'2017-12-04 12:00:44',	'2017-12-04 12:00:44',	NULL,	NULL,	NULL,	NULL),
(4,	1,	3,	'uploads/files/1-3-1512410524.pdf',	'2017-12-04 12:02:04',	'2017-12-04 12:02:04',	NULL,	NULL,	NULL,	NULL),
(5,	1,	1,	'uploads/files/1-1-1512410566.jpg',	'2017-12-04 12:02:46',	'2017-12-04 12:02:46',	NULL,	NULL,	NULL,	NULL),
(6,	1,	5,	'uploads/files/1-5-1512410651.pdf',	'2017-12-04 12:04:11',	'2017-12-04 12:04:11',	NULL,	NULL,	NULL,	NULL),
(7,	1,	6,	'uploads/files/1-6-1512410694.jpg',	'2017-12-04 12:04:54',	'2017-12-04 12:04:54',	NULL,	NULL,	NULL,	NULL),
(8,	3,	1,	'uploads/photos/31512533073.jpg',	'2017-12-06 04:04:33',	'2017-12-06 04:04:33',	NULL,	NULL,	NULL,	NULL),
(9,	3,	2,	'uploads/signatures/31512533073.jpg',	'2017-12-06 04:04:33',	'2017-12-06 04:04:33',	NULL,	NULL,	NULL,	NULL),
(10,	4,	1,	'uploads/photos/41512533299.jpg',	'2017-12-06 04:08:19',	'2017-12-06 04:08:19',	NULL,	NULL,	NULL,	NULL),
(11,	4,	2,	'uploads/signatures/41512533299.jpg',	'2017-12-06 04:08:19',	'2017-12-06 04:08:19',	NULL,	NULL,	NULL,	NULL),
(12,	6,	1,	'uploads/photos/61512535095.jpg',	'2017-12-06 04:38:15',	'2017-12-06 04:38:15',	NULL,	NULL,	NULL,	NULL),
(13,	6,	2,	'uploads/signatures/61512535095.jpg',	'2017-12-06 04:38:15',	'2017-12-06 04:38:15',	NULL,	NULL,	NULL,	NULL),
(14,	7,	3,	'uploads/files/7-3-1512536313.pdf',	'2017-12-06 04:58:33',	'2017-12-06 04:58:33',	NULL,	NULL,	NULL,	NULL),
(15,	9,	1,	'uploads/photos/91512537479.jpg',	'2017-12-06 05:17:59',	'2017-12-06 05:17:59',	NULL,	NULL,	NULL,	NULL),
(16,	9,	2,	'uploads/signatures/91512537479.jpg',	'2017-12-06 05:17:59',	'2017-12-06 05:17:59',	NULL,	NULL,	NULL,	NULL),
(17,	10,	1,	'uploads/photos/101512543583.jpg',	'2017-12-06 06:59:43',	'2017-12-06 06:59:43',	NULL,	NULL,	NULL,	NULL),
(18,	11,	1,	'uploads/photos/111512885248.jpg',	'2017-12-10 05:54:08',	'2017-12-10 05:54:08',	NULL,	NULL,	NULL,	NULL),
(19,	11,	2,	'uploads/signatures/111512885248.jpg',	'2017-12-10 05:54:08',	'2017-12-10 05:54:08',	NULL,	NULL,	NULL,	NULL),
(20,	4109,	11,	'uploads/files/4109-11-1513065428.pdf',	'2017-12-12 07:57:08',	'2017-12-12 07:57:08',	NULL,	NULL,	NULL,	NULL),
(21,	4110,	11,	'uploads/files/4110-11-1513070321.pdf',	'2017-12-12 09:18:41',	'2017-12-12 09:18:41',	NULL,	NULL,	NULL,	NULL),
(22,	4110,	1,	'uploads/photos/41101513070350.jpg',	'2017-12-12 09:19:10',	'2017-12-12 09:19:10',	NULL,	NULL,	NULL,	NULL),
(23,	4110,	13,	'uploads/files/4110-13-1513071963.pdf',	'2017-12-12 09:46:03',	'2017-12-12 09:46:03',	NULL,	NULL,	NULL,	NULL),
(24,	1,	1,	'uploads/photos/11513140230.jpg',	'2017-12-13 04:43:50',	'2017-12-13 04:43:50',	NULL,	NULL,	NULL,	NULL),
(25,	4107,	1,	'uploads/photos/41071513154022.jpg',	'2017-12-13 08:33:42',	'2017-12-13 08:33:42',	NULL,	NULL,	NULL,	NULL),
(26,	3660,	1,	'uploads/photos/41111513161039.jpg',	'2017-12-13 10:30:39',	'2017-12-13 10:30:39',	NULL,	NULL,	NULL,	NULL),
(27,	3660,	2,	'uploads/signatures/41111513161039.png',	'2017-12-13 10:30:39',	'2017-12-13 10:30:39',	NULL,	NULL,	NULL,	NULL),
(28,	4111,	6,	'uploads/files/4111-6-1513161522.jpg',	'2017-12-13 10:38:42',	'2017-12-13 10:38:42',	NULL,	NULL,	NULL,	NULL),
(29,	4111,	7,	'uploads/files/4111-7-1513161549.jpg',	'2017-12-13 10:39:09',	'2017-12-13 10:39:09',	NULL,	NULL,	NULL,	NULL),
(30,	4111,	8,	'uploads/files/4111-8-1513161579.jpg',	'2017-12-13 10:39:39',	'2017-12-13 10:39:39',	NULL,	NULL,	NULL,	NULL),
(31,	4111,	1,	'uploads/files/4111-1-1513161717.JPG',	'2017-12-13 10:41:57',	'2017-12-13 10:41:57',	NULL,	NULL,	NULL,	NULL),
(32,	4111,	3,	'uploads/files/4111-3-1513161828.jpg',	'2017-12-13 10:43:48',	'2017-12-13 10:43:48',	NULL,	NULL,	NULL,	NULL),
(33,	4112,	1,	'uploads/photos/41121513233371.jpg',	'2017-12-14 06:36:11',	'2017-12-14 06:36:11',	NULL,	NULL,	NULL,	NULL),
(34,	4113,	1,	'uploads/photos/41131513234518.jpg',	'2017-12-14 06:55:18',	'2017-12-14 06:55:18',	NULL,	NULL,	NULL,	NULL),
(35,	4113,	1,	'uploads/photos/41131513234632.jpg',	'2017-12-14 06:57:12',	'2017-12-14 06:57:12',	NULL,	NULL,	NULL,	NULL),
(36,	4113,	2,	'uploads/signatures/41131513234659.jpg',	'2017-12-14 06:57:39',	'2017-12-14 06:57:39',	NULL,	NULL,	NULL,	NULL),
(37,	3660,	1,	'uploads/photos/41161513235508.jpg',	'2017-12-14 07:11:48',	'2017-12-14 07:11:48',	NULL,	NULL,	NULL,	NULL),
(38,	3659,	1,	'uploads/photos/41151513236540.jpg',	'2017-12-14 07:29:00',	'2017-12-14 07:29:00',	NULL,	NULL,	NULL,	NULL),
(39,	2730,	1,	'uploads/photos/27301513241812.jpg',	'2017-12-14 08:56:52',	'2017-12-14 08:56:52',	NULL,	NULL,	NULL,	NULL),
(40,	2730,	2,	'uploads/signatures/27301513242285.jpg',	'2017-12-14 09:04:45',	'2017-12-14 09:04:45',	NULL,	NULL,	NULL,	NULL),
(41,	2730,	2,	'uploads/signatures/27301513242901.jpg',	'2017-12-14 09:15:02',	'2017-12-14 09:15:02',	NULL,	NULL,	NULL,	NULL),
(42,	2459,	1,	'uploads/photos/24591513274238.jpg',	'2017-12-14 17:57:19',	'2017-12-14 17:57:19',	NULL,	NULL,	NULL,	NULL)
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `employee_id` = VALUES(`employee_id`), `file_type_id` = VALUES(`file_type_id`), `file_path` = VALUES(`file_path`), `created_at` = VALUES(`created_at`), `updated_at` = VALUES(`updated_at`), `deleted_at` = VALUES(`deleted_at`), `created_by` = VALUES(`created_by`), `updated_by` = VALUES(`updated_by`), `deleted_by` = VALUES(`deleted_by`);

-- 2017-12-17 04:52:04
