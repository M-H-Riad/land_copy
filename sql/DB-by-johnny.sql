CREATE TABLE `lab_parameter_standard_values` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parameter_id` int(10) unsigned DEFAULT NULL,
  `unit_id` int(10) unsigned DEFAULT NULL,
  `bangladesh_ecr_97` double(10,3) DEFAULT NULL,
  `who_2004` double(10,3) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(10) unsigned DEFAULT NULL,
  `updated_by` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

ALTER TABLE `wasa_pims`.`lab_chlorine_demand_test_details` ADD COLUMN `bangladesh_ecr_97` VARCHAR(200) NULL AFTER `test_parameter_unit_id`, ADD COLUMN `who_2004` VARCHAR(200) NULL AFTER `bangladesh_ecr_97`; 

ALTER TABLE `wasa_pims`.`custom_water_sample_test_values` ADD COLUMN `bangladesh_ecr_97` VARCHAR(200) NULL AFTER `custom_water_sample_test_parameter_id`, ADD COLUMN `who_2004` VARCHAR(200) NULL AFTER `bangladesh_ecr_97`; 

-- ============== 30-12-2020 ========================

CREATE TABLE `loan_applications` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int unsigned NOT NULL,
  `pfno` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `loan_category_id` int unsigned NOT NULL,
  `loan_amount` int DEFAULT NULL,
  `max_loan_amount` int DEFAULT NULL,
  `loan_eff_date` date DEFAULT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending' COMMENT 'Pending, Approved, Reject',
  `created_by` int unsigned DEFAULT NULL,
  `updated_by` int unsigned DEFAULT NULL,
  `deleted_by` int unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `loan_approval_histories` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `loan_application_id` int unsigned NOT NULL,
  `loan_approve_id` int unsigned DEFAULT NULL,
  `approver_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved_by` int unsigned DEFAULT NULL,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `loan_status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `loan_approves` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `loan_application_id` int unsigned NOT NULL,
  `approver_type` enum('Witness','Guarantor','HOD','Admin','Committee','AS','DS','Secretary','MD','DMD','DS Admin','LDA','Applicant','Accounts') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `approver_id` int unsigned DEFAULT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending' COMMENT 'Pending, Rejected, Approved',
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `need_reply` tinyint DEFAULT '0' COMMENT '1 = need user reply',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `loan_comments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `loan_application_id` int NOT NULL,
  `loan_approve_id` int DEFAULT NULL,
  `comment_user_type` enum('AS','DS','Admin','MD','DMD','DS Admin','LDA','Secretary','Applicant','Accounts') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment_type` enum('comment','reply') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_by` int NOT NULL,
  `comment_for` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `loan_committees` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int unsigned NOT NULL,
  `user_type` enum('Admin','Committee','AS','DS','Secretary','MD','DMD','DS Admin','LDA','Accounts') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `joined_at` date DEFAULT NULL,
  `end_at` date DEFAULT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_by` int unsigned DEFAULT NULL,
  `deleted_by` int unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ================== 31-12-2020 ============

ALTER TABLE `loan_applications` ADD COLUMN `attachment` VARCHAR(200) NULL AFTER `loan_eff_date`; 

************ need to create folder: uploads/loan_applications ********************

--  ====================== 04-01-2021 ============

ALTER TABLE `loan_approves` CHANGE `approver_type` `approver_type` ENUM('Witness','Guarantor','HOD','Admin','Committee','Office Super','AS','DS','Secretary','MD','DMD','DS Admin','LDA','Applicant','Accounts') CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL; 

ALTER TABLE `loan_comments` CHANGE `comment_user_type` `comment_user_type` ENUM('Office Super','AS','DS','Admin','MD','DMD','DS Admin','LDA','Secretary','Applicant','Accounts') CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci NULL; 

ALTER TABLE `loan_committees` CHANGE `user_type` `user_type` ENUM('Admin','Committee','Office Super','AS','DS','Secretary','MD','DMD','DS Admin','LDA','Accounts') CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL; 

--  ====================== 05-01-2021 ============

ALTER TABLE `loan_approves` ADD COLUMN `step` INT NULL AFTER `loan_application_id`; 

-- ================== 10-01-2021 ==================

ALTER TABLE `loan_applications` ADD COLUMN `witness_1` INT NULL AFTER `max_loan_amount`, ADD COLUMN `witness_2` INT NULL AFTER `witness_1`, ADD COLUMN `guarantor` INT NULL AFTER `witness_2`; 


-- ================== 19-01-2021 =================

CREATE TABLE `loan_office_order_applications` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `loan_office_order_id` int NOT NULL,
  `loan_application_id` int NOT NULL,
  `release_no` int DEFAULT '1',
  `release_percentage` int DEFAULT '25',
  `applied_amount` decimal(10,2) DEFAULT NULL,
  `release_amount` decimal(10,2) DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `loan_office_order_id` (`loan_office_order_id`,`loan_application_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `loan_office_orders` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `loan_session_id` int NOT NULL,
  `memo_no` varchar(100) NOT NULL,
  `generate_date` date NOT NULL,
  `category_amount` decimal(10,2) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL,
  `created_by` int NOT NULL,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `loan_sessions` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `session_year_1` year NOT NULL,
  `session_year_2` year NOT NULL,
  `budget` decimal(12,2) NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL,
  `created_by` int NOT NULL,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;