CREATE TABLE lab_water_sample_table_head (
  id INT(11) NOT NULL AUTO_INCREMENT,
  lab_water_sample_test_id INT(11) NOT NULL,
  table_head VARCHAR(200) NOT NULL,
  PRIMARY KEY (id),
  KEY lab_water_sample_test_id (lab_water_sample_test_id)
) ENGINE=INNODB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4;

CREATE TABLE lab_water_sample_test (
  id INT(11) NOT NULL AUTO_INCREMENT,
  subject_name VARCHAR(500) NOT NULL,
  test_date DATETIME DEFAULT NULL,
  STATUS TINYINT(4) NOT NULL DEFAULT '1',
  created_by INT(11) NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_by INT(11) DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=INNODB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

CREATE TABLE lab_water_sample_test_details (
  id INT(11) NOT NULL AUTO_INCREMENT,
  lab_water_sample_test_id INT(11) NOT NULL,
  parameter_id INT(11) NOT NULL DEFAULT '0',
  unit_id INT(11) NOT NULL DEFAULT '0',
  bangladesh_ecr_97 VARCHAR(200) DEFAULT NULL,
  who_2004 VARCHAR(200) DEFAULT NULL,
  test_1 VARCHAR(200) DEFAULT NULL,
  test_2 VARCHAR(200) DEFAULT NULL,
  test_3 VARCHAR(200) DEFAULT NULL,
  test_4 VARCHAR(200) DEFAULT NULL,
  test_5 VARCHAR(200) DEFAULT NULL,
  test_6 VARCHAR(200) DEFAULT NULL,
  test_7 VARCHAR(200) DEFAULT NULL,
  test_8 VARCHAR(200) DEFAULT NULL,
  test_9 VARCHAR(200) DEFAULT NULL,
  test_10 VARCHAR(200) DEFAULT NULL,
  STATUS TINYINT(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (id),
  KEY parameter_id (parameter_id),
  KEY unit_id (unit_id),
  KEY lab_water_sample_test_id (lab_water_sample_test_id)
) ENGINE=INNODB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

CREATE TABLE lab_water_quality_analysis (
  id int(11) NOT NULL AUTO_INCREMENT,
  subject_name varchar(500) NOT NULL,
  test_date datetime NOT NULL,
  status tinyint(4) NOT NULL DEFAULT '1',
  created_by int(11) NOT NULL,
  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_by int(11) DEFAULT NULL,
  updated_at timestamp NULL DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE lab_water_quality_analysis_details (
  id int(11) NOT NULL AUTO_INCREMENT,
  lab_water_quality_analysis_id int(11) NOT NULL,
  sampling_date date NOT NULL,
  source_wss_id int(11) DEFAULT NULL,
  source varchar(500) DEFAULT NULL,
  address_wss_id int(11) DEFAULT NULL,
  address varchar(500) DEFAULT NULL,
  test_1 varchar(200) DEFAULT NULL,
  test_2 varchar(200) DEFAULT NULL,
  test_3 varchar(200) DEFAULT NULL,
  test_4 varchar(200) DEFAULT NULL,
  test_5 varchar(200) DEFAULT NULL,
  test_6 varchar(200) DEFAULT NULL,
  test_7 varchar(200) DEFAULT NULL,
  test_8 varchar(200) DEFAULT NULL,
  test_9 varchar(200) DEFAULT NULL,
  test_10 varchar(200) DEFAULT NULL,
  test_11 varchar(200) DEFAULT NULL,
  test_12 varchar(200) DEFAULT NULL,
  test_13 varchar(200) DEFAULT NULL,
  test_14 varchar(200) DEFAULT NULL,
  test_15 varchar(200) DEFAULT NULL,
  test_16 varchar(200) DEFAULT NULL,
  test_17 varchar(200) DEFAULT NULL,
  test_18 varchar(200) DEFAULT NULL,
  test_19 varchar(200) DEFAULT NULL,
  test_20 varchar(200) DEFAULT NULL,
  test_21 varchar(200) DEFAULT NULL,
  test_22 varchar(200) DEFAULT NULL,
  test_23 varchar(200) DEFAULT NULL,
  test_24 varchar(200) DEFAULT NULL,
  status tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE lab_water_quality_analysis_head (
  id int(11) NOT NULL AUTO_INCREMENT,
  lab_water_quality_analysis_id int(11) NOT NULL,
  head_parameter_id int(10) NOT NULL DEFAULT '0',
  parameter_unit_id int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

**************** 30-04-2019 *-**********************

ALTER TABLE `wasa_pims`.`lab_water_quality_analysis_details` CHANGE `source_wss_id` `source_wss` INT(11) NULL, CHANGE `address_wss_id` `address_wss` INT(11) NULL;

ALTER TABLE `wasa_pims`.`lab_water_quality_analysis_details` CHANGE `source_wss` `source_wss` VARCHAR(500) NULL, CHANGE `address_wss` `address_wss` VARCHAR(500) NULL;

ALTER TABLE `wasa_pims`.`lab_water_quality_analysis_details` DROP COLUMN `source`, DROP COLUMN `address`;

ALTER TABLE `wasa_pims`.`lab_water_quality_analysis_details` ADD COLUMN `bangladesh_ecr_97` VARCHAR(200) NULL AFTER `status`, ADD COLUMN `who_2004` VARCHAR(200) NULL AFTER `bangladesh_ecr_97`;

CREATE TABLE `lab_bottle_plant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_name` varchar(500) NOT NULL,
  `test_date` datetime NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;


CREATE TABLE `lab_bottle_plant_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lab_bottle_plant_id` int(11) NOT NULL,
  `sampling_date` date NOT NULL,
  `source_wss` varchar(500) DEFAULT NULL,
  `address_wss` varchar(500) DEFAULT NULL,
  `test_1` varchar(200) DEFAULT NULL,
  `test_2` varchar(200) DEFAULT NULL,
  `test_3` varchar(200) DEFAULT NULL,
  `test_4` varchar(200) DEFAULT NULL,
  `test_5` varchar(200) DEFAULT NULL,
  `test_6` varchar(200) DEFAULT NULL,
  `test_7` varchar(200) DEFAULT NULL,
  `test_8` varchar(200) DEFAULT NULL,
  `test_9` varchar(200) DEFAULT NULL,
  `test_10` varchar(200) DEFAULT NULL,
  `test_11` varchar(200) DEFAULT NULL,
  `test_12` varchar(200) DEFAULT NULL,
  `bangladesh_ecr_97` varchar(200) DEFAULT NULL,
  `who_2004` varchar(200) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;


CREATE TABLE `lab_bottle_plant_head` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lab_bottle_plant_id` int(11) NOT NULL,
  `head_parameter_id` int(10) NOT NULL DEFAULT '0',
  `parameter_unit_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;


CREATE TABLE `lab_saidabad_plant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_name` varchar(500) NOT NULL,
  `test_date` datetime NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;


CREATE TABLE `lab_saidabad_plant_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lab_saidabad_plant_id` int(11) NOT NULL,
  `sampling_date` date NOT NULL,
  `source_wss` varchar(500) DEFAULT NULL,
  `address_wss` varchar(500) DEFAULT NULL,
  `test_1` varchar(200) DEFAULT NULL,
  `test_2` varchar(200) DEFAULT NULL,
  `test_3` varchar(200) DEFAULT NULL,
  `test_4` varchar(200) DEFAULT NULL,
  `test_5` varchar(200) DEFAULT NULL,
  `test_6` varchar(200) DEFAULT NULL,
  `test_7` varchar(200) DEFAULT NULL,
  `test_8` varchar(200) DEFAULT NULL,
  `test_9` varchar(200) DEFAULT NULL,
  `test_10` varchar(200) DEFAULT NULL,
  `test_11` varchar(200) DEFAULT NULL,
  `test_12` varchar(200) DEFAULT NULL,
  `bangladesh_ecr_97` varchar(200) DEFAULT NULL,
  `who_2004` varchar(200) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;


CREATE TABLE `lab_saidabad_plant_head` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lab_saidabad_plant_id` int(11) NOT NULL,
  `head_parameter_id` int(10) NOT NULL DEFAULT '0',
  `parameter_unit_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;


******************* 05-05-2019 ***********************

CREATE TABLE `lab_tests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `wasa_pims`.`lab_tests` (`name`) VALUES ('Water Quality Analysis Report');
INSERT INTO `wasa_pims`.`lab_tests` (`name`) VALUES ('Daily Water Quality Analysis');

CREATE TABLE `lab_test_authors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lab_test_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `designation` varchar(200) NOT NULL,
  `department` varchar(200) DEFAULT 'Dhaka WASA',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `lab_water_quality_report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_name` varchar(500) NULL,
  `sample_receive_date` date DEFAULT NULL,
  `test_date` datetime DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `lab_water_quality_report_head` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lab_water_quality_report_id` int(11) NOT NULL,
  `table_head` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lab_water_quality_report_id` (`lab_water_quality_report_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `lab_water_quality_report_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lab_water_quality_report_id` int(11) NOT NULL,
  `parameter_id` int(11) NOT NULL DEFAULT '0',
  `unit_id` int(11) NOT NULL DEFAULT '0',
  `bangladesh_ecr_97` varchar(200) DEFAULT NULL,
  `who_2004` varchar(200) DEFAULT NULL,
  `test_1` varchar(200) DEFAULT NULL,
  `test_2` varchar(200) DEFAULT NULL,
  `test_3` varchar(200) DEFAULT NULL,
  `test_4` varchar(200) DEFAULT NULL,
  `test_5` varchar(200) DEFAULT NULL,
  `test_6` varchar(200) DEFAULT NULL,
  `analysis_method` varchar(200) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `parameter_id` (`parameter_id`),
  KEY `unit_id` (`unit_id`),
  KEY `lab_water_quality_report_id` (`lab_water_quality_report_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
-- ================== Update Done =========================

-- ============== Updated in Demo not Live =====================================

-- permission add 21-08-2019 --
INSERT INTO `permissions` (`module_id`, `name`, `display_name`, `description`, `created_at`, `updated_at`)
VALUES ('1', 'prl_retirement', 'PRL & Retirement ', 'PRL & Retirement  List', now(), NULL);

INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ('106', '1');

-- download_excel table add 21-08-2019 ---
CREATE TABLE `download_excel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(128) NOT NULL,
  `url` varchar(191) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

-- ============== Updated in Demo not Live =====================================

-- ===================== 2019-09-03 ========================

ALTER TABLE `payroll_employees`
ADD `office_id` int(11) NULL AFTER `month_id`;

UPDATE `employees` SET
`pfno` = '2134'
WHERE `id` = '1003';
UPDATE `employees` SET
`pfno` = '006703'
WHERE `id` = '5044';
UPDATE `employees` SET
`pfno` = '6703'
WHERE `id` = '5116';
UPDATE `employees` SET
`status` = 'Continue'
WHERE `id` = '3413';
-- ============== Updated in Demo not Live =====================================

---local ----
ALTER TABLE `employee_payroll_settings`
ADD `titas_gas` tinyint(1) NULL DEFAULT '0' AFTER `gas_alw`,
ADD `it_arrear_ded` float(10,2) NULL DEFAULT '0.00' AFTER `other_ded`;
ALTER TABLE `employee_payroll_settings`
ADD `ws_ded` tinyint(1) NULL DEFAULT '0' AFTER `h_rent`;
ALTER TABLE `employee_childrens`
ADD `edu_alw` tinyint NULL DEFAULT '0' AFTER `employee_id`;
ALTER TABLE `payroll_employees`
ADD `it_arrear_ded` float NOT NULL DEFAULT '0' AFTER `it_ded`;
ALTER TABLE `payroll_employees_history`
ADD `it_arrear_ded` float NOT NULL DEFAULT '0' AFTER `it_ded`;
ALTER TABLE `payroll_employees_history`
ADD `office_id` int(11) NULL AFTER `month_id`;
ALTER TABLE `employees`
ADD `charge_allowance_effective` date NULL AFTER `current_joining_date`;
UPDATE `payroll_settings` SET
`grade` = '1',
`grade_max` = '20',
`comments` = '0.50% for grade 1 to 20'
WHERE `id` = '26';
ALTER TABLE `employee_payroll_settings`
ADD `pf_inttr` decimal(10,2) NULL AFTER `pf_loan`,
ADD `pc_inttr` decimal(10,2) NULL AFTER `pc_loan`,
ADD `vhcl_loan` decimal(10,2) NULL AFTER `pc_inttr`,
ADD `vhcl_inttr` decimal(10,2) NULL AFTER `vhcl_loan`;

-- employee_payroll_settings update --
ALTER TABLE `employee_payroll_settings`
ADD `spl_pay` tinyint(1) NULL DEFAULT '0' AFTER `tp_apply_month`,
CHANGE `sp_apply_month` `spl_pay_end` varchar(10) COLLATE 'utf8_unicode_ci' NULL AFTER `spl_pay_amount`,
ADD `personal_pay` tinyint(1) NULL DEFAULT '0' AFTER `prv_fund_type`,
ADD `per_pay_end` varchar(10) COLLATE 'utf8_unicode_ci' NULL AFTER `personal_pay`,
ADD `transport_ded` tinyint(1) NULL DEFAULT '0' AFTER `stove`,
ADD `transport_end` varchar(10) COLLATE 'utf8_unicode_ci' NULL AFTER `transport_ded`,
ADD `other_allowance` tinyint(1) NULL DEFAULT '0' AFTER `dearness`,
ADD `other_alw_end` varchar(10) COLLATE 'utf8_unicode_ci' NULL AFTER `other_allowance`,
ADD `salary_arrears` tinyint(1) NULL DEFAULT '0' AFTER `other_alw`,
ADD `salary_arr_end` varchar(10) COLLATE 'utf8_unicode_ci' NULL AFTER `salary_arrears`,
ADD `hb_lone_refund` tinyint(1) NULL DEFAULT '0' AFTER `med_pay_amount`,
ADD `hb_refund_end` varchar(10) COLLATE 'utf8_unicode_ci' NULL AFTER `hb_lone_refund`,
ADD `vehicle_refund` tinyint(1) NULL DEFAULT '0' AFTER `hb_refund`,
ADD `vhl_refund_end` varchar(10) COLLATE 'utf8_unicode_ci' NULL AFTER `vehicle_refund`,
ADD `salary_ded` tinyint(1) NULL DEFAULT '0' AFTER `depu_arr`,
ADD `sal_ded_end` varchar(10) COLLATE 'utf8_unicode_ci' NULL AFTER `salary_ded`,
ADD `other_deduction` tinyint(1) NULL DEFAULT '0' AFTER `sal_ded`,
ADD `other_ded_end` varchar(10) COLLATE 'utf8_unicode_ci' NULL AFTER `other_deduction`,
ADD `it_arr_ded` tinyint(1) NULL DEFAULT '0' AFTER `other_ded`,
ADD `it_arrear_ded_end` varchar(10) COLLATE 'utf8_unicode_ci' NULL AFTER `it_arr_ded`,
ADD `house_rent_arr` tinyint(1) NULL DEFAULT '0' AFTER `it_arrear_ded`,
ADD `hr_arr_end` varchar(10) COLLATE 'utf8_unicode_ci' NULL AFTER `house_rent_arr`,
ADD `pf_fund_refund` tinyint(1) NULL DEFAULT '0' AFTER `hr_arr`,
ADD `pf_refund_end` varchar(10) COLLATE 'utf8_unicode_ci' NULL AFTER `pf_fund_refund`,
ADD `pf_loan_ded` tinyint(1) NULL DEFAULT '0' AFTER `it_ded`,
ADD `pf_loan_ded_end` varchar(10) COLLATE 'utf8_unicode_ci' NULL AFTER `pf_loan_ded`,
CHANGE `pf_loan` `pf_loan` float NULL AFTER `pf_loan_ded_end`,
ADD `pf_interest_ded` tinyint(1) NULL DEFAULT '0' AFTER `pf_loan`,
ADD `pf_inttr_ded_end` varchar(10) COLLATE 'utf8_unicode_ci' NULL AFTER `pf_interest_ded`,
ADD `hb_loan_ded` tinyint(1) NULL DEFAULT '0' AFTER `pf_inttr`,
ADD `hb_loan_ded_end` varchar(10) COLLATE 'utf8_unicode_ci' NULL AFTER `hb_loan_ded`,
CHANGE `hb_loan` `hb_loan` float NULL AFTER `hb_loan_ded_end`,
ADD `hb_interest_ded` tinyint(1) NULL DEFAULT '0' AFTER `hb_loan`,
ADD `hb_inttr_ded_end` varchar(10) COLLATE 'utf8_unicode_ci' NULL AFTER `hb_interest_ded`,
CHANGE `hb_inttr` `hb_inttr` float NULL AFTER `hb_inttr_ded_end`,
ADD `pc_loan_ded` tinyint(1) NULL DEFAULT '0' AFTER `hb_inttr`,
ADD `pc_loan_ded_end` varchar(10) COLLATE 'utf8_unicode_ci' NULL AFTER `pc_loan_ded`,
CHANGE `pc_loan` `pc_loan` float NULL AFTER `pc_loan_ded_end`,
ADD `pc_interest_ded` tinyint(1) NULL DEFAULT '0' AFTER `pc_loan`,
ADD `pc_inttr_ded_end` varchar(10) COLLATE 'utf8_unicode_ci' NULL AFTER `pc_interest_ded`,
CHANGE `pc_inttr` `pc_inttr` float NULL AFTER `pc_inttr_ded_end`,
ADD `vhcl_loan_ded` tinyint(1) NULL DEFAULT '0' AFTER `pc_inttr`,
ADD `vhcl_loan_ded_end` varchar(10) COLLATE 'utf8_unicode_ci' NULL AFTER `vhcl_loan_ded`,
CHANGE `vhcl_loan` `vhcl_loan` float NULL AFTER `vhcl_loan_ded_end`,
ADD `vhcl_interest_ded` tinyint(1) NULL DEFAULT '0' AFTER `vhcl_loan`,
ADD `vhcl_inttr_ded_end` varchar(10) COLLATE 'utf8_unicode_ci' NULL AFTER `vhcl_interest_ded`,
CHANGE `vhcl_inttr` `vhcl_inttr` float NULL AFTER `vhcl_inttr_ded_end`;
ALTER TABLE `employee_payroll_settings`
DROP `dearness`,
DROP `med_pay_amount`,
ADD `vehicle_allowance` tinyint(1) NULL DEFAULT '0' AFTER `vhl_refund`,
ADD `vhl_alw_end` varchar(10) COLLATE 'utf8_unicode_ci' NULL AFTER `vehicle_allowance`,
DROP `depu_arr`;

--16-10-2019
UPDATE `payroll_heads` SET
`title` = 'Vehicle Allowance',
`db_field` = 'vhl_alw'
WHERE `id` = '22';
UPDATE `payroll_heads` SET
`db_field` = 'other_alw'
WHERE `id` = '23';
UPDATE `payroll_heads` SET
`active` = '0'
WHERE `id` = '7';
INSERT INTO `payroll_heads` (`title`, `type`, `in_short`, `db_field`, `order`, `active`, `is_deduction`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`)
VALUES ('Income Tax Arrears Deduction', 'deduction', NULL, 'it_arrear_ded', '309', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `payroll_heads` (`title`, `type`, `in_short`, `db_field`, `order`, `active`, `is_deduction`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`)
VALUES ('Benevolent Fund', 'deduction', NULL, 'ben_fund', '288', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL);
UPDATE `payroll_heads` SET
`active` = '0'
WHERE `id` = '24';
UPDATE `payroll_heads` SET
`active` = '0'
WHERE `id` = '315';
UPDATE `payroll_heads` SET
`active` = '0'
WHERE `id` = '314';
---local ----
php artisan migrate --path=database/migrations/bonus
php artisan migrate --path=database/migrations/income_tax
php artisan migrate --path=database/migrations/payroll
php artisan migrate --path=database/migrations/payroll_arrears_deduction_off_alert

-- ===================== 2019-09-26 ========================

CREATE TABLE `payrolls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `pfno` VARCHAR(64) NOT NULL,
  `bank_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `office_id` int(11) DEFAULT NULL,
  `designation` int(11) DEFAULT NULL,
  `designation_ranking` int(11) NULL,
  `scale_id` int(11) DEFAULT NULL,
  `grade` int(11) DEFAULT NULL,
  `basic_pay` float(10,2) NOT NULL DEFAULT '0',
  `tech_pay` float(10,2) DEFAULT '0',
  `spl_pay` float(10,2) DEFAULT '0',
  `house_alw` float(10,2) DEFAULT '0',
  `med_alw` float(10,2) DEFAULT '0',
  `f_bonus` float(10,2) DEFAULT '0',
  `conv_alw` float(10,2) NOT NULL DEFAULT '0',
  `wash_alw` float(10,2) NOT NULL DEFAULT '0',
  `chrg_alw` float(10,2) NOT NULL DEFAULT '0',
  `gas_alw` float(10,2) NOT NULL DEFAULT '0',
  `ws_alw` float(10,2) NOT NULL DEFAULT '0',
  `per_pay` float(10,2) NOT NULL DEFAULT '0',
  `dearness` float(10,2) NOT NULL DEFAULT '0',
  `tiffin_alw` float(10,2) NOT NULL DEFAULT '0',
  `edu_alw` float(10,2) NOT NULL DEFAULT '0',
  `pf_refund` float(10,2) NOT NULL DEFAULT '0',
  `hb_refund` float(10,2) NOT NULL DEFAULT '0',
  `vhl_refund` float(10,2) NOT NULL DEFAULT '0',
  `salary_arr` float(10,2) NOT NULL DEFAULT '0',
  `hr_arr` float(10,2) NOT NULL DEFAULT '0',
  `depu_arr` float(10,2) NOT NULL DEFAULT '0',
  `vhl_alw` float(10,2) NOT NULL DEFAULT '0',
  `other_alw` float(10,2) DEFAULT '0',
  `prv_fund` float(10,2) NOT NULL DEFAULT '0',
  `pf_loan` float(10,2) NOT NULL DEFAULT '0',
  `pf_inttr` float(10,2) NOT NULL DEFAULT '0',
  `hr_main` float(10,2) NOT NULL DEFAULT '0',
  `hb_loan` float(10,2) NOT NULL DEFAULT '0',
  `h_rent` float(10,2) NOT NULL DEFAULT '0',
  `welfare` float(10,2) NOT NULL DEFAULT '0',
  `trusty_fund` float(10,2) NOT NULL DEFAULT '0',
  `ben_fund` float(10,2) NOT NULL DEFAULT '0',
  `gr_insu` float(10,2) NOT NULL DEFAULT '0',
  `elec_bill` float(10,2) NOT NULL DEFAULT '0',
  `pc_inttr` float(10,2) NOT NULL DEFAULT '0',
  `ws_ded` float(10,2) NOT NULL DEFAULT '0',
  `titas_gas` float(10,2) NOT NULL DEFAULT '0',
  `water_gov` float(10,2) NOT NULL DEFAULT '0',
  `transport` float(10,2) NOT NULL DEFAULT '0',
  `pf_refund_ded` float(10,2) NOT NULL DEFAULT '0',
  `vhcl_loan` float(10,2) NOT NULL DEFAULT '0',
  `vhcl_inttr` float(10,2) NOT NULL DEFAULT '0',
  `hb_inttr` float(10,2) NOT NULL DEFAULT '0',
  `it_ded` float(10,2) NOT NULL DEFAULT '0',
  `it_arrear_ded` float(10,2) NOT NULL DEFAULT '0',
  `dps_fee` float(10,2) NOT NULL DEFAULT '0',
  `union_sub` float(10,2) NOT NULL DEFAULT '0',
  `deas_fee` float(10,2) NOT NULL DEFAULT '0',
  `dhak_usf` float(10,2) NOT NULL DEFAULT '0',
  `sal_ded` float(10,2) NOT NULL DEFAULT '0',
  `pc_loan` float(10,2) NOT NULL DEFAULT '0',
  `other_ded` float(10,2) NOT NULL DEFAULT '0',
  `day_sal` float(10,2) NOT NULL DEFAULT '0',
  `rev_stamp` float(10,2) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `bank_id` (`bank_id`),
  KEY `branch_id` (`branch_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `payroll_employees`
CHANGE `basic_pay` `basic_pay` float(10,2) NOT NULL DEFAULT '0' AFTER `office_id`,
CHANGE `tech_pay` `tech_pay` float(10,2) NULL DEFAULT '0' AFTER `basic_pay`,
CHANGE `spl_pay` `spl_pay` float(10,2) NULL DEFAULT '0' AFTER `tech_pay`,
CHANGE `house_alw` `house_alw` float(10,2) NULL DEFAULT '0' AFTER `spl_pay`,
CHANGE `med_alw` `med_alw` float(10,2) NULL DEFAULT '0' AFTER `house_alw`,
CHANGE `f_bonus` `f_bonus` float(10,2) NULL DEFAULT '0' AFTER `med_alw`,
CHANGE `conv_alw` `conv_alw` float(10,2) NOT NULL DEFAULT '0' AFTER `f_bonus`,
CHANGE `wash_alw` `wash_alw` float(10,2) NOT NULL DEFAULT '0' AFTER `conv_alw`,
CHANGE `chrg_alw` `chrg_alw` float(10,2) NOT NULL DEFAULT '0' AFTER `wash_alw`,
CHANGE `gas_alw` `gas_alw` float(10,2) NOT NULL DEFAULT '0' AFTER `chrg_alw`,
CHANGE `ws_alw` `ws_alw` float(10,2) NOT NULL DEFAULT '0' AFTER `gas_alw`,
CHANGE `per_pay` `per_pay` float(10,2) NOT NULL DEFAULT '0' AFTER `ws_alw`,
CHANGE `dearness` `dearness` float(10,2) NOT NULL DEFAULT '0' AFTER `per_pay`,
CHANGE `tiffin_alw` `tiffin_alw` float(10,2) NOT NULL DEFAULT '0' AFTER `dearness`,
CHANGE `edu_alw` `edu_alw` float(10,2) NOT NULL DEFAULT '0' AFTER `tiffin_alw`,
CHANGE `pf_refund` `pf_refund` float(10,2) NOT NULL DEFAULT '0' AFTER `edu_alw`,
CHANGE `hb_refund` `hb_refund` float(10,2) NOT NULL DEFAULT '0' AFTER `pf_refund`,
CHANGE `vhl_refund` `vhl_refund` float(10,2) NOT NULL DEFAULT '0' AFTER `hb_refund`,
CHANGE `salary_arr` `salary_arr` float(10,2) NOT NULL DEFAULT '0' AFTER `vhl_refund`,
CHANGE `hr_arr` `hr_arr` float(10,2) NOT NULL DEFAULT '0' AFTER `salary_arr`,
CHANGE `depu_arr` `depu_arr` float(10,2) NOT NULL DEFAULT '0' AFTER `hr_arr`,
CHANGE `vhl_alw` `vhl_alw` float(10,2) NOT NULL DEFAULT '0' AFTER `depu_arr`,
CHANGE `other_alw` `other_alw` float(10,2) NULL DEFAULT '0' AFTER `vhl_alw`,
CHANGE `gross_pay` `gross_pay` float(11,2) NULL DEFAULT '0' AFTER `other_alw`,
CHANGE `prv_fund` `prv_fund` float(10,2) NOT NULL DEFAULT '0' AFTER `gross_pay`,
CHANGE `pf_loan` `pf_loan` float(10,2) NOT NULL DEFAULT '0' AFTER `prv_fund`,
CHANGE `pf_inttr` `pf_inttr` float(10,2) NOT NULL DEFAULT '0' AFTER `pf_loan`,
CHANGE `hr_main` `hr_main` float(10,2) NOT NULL DEFAULT '0' AFTER `pf_inttr`,
CHANGE `hb_loan` `hb_loan` float(10,2) NOT NULL DEFAULT '0' AFTER `hr_main`,
CHANGE `h_rent` `h_rent` float(10,2) NOT NULL DEFAULT '0' AFTER `hb_loan`,
CHANGE `welfare` `welfare` float(10,2) NOT NULL DEFAULT '0' AFTER `h_rent`,
CHANGE `trusty_fund` `trusty_fund` float(10,2) NOT NULL DEFAULT '0' AFTER `welfare`,
CHANGE `ben_fund` `ben_fund` float(10,2) NOT NULL DEFAULT '0' AFTER `trusty_fund`,
CHANGE `gr_insu` `gr_insu` float(10,2) NOT NULL DEFAULT '0' AFTER `ben_fund`,
CHANGE `elec_bill` `elec_bill` float(10,2) NOT NULL DEFAULT '0' AFTER `gr_insu`,
CHANGE `pc_inttr` `pc_inttr` float(10,2) NOT NULL DEFAULT '0' AFTER `elec_bill`,
CHANGE `ws_ded` `ws_ded` float(10,2) NOT NULL DEFAULT '0' AFTER `pc_inttr`,
CHANGE `titas_gas` `titas_gas` float(10,2) NOT NULL DEFAULT '0' AFTER `ws_ded`,
CHANGE `water_gov` `water_gov` float(10,2) NOT NULL DEFAULT '0' AFTER `titas_gas`,
CHANGE `transport` `transport` float(10,2) NOT NULL DEFAULT '0' AFTER `water_gov`,
CHANGE `pf_refund_ded` `pf_refund_ded` float(10,2) NOT NULL DEFAULT '0' AFTER `transport`,
CHANGE `vhcl_loan` `vhcl_loan` float(10,2) NOT NULL DEFAULT '0' AFTER `pf_refund_ded`,
CHANGE `vhcl_inttr` `vhcl_inttr` float(10,2) NOT NULL DEFAULT '0' AFTER `vhcl_loan`,
CHANGE `hb_inttr` `hb_inttr` float(10,2) NOT NULL DEFAULT '0' AFTER `vhcl_inttr`,
CHANGE `it_ded` `it_ded` float(10,2) NOT NULL DEFAULT '0' AFTER `hb_inttr`,
CHANGE `it_arrear_ded` `it_arrear_ded` float(10,2) NOT NULL DEFAULT '0' AFTER `it_ded`,
CHANGE `dps_fee` `dps_fee` float(10,2) NOT NULL DEFAULT '0' AFTER `it_arrear_ded`,
CHANGE `union_sub` `union_sub` float(10,2) NOT NULL DEFAULT '0' AFTER `dps_fee`,
CHANGE `deas_fee` `deas_fee` float(10,2) NOT NULL DEFAULT '0' AFTER `union_sub`,
CHANGE `dhak_usf` `dhak_usf` float(10,2) NOT NULL DEFAULT '0' AFTER `deas_fee`,
CHANGE `sal_ded` `sal_ded` float(10,2) NOT NULL DEFAULT '0' AFTER `dhak_usf`,
CHANGE `pc_loan` `pc_loan` float(10,2) NOT NULL DEFAULT '0' AFTER `sal_ded`,
CHANGE `other_ded` `other_ded` float(10,2) NOT NULL DEFAULT '0' AFTER `pc_loan`,
CHANGE `day_sal` `day_sal` float(10,2) NOT NULL DEFAULT '0' AFTER `other_ded`,
CHANGE `total_ded` `total_ded` float(11,2) NOT NULL DEFAULT '0' AFTER `day_sal`,
CHANGE `rev_stamp` `rev_stamp` float(10,2) NOT NULL DEFAULT '0' AFTER `total_ded`,
CHANGE `net_payable` `net_payable` float(11,2) NOT NULL DEFAULT '0' AFTER `rev_stamp`;


ALTER TABLE `employees`
ADD `disabled` varchar(100) COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT 'No' AFTER `freedom_fighter`,
ADD `disabled_child` varchar(100) COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT 'No' AFTER `disabled`;

--all update to live and demo server ---
php artisan migrate --path=database/migrations/other_allowance

UPDATE `employees` SET
`status` = 'Dead'
WHERE ((`pfno` = '1107') OR (`pfno` = '1776') OR (`pfno` = '2186')  OR (`pfno` = '2240') OR (`pfno` = '2261') OR (`pfno` = '2679') OR (`pfno` = '3091') OR (`pfno` = 'AW4334') OR (`pfno` = '3809'));

UPDATE `employees` SET
`status` = 'Dead'
WHERE ((`pfno` = '4997') OR (`pfno` = '6198') OR (`pfno` = '2693')  OR (`pfno` = '1400') OR (`pfno` = '1121') OR (`pfno` = '1275') OR (`pfno` = '1880') OR (`pfno` = '1772')OR (`pfno` = '2644') OR (`pfno` = '6318') OR (`pfno` = '6180') OR (`pfno` = '1491') OR (`pfno` = '6604') OR (`pfno` = '2154'));

-- ===================== 09-01-2020 Johnny(update in demo) ====================

ALTER TABLE `custom_water_sample_tests`
ADD COLUMN `title_1` VARCHAR(200) NULL AFTER `id`,
ADD COLUMN `title_2` VARCHAR(200) NULL AFTER `title_1`,
ADD COLUMN `title_3` VARCHAR(200) NULL AFTER `title_2`,
ADD COLUMN `objective` VARCHAR(255) NULL AFTER `title_3`,
ADD COLUMN `note` VARCHAR(255) NULL AFTER `objective`;

--all  live  13-01-2020 --

INSERT INTO `permissions` (`module_id`, `name`, `display_name`, `description`, `created_at`, `updated_at`)
VALUES ('7', 'payroll_setting_create', 'Payroll Setting Create', 'Payroll Setting Create', now(), NULL)
,('7', 'payroll_setting_update', 'Payroll Setting Update', 'Payroll Setting Update', now(), NULL)
,('7', 'create_payroll_month', ' Salary Month Create', 'Create Payroll Salary Month fot generate Salary', now(), NULL)
,('7', 'generate_salary', 'Salary Generate', 'Generate Monthly Salary', now(), NULL)
,('7', 'confirm_salary', 'Salary Confirm', 'Confirm Monthly Salary', now(), NULL)
,('7', 'salary_reconciliation', 'Salary Reconciliation  Download CSV', 'Salary Reconciliation  Download CSV', now(), NULL)
,('7', 'download_monthly_salary_csv', 'Salary Download CSV', 'Monthly Salary Download in CSV', now(), NULL)
,('7', 'download_bank_report_csv', 'Salary Bank Report Download CSV', 'Monthly Salary Bank Report Download in CSV', now(), NULL)
,('7', 'download_bank_report_pdf', 'Salary Bank Report Download PDF', 'Monthly Salary Bank Report Download in PDF', now(), NULL)
,('7', 'download_total_summery', 'Salary Total Summery Download PDF', 'Monthly Salary Total Summery Download in PDF', now(), NULL)
,('7', 'download_group_summery', 'Salary Group Summery Download PDF', 'Monthly Salary  Group wise Total Summery Download in PDF', now(), NULL)
,('7', 'download_all_department_summery', 'Salary All Department Summery Download PDF', 'All Department Summery Download in PDF', now(), NULL)
,('7', 'download_department_report', 'Salary Department Report Download PDF', 'Department wise Report Download in PDF', now(), NULL)
,('7', 'download_festival_bonus_csv', 'Festival Bonus Download CSV', 'Festival Bonus Download in CSV', now(), NULL)
,('7', 'download_income_tax_summery_monthly', 'Income Tax Summery Download PDF', 'Income Tax Summery Download in PDF', now(), NULL)
,('7', 'salary_report', 'Salary Report (Individual) Download PDF', 'Salary Report (Individual) Download PDF', now(), NULL)
,('7', 'income_tax_report', 'Income Tax Report Download PDF', 'Income Tax Report Download PDF', now(), NULL)
,('7', 'income_tax_report_info_update', 'Income Tax Report Information Update', 'Income Tax Report Information Update', now(), NULL)
,('7', 'manage_salary_increment', 'Manage Salary Increment', 'Salary Increment Yearly', now(), NULL)
,('7', 'manage_payroll_details', 'Manage Payroll Details', 'Manage Payroll Details', now(), NULL)
,('7', 'manage_bonus_setting', 'Manage Bonus Setting', 'Manage  Bonus Setting', now(), NULL)
,('7', 'bonus_setting_create', 'Bonus Setting Create', 'Bonus Setting Create', now(), NULL)
,('7', 'bonus_setting_update', 'Bonus Setting Update', 'Bonus Setting Update', now(), NULL)
,('7', 'manage_overtime', 'Overtime Manage', 'Manage Overtime', now(), NULL)
,('7', 'create_overtime', 'Overtime Create', 'Create Overtime', now(), NULL)
,('7', 'edit_overtime', 'Overtime Edit', 'Edit Overtime', now(), NULL)
,('7', 're_generate_overtime', 'Overtime Re-Generate', 'Re-Generate Overtime', now(), NULL)
,('7', 'confirm_overtime', 'Overtime Confirm', 'Confirm Overtime', now(), NULL)
,('7', 'download_overtime_department_report', 'Overtime Department Report and Summery Download PDF', 'Overtime Department wise Report Download in PDF', now(), NULL)
,('7', 'manage_night_allowance', 'Night Allowance Manage', 'Night Allowance Manage', now(), NULL)
,('7', 'create_night_allowance', 'Night Allowance  Create', 'Create Night Allowance ', now(), NULL)
,('7', 'edit_night_allowance', 'Night Allowance  Edit', 'Edit Night Allowance ', now(), NULL)
,('7', 're_generate_night_allowance', 'Night Allowance  Re-Generate', 'Re-Generate Night Allowance ', now(), NULL)
,('7', 'confirm_night_allowance', 'Night Allowance  Confirm', 'Confirm Night Allowance ', now(), NULL)
,('7', 'download_night_allowance_department_report', 'Night Allowance  Department Report and Summery  Download PDF', 'Night Allowance  Department wise Report Download in PDF', now(), NULL)
,('7', 'manage_ifter_bill', 'Ifter Bill Manage', 'Ifter Bill Manage', now(), NULL)
,('7', 'create_ifter_bill', 'Ifter Bill  Create', 'Create Ifter Bill ', now(), NULL)
,('7', 'edit_ifter_bill', 'Ifter Bill  Edit', 'Edit Ifter Bill ', now(), NULL)
,('7', 're_generate_ifter_bill', 'Ifter Bill  Re-Generate', 'Re-Generate Ifter Bill ', now(), NULL)
,('7', 'confirm_ifter_bill', 'Ifter Bill  Confirm', 'Confirm Ifter Bill ', now(), NULL)
,('7', 'download_ifter_bill_department_report', 'Ifter Bill  Department Report and Summery  Download PDF', 'Ifter Bill  Department wise Report Download in PDF', now(), NULL)
;
DELETE FROM `permissions`
WHERE `module_id` = '7' AND ((`id` = '70'));
--live--
ALTER TABLE `payroll_heads`
ADD `input_type` varchar(20) NULL AFTER `is_deduction`;

UPDATE `payroll_heads` SET
`input_type` = 'max= 80000 disabled'
WHERE `id` = '1';
UPDATE `payroll_heads` SET
`input_type` = 'max = 1500'
WHERE `id` = '5';

UPDATE `payroll_heads` SET
`input_type` = 'disabled'
WHERE ((`id` = '2') OR (`id` = '3') OR (`id` = '11') OR (`id` = '13') OR (`id` = '17') OR (`id` = '18') OR (`id` = '19') OR (`id` = '20') OR (`id` = '21') OR (`id` = '22') OR (`id` = '23') OR (`id` = '284') OR (`id` = '285') OR (`id` = '290') OR (`id` = '293') OR (`id` = '295') OR (`id` = '300') OR (`id` = '301') OR (`id` = '302') OR (`id` = '303') OR (`id` = '304') OR (`id` = '305') OR (`id` = '306') OR (`id` = '307') OR (`id` = '308') OR (`id` = '309') OR (`id` = '311') OR (`id` = '316'));
--live --
DELETE FROM `employee_payroll_settings`
WHERE `pfno` = '3675' AND ((`id` = '3148'));
Update payrolls set spl_pay = 0.00;
DELETE FROM `employee_payroll_settings`
WHERE `pfno` = '6707' AND ((`id` = '3149'));
6716 ,6707

ALTER TABLE `department_group`
ADD `bank` varchar(256) COLLATE 'latin1_swedish_ci' NULL DEFAULT 'Janata Bank Limited',
ADD `branch` varchar(256) COLLATE 'latin1_swedish_ci' NULL DEFAULT 'Karwan Bazar Corporate Branch' AFTER `bank`,
ADD `ac_number` varchar(10) COLLATE 'latin1_swedish_ci' NULL DEFAULT '240000894' AFTER `branch`,
ADD `location` varchar(10) COLLATE 'latin1_swedish_ci' NULL DEFAULT 'Dhaka' AFTER `ac_number`;

UPDATE `department_group` SET
`id` = '2',
`group_name` = 'Drainage',
`bank` = 'Janata Bank Limited',
`branch` = 'Karwan Bazar Corporate Branch',
`ac_number` = '200020121',
`location` = 'Dhaka'
WHERE `id` = '2';
UPDATE `department_group` SET
`id` = '3',
`group_name` = 'Narayangonj',
`bank` = 'One Bank Limited',
`branch` = 'Narayangonj Branch',
`ac_number` = 'STD-5080444003',
`location` = 'Narayangonj'
WHERE `id` = '3';
--live --
INSERT INTO `permissions` (`module_id`, `name`, `display_name`, `description`, `created_at`, `updated_at`)
VALUES ('7', 'deduction_info', 'Deduction Information', 'Deduction Information', now(), NULL);
--not live --
ALTER TABLE `employees`
ADD `class` int(11) NULL AFTER `office_id`;

ALTER TABLE `overtime_employees`
ADD `allowance` double(8,2) NOT NULL AFTER `overtime`;
ALTER TABLE `night_allowance_employees`
ADD `allowance` double(8,2) NOT NULL DEFAULT '0' AFTER `night_allowance`;
--live --
UPDATE `permissions` SET
`display_name` = 'Overtime Generate',
`description` = 'Create Overtime & Generate'
WHERE `name` = 'create_overtime'  and `module_id` = '7';
UPDATE `permissions` SET
`display_name` = 'Night Allowance Generate',
`description` = 'Create Night Allowance & Generate'
WHERE `name` = 'create_night_allowance'  and `module_id` = '7';
UPDATE `permissions` SET
`display_name` = 'Ifter Bill Generate',
`description` = 'Create Ifter Bill & Generate'
WHERE `name` = 'create_ifter_bill'  and `module_id` = '7';
UPDATE `permissions` SET
`display_name` = 'Overtime Department Report Download (PDF & xlsx)',
`description` = 'Overtime Department wise Report Download'
WHERE `name` = 'download_overtime_department_report'  and `module_id` = '7';
UPDATE `permissions` SET
`display_name` = 'Night Allowance Department Report Download (PDF & xlsx)',
`description` = 'Night Allowance Department wise Report Download'
WHERE `name` = 'download_night_allowance_department_report' and `module_id` = '7' ;
UPDATE `permissions` SET
`display_name` = 'Ifter Bill Department Report Download (PDF & xlsx)',
`description` = 'Ifter Bill Department wise Report Download'
WHERE `name` = 'download_ifter_bill_department_report' and `module_id` = '7' ;

--live --
DELETE FROM `employee_payroll_settings`
WHERE `vhl_alw` > '0' AND `pfno` = '6707' AND ((`id` = '3149'));
DELETE FROM `employee_payroll_settings`
WHERE `pfno` = '3675' AND ((`id` = '3148'));

ALTER TABLE `employee_wasa_job_experiences`
ADD `class` int(11) NULL AFTER `office_id`;
--live -16-02-2020--
ALTER TABLE `employee_wasa_job_experiences`
ADD `transfer_id` bigint NULL AFTER `basic_pay`;
UPDATE `payroll_heads` SET
`input_type` = 'max = 1000'
WHERE `db_field` = 'edu_alw';
-- live --

INSERT INTO `permissions` (`module_id`, `name`, `display_name`, `description`, `created_at`, `updated_at`)
VALUES ('1', 'status_change', 'Status Change', 'Status change permissions', now(), NULL);
INSERT INTO `permissions` (`module_id`, `name`, `display_name`, `description`, `created_at`, `updated_at`)
VALUES ('1', 'dead_status_change', 'Dead Status Change', 'Dead employee status change permissions', now(), NULL);
-- live --

ALTER TABLE `payroll_months`
ADD `send_alert` tinyint(2) NOT NULL DEFAULT '0' AFTER `is_locked`;

INSERT INTO `permissions` (`module_id`, `name`, `display_name`, `description`, `created_at`, `updated_at`)
VALUES ('7', 'send_salary_confirmation_alert', 'Salary Confirmation Alert Send', 'Salary Confirmation Alert Send permissions', now(), NULL);
-- live --
ALTER TABLE `bonus`
ADD `input_request` text NULL AFTER `is_locked`;
ALTER TABLE `bonus_employees`
ADD `rev_stamp` double(8,2) NOT NULL DEFAULT '0.00' AFTER `bonus`,
ADD `net_payable` double(8,2) NOT NULL DEFAULT '0.00' AFTER `rev_stamp`;
ALTER TABLE `bonus_employees_history`
ADD `rev_stamp` double(8,2) NOT NULL DEFAULT '0.00' AFTER `bonus`,
ADD `net_payable` double(8,2) NOT NULL DEFAULT '0.00' AFTER `rev_stamp`;
-- live 07-05-2020 --
ALTER TABLE `employees`
ADD `retirement_notification_date` date NULL AFTER `prl_notification_date`;
-- live 21-05-2020 --

--  27-05-2020  --
--land_zones--
DELETE FROM `land_zones`
WHERE ((`id` = '53') OR (`id` = '54') OR (`id` = '55') OR (`id` = '56') OR (`id` = '57') OR (`id` = '58') OR (`id` = '59') OR (`id` = '60') OR (`id` = '61') OR (`id` = '62') OR (`id` = '63') OR (`id` = '64') OR (`id` = '65') OR (`id` = '66') OR (`id` = '67') OR (`id` = '68') OR (`id` = '69') OR (`id` = '70') OR (`id` = '71') OR (`id` = '72') OR (`id` = '73') OR (`id` = '74') OR (`id` = '75') OR (`id` = '76') OR (`id` = '77') OR (`id` = '78') OR (`id` = '79') OR (`id` = '80') OR (`id` = '81') OR (`id` = '82') OR (`id` = '83') OR (`id` = '84') OR (`id` = '85') OR (`id` = '86') OR (`id` = '87') OR (`id` = '88') OR (`id` = '89') OR (`id` = '90') OR (`id` = '91') OR (`id` = '92') OR (`id` = '93') OR (`id` = '94') OR (`id` = '95') OR (`id` = '96') OR (`id` = '97') OR (`id` = '98') OR (`id` = '99') OR (`id` = '100') OR (`id` = '101') OR (`id` = '102') OR (`id` = '103') OR (`id` = '104') OR (`id` = '105') OR (`id` = '106') OR (`id` = '107') OR (`id` = '108') OR (`id` = '109') OR (`id` = '110') OR (`id` = '111') OR (`id` = '112') OR (`id` = '113') OR (`id` = '114') OR (`id` = '115') OR (`id` = '116') OR (`id` = '117') OR (`id` = '118') OR (`id` = '119') OR (`id` = '120') OR (`id` = '121') OR (`id` = '122') OR (`id` = '123') OR (`id` = '124') OR (`id` = '125') OR (`id` = '126') OR (`id` = '127') OR (`id` = '128') OR (`id` = '129') OR (`id` = '130') OR (`id` = '131') OR (`id` = '132') OR (`id` = '133') OR (`id` = '134') OR (`id` = '135') OR (`id` = '136') OR (`id` = '137') OR (`id` = '138') OR (`id` = '139') OR (`id` = '140') OR (`id` = '141') OR (`id` = '142') OR (`id` = '143') OR (`id` = '144') OR (`id` = '145') OR (`id` = '146') OR (`id` = '147') OR (`id` = '148') OR (`id` = '149') OR (`id` = '150') OR (`id` = '151') OR (`id` = '152') OR (`id` = '153') OR (`id` = '154') OR (`id` = '155') OR (`id` = '156') OR (`id` = '157') OR (`id` = '158') OR (`id` = '159') OR (`id` = '160') OR (`id` = '161') OR (`id` = '162') OR (`id` = '163') OR (`id` = '164') OR (`id` = '165') OR (`id` = '166') OR (`id` = '167') OR (`id` = '168') OR (`id` = '169') OR (`id` = '170') OR (`id` = '171') OR (`id` = '172') OR (`id` = '173') OR (`id` = '174') OR (`id` = '175') OR (`id` = '176') OR (`id` = '177') OR (`id` = '178') OR (`id` = '179') OR (`id` = '180') OR (`id` = '181') OR (`id` = '182') OR (`id` = '183') OR (`id` = '184') OR (`id` = '185') OR (`id` = '186') OR (`id` = '187') OR (`id` = '188') OR (`id` = '189') OR (`id` = '190') OR (`id` = '191') OR (`id` = '192') OR (`id` = '193') OR (`id` = '194') OR (`id` = '195') OR (`id` = '196') OR (`id` = '197') OR (`id` = '198') OR (`id` = '199') OR (`id` = '200') OR (`id` = '201') OR (`id` = '202') OR (`id` = '203') OR (`id` = '204') OR (`id` = '205') OR (`id` = '206') OR (`id` = '207') OR (`id` = '208') OR (`id` = '209') OR (`id` = '210') OR (`id` = '211') OR (`id` = '212') OR (`id` = '213') OR (`id` = '214') OR (`id` = '215') OR (`id` = '216') OR (`id` = '217') OR (`id` = '218') OR (`id` = '219') OR (`id` = '220') OR (`id` = '221') OR (`id` = '222') OR (`id` = '223') OR (`id` = '224') OR (`id` = '225') OR (`id` = '226') OR (`id` = '227') OR (`id` = '228') OR (`id` = '229') OR (`id` = '230') OR (`id` = '231') OR (`id` = '232') OR (`id` = '233') OR (`id` = '234') OR (`id` = '235') OR (`id` = '236') OR (`id` = '237') OR (`id` = '238') OR (`id` = '239') OR (`id` = '240') OR (`id` = '241') OR (`id` = '242') OR (`id` = '243') OR (`id` = '244') OR (`id` = '245') OR (`id` = '246') OR (`id` = '247') OR (`id` = '248') OR (`id` = '249') OR (`id` = '250') OR (`id` = '251') OR (`id` = '252') OR (`id` = '253') OR (`id` = '254') OR (`id` = '255') OR (`id` = '256') OR (`id` = '257') OR (`id` = '258') OR (`id` = '259') OR (`id` = '260') OR (`id` = '261') OR (`id` = '262') OR (`id` = '263') OR (`id` = '264') OR (`id` = '265') OR (`id` = '266') OR (`id` = '267') OR (`id` = '268') OR (`id` = '269') OR (`id` = '270') OR (`id` = '271') OR (`id` = '272') OR (`id` = '273') OR (`id` = '274') OR (`id` = '275') OR (`id` = '276') OR (`id` = '277') OR (`id` = '278') OR (`id` = '279') OR (`id` = '280') OR (`id` = '281') OR (`id` = '282') OR (`id` = '283') OR (`id` = '284') OR (`id` = '285') OR (`id` = '286') OR (`id` = '287') OR (`id` = '288') OR (`id` = '289') OR (`id` = '290') OR (`id` = '291') OR (`id` = '292') OR (`id` = '293') OR (`id` = '294') OR (`id` = '295') OR (`id` = '296') OR (`id` = '297') OR (`id` = '298') OR (`id` = '299') OR (`id` = '300') OR (`id` = '301') OR (`id` = '302') OR (`id` = '303') OR (`id` = '304') OR (`id` = '305') OR (`id` = '306') OR (`id` = '307') OR (`id` = '308') OR (`id` = '309') OR (`id` = '310') OR (`id` = '311') OR (`id` = '312') OR (`id` = '313') OR (`id` = '314') OR (`id` = '315') OR (`id` = '316') OR (`id` = '317') OR (`id` = '318') OR (`id` = '319') OR (`id` = '320') OR (`id` = '321') OR (`id` = '322') OR (`id` = '323') OR (`id` = '324') OR (`id` = '325') OR (`id` = '326') OR (`id` = '327') OR (`id` = '328') OR (`id` = '329') OR (`id` = '330') OR (`id` = '331') OR (`id` = '332') OR (`id` = '333') OR (`id` = '334') OR (`id` = '335') OR (`id` = '336') OR (`id` = '337') OR (`id` = '338') OR (`id` = '339') OR (`id` = '340') OR (`id` = '341') OR (`id` = '342') OR (`id` = '343') OR (`id` = '344') OR (`id` = '345') OR (`id` = '346') OR (`id` = '347') OR (`id` = '348') OR (`id` = '349') OR (`id` = '350') OR (`id` = '351') OR (`id` = '352')OR (`id` = '353'));
--land_update--
ALTER TABLE `lands`
CHANGE `comment` `comment` varchar(191) COLLATE 'utf8mb4_unicode_ci' NULL AFTER `coordinates`;
--land_zones update by area_id --
UPDATE `lands` SET
`area_id` = '422'
WHERE `area_id` = '423';
UPDATE `lands` SET
`area_id` = '154'
WHERE `area_id` = '155';
UPDATE `lands` SET
`area_id` = '154'
WHERE `area_id` = '162';
UPDATE `lands` SET
`area_id` = '373'
WHERE `area_id` = '375';
UPDATE `lands` SET
`area_id` = '373'
WHERE `area_id` = '187';
UPDATE `lands` SET
`area_id` = '143'
WHERE `area_id` = '320';
UPDATE `lands` SET
`area_id` = '120'
WHERE `area_id` = '122';
UPDATE `lands` SET
`area_id` = '255'
WHERE `area_id` = '257';
UPDATE `lands` SET
`area_id` = '201'
WHERE `area_id` = '202';
UPDATE `lands` SET
`area_id` = '201'
WHERE `area_id` = '203';
UPDATE `lands` SET
`area_id` = '33'
WHERE `area_id` = '253';
UPDATE `lands` SET
`area_id` = '231'
WHERE `area_id` = '235';
UPDATE `lands` SET
`area_id` = '231'
WHERE `area_id` = '237';
UPDATE `lands` SET
`area_id` = '231'
WHERE `area_id` = '241';
UPDATE `lands` SET
`area_id` = '102'
WHERE `area_id` = '103';
UPDATE `lands` SET
`area_id` = '102'
WHERE `area_id` = '295';
UPDATE `lands` SET
`area_id` = '102'
WHERE `area_id` = '296';
UPDATE `lands` SET
`area_id` = '102'
WHERE `area_id` = '297';
UPDATE `lands` SET
`area_id` = '102'
WHERE `area_id` = '298';
UPDATE `lands` SET
`area_id` = '102'
WHERE `area_id` = '299';
UPDATE `lands` SET
`area_id` = '169'
WHERE `area_id` = '156';
UPDATE `lands` SET
`area_id` = '169'
WHERE `area_id` = '157';
UPDATE `lands` SET
`area_id` = '169'
WHERE `area_id` = '159';
UPDATE `lands` SET
`area_id` = '169'
WHERE `area_id` = '160';
UPDATE `lands` SET
`area_id` = '182'
WHERE `area_id` = '183';
UPDATE `lands` SET
`area_id` = '182'
WHERE `area_id` = '370';
UPDATE `lands` SET
`area_id` = '182'
WHERE `area_id` = '383';
UPDATE `lands` SET
`area_id` = '315'
WHERE `area_id` = '329';
UPDATE `lands` SET
`area_id` = '315'
WHERE `area_id` = '330';
UPDATE `lands` SET
`area_id` = '315'
WHERE `area_id` = '331';
UPDATE `lands` SET
`area_id` = '315'
WHERE `area_id` = '129';
UPDATE `lands` SET
`area_id` = '267'
WHERE `area_id` = '268';
UPDATE `lands` SET
`area_id` = '210'
WHERE `area_id` = '394';
UPDATE `lands` SET
`area_id` = '211'
WHERE `area_id` = '212';
UPDATE `lands` SET
`area_id` = '274'
WHERE `area_id` = '275';
UPDATE `lands` SET
`area_id` = '274'
WHERE `area_id` = '285';
UPDATE `lands` SET
`area_id` = '227'
WHERE `area_id` = '232';
UPDATE `lands` SET
`area_id` = '227'
WHERE `area_id` = '234';
UPDATE `lands` SET
`area_id` = '205'
WHERE `area_id` = '378';
UPDATE `lands` SET
`area_id` = '205'
WHERE `area_id` = '379';
UPDATE `lands` SET
`area_id` = '177'
WHERE `area_id` = '178';
UPDATE `lands` SET
`area_id` = '217'
WHERE `area_id` = '221';
UPDATE `lands` SET
`area_id` = '9'
WHERE `area_id` = '261';

--land update by zone_id --
UPDATE `lands` SET
`zone_id` = '9'
WHERE `zone_id` = '352';

--land_areas_update--
UPDATE `land_areas` SET
`title` = 'Kaprul'
WHERE `id` = '142';
UPDATE `land_areas` SET
`title` = 'Senpara Parbata'
WHERE `id` = '153';
UPDATE `land_areas` SET
`title` = 'Shibpur & Sultangonj'
WHERE `id` = '118';
UPDATE `land_areas` SET
`title` = 'Tejkuni para'
WHERE `id` = '177';
UPDATE `land_areas` SET
`title` = 'Wari'
WHERE `id` = '9';
UPDATE `land_areas` SET
`title` = 'Kaprul'
WHERE `id` = '433';
UPDATE `land_areas` SET
`id` = '429',
`title` = 'Zatrabari',
`zone_id` = '1'
WHERE `id` = '429';
UPDATE `land_areas` SET
`zone_id` = '9'
WHERE `id` = '430';
-- delete land areas --
DELETE FROM `land_areas`
WHERE `title` = 'Azimpur' AND ((`id` = '112') OR (`id` = '113') OR (`id` = '114') OR (`id` = '115'));
DELETE FROM `land_areas`
WHERE `title` = 'Asadgate' AND ((`id` = '317'));
DELETE FROM `land_areas`
WHERE `title` = 'Banani' AND ((`id` = '185') OR (`id` = '206') OR (`id` = '207'));
DELETE FROM `land_areas`
WHERE `title` = 'Bhrammonchiron' AND ((`id` = '259'));
DELETE FROM `land_areas`
WHERE `title` = 'Bihsil' AND ((`id` = '345'));
DELETE FROM `land_areas`
WHERE `title` = 'Bishil' AND ((`id` = '155') OR (`id` = '158') OR (`id` = '161') OR (`id` = '162') OR (`id` = '164') OR (`id` = '346') OR (`id` = '353'));
DELETE FROM `land_areas`
WHERE `title` = 'Bonani' AND ((`id` = '375') OR (`id` = '391') OR (`id` = '392'));
DELETE FROM `land_areas`
WHERE `title` = 'Banani' AND ((`id` = '187'));
DELETE FROM `land_areas`
WHERE `title` = 'Borab' AND ((`id` = '134') OR (`id` = '320') OR (`id` = '338'));
DELETE FROM `land_areas`
WHERE `title` = 'Boro Sayek' AND ((`id` = '145') OR (`id` = '339') OR (`id` = '340') OR (`id` = '341'));
DELETE FROM `land_areas`
WHERE `title` = 'Chor Rogunathpur' AND ((`id` = '282'));
DELETE FROM `land_areas`
WHERE `title` = 'Dhaka' AND ((`id` = '101'));
DELETE FROM `land_areas`
WHERE `title` = 'Dhanmondhi' AND ((`id` = '122') OR (`id` = '123') OR (`id` = '125') OR (`id` = '135') OR (`id` = '136') OR (`id` = '138') OR (`id` = '139') OR (`id` = '308') OR (`id` = '310') OR (`id` = '312') OR (`id` = '321') OR (`id` = '322') OR (`id` = '324') OR (`id` = '325') OR (`id` = '326') OR (`id` = '327') OR (`id` = '328') OR (`id` = '334') OR (`id` = '335'));
DELETE FROM `land_areas`
WHERE `title` = 'Duaripara' AND ((`id` = '354'));
DELETE FROM `land_areas`
WHERE `title` = 'Gandaria' AND ((`id` = '257') OR (`id` = '264') OR (`id` = '265'));
DELETE FROM `land_areas`
WHERE `title` = 'GENDARIA' AND ((`id` = '7'));
DELETE FROM `land_areas`
WHERE `title` = 'Godan' AND ((`id` = '233'));
DELETE FROM `land_areas`
WHERE `title` = 'Gulshan' AND ((`id` = '184') OR (`id` = '202') OR (`id` = '203') OR (`id` = '204') OR (`id` = '372') OR (`id` = '387') OR (`id` = '388') OR (`id` = '389'));
DELETE FROM `land_areas`
WHERE `title` = 'Jatrabari' AND ((`id` = '253') OR (`id` = '258'));
DELETE FROM `land_areas`
WHERE `title` = 'kakrayl' AND ((`id` = '235') OR (`id` = '237') OR (`id` = '238') OR (`id` = '239') OR (`id` = '241') OR (`id` = '242'));
DELETE FROM `land_areas`
WHERE `title` = 'Kaprul' AND ((`id` = '337') OR (`id` = '342'));
DELETE FROM `land_areas`
WHERE `title` = 'Kaphrul' AND ((`id` = '146'));
DELETE FROM `land_areas`
WHERE `title` = 'Kawran Bazar' AND ((`id` = '186') OR (`id` = '374') OR (`id` = '376'));
DELETE FROM `land_areas`
WHERE `title` = 'Lalbag' AND ((`id` = '103') OR (`id` = '104') OR (`id` = '105') OR (`id` = '106') OR (`id` = '107') OR (`id` = '108') OR (`id` = '109') OR (`id` = '284') OR (`id` = '294'));
DELETE FROM `land_areas`
WHERE `title` = 'Lalbagh' AND ((`id` = '295') OR (`id` = '296') OR (`id` = '297') OR (`id` = '298') OR (`id` = '299') OR (`id` = '300') OR (`id` = '301') OR (`id` = '302') OR (`id` = '303') OR (`id` = '304') OR (`id` = '305'));
DELETE FROM `land_areas`
WHERE `title` = 'Lalmatia' AND ((`id` = '316'));
DELETE FROM `land_areas`
WHERE `title` = 'Maradia' AND ((`id` = '400'));
DELETE FROM `land_areas`
WHERE `title` = 'Mirpur' AND ((`id` = '167') OR (`id` = '168') OR (`id` = '170') OR (`id` = '173') OR (`id` = '174') OR (`id` = '175') OR (`id` = '176'));
DELETE FROM `land_areas`
WHERE `title` = 'Mirpur Housing' AND ((`id` = '171') OR (`id` = '347') OR (`id` = '348') OR (`id` = '349') OR (`id` = '350') OR (`id` = '351') OR (`id` = '355') OR (`id` = '356') OR (`id` = '357') OR (`id` = '358') OR (`id` = '359') OR (`id` = '360') OR (`id` = '361') OR (`id` = '362') OR (`id` = '363') OR (`id` = '364'));
DELETE FROM `land_areas`
WHERE `title` = 'Mirpur Husing' AND ((`id` = '156') OR (`id` = '157') OR (`id` = '159') OR (`id` = '160'));
DELETE FROM `land_areas`
WHERE `title` = 'Mohakhali' AND ((`id` = '183') OR (`id` = '189') OR (`id` = '195') OR (`id` = '196') OR (`id` = '197') OR (`id` = '198') OR (`id` = '199') OR (`id` = '200') OR (`id` = '370') OR (`id` = '371') OR (`id` = '377') OR (`id` = '383') OR (`id` = '384') OR (`id` = '385') OR (`id` = '386'));
DELETE FROM `land_areas`
WHERE `title` = 'Moammdpur' AND ((`id` = '128'));
DELETE FROM `land_areas`
WHERE `title` = 'Mohammadpur' AND ((`id` = '329') OR (`id` = '330') OR (`id` = '331') OR (`id` = '332'));
DELETE FROM `land_areas`
WHERE `title` = 'Mohammdpur' AND ((`id` = '129') OR (`id` = '132') OR (`id` = '148') OR (`id` = '151') OR (`id` = '318'));
DELETE FROM `land_areas`
WHERE `title` = 'Motijeel' AND ((`id` = '268') OR (`id` = '269') OR (`id` = '270'));
DELETE FROM `land_areas`
WHERE `title` = 'NO_NAME' AND ((`id` = '49') OR (`id` = '99'));
DELETE FROM `land_areas`
WHERE `title` = 'Oari' AND ((`id` = '250'));
DELETE FROM `land_areas`
WHERE `title` = 'Paikpara' AND ((`id` = '150') OR (`id` = '152'));
DELETE FROM `land_areas`
WHERE `title` = 'Paykpara' AND ((`id` = '336') OR (`id` = '343'));
DELETE FROM `land_areas`
WHERE `title` = 'Purana Palton Line' AND ((`id` = '394') OR (`id` = '395'));
DELETE FROM `land_areas`
WHERE `title` = 'Purbagaon' AND ((`id` = '404'));
DELETE FROM `land_areas`
WHERE `title` = 'Rajarbag' AND ((`id` = '212') OR (`id` = '213') OR (`id` = '214') OR (`id` = '215') OR (`id` = '223') OR (`id` = '244') OR (`id` = '245') OR (`id` = '246') OR (`id` = '248'));
DELETE FROM `land_areas`
WHERE `title` = 'Senpara Pharbta' AND ((`id` = '172') OR(`id` = '344') OR (`id` = '352'));
DELETE FROM `land_areas`
WHERE `title` = 'Senpara Porbhata' AND ((`id` = '163'));
DELETE FROM `land_areas`
WHERE `title` = 'Shampur' AND ((`id` = '408'));
DELETE FROM `land_areas`
WHERE `title` = 'Shibpur' AND ((`id` = '124') OR (`id` = '126') OR (`id` = '127') OR (`id` = '137') OR (`id` = '311') OR (`id` = '313') OR (`id` = '314') OR (`id` = '323'));
DELETE FROM `land_areas`
WHERE `title` = 'Shibpur & Sultangonj' AND ((`id` = '306') OR (`id` = '307'));
DELETE FROM `land_areas`
WHERE `title` = 'Shohor Dhaka' AND ((`id` = '275') OR (`id` = '276') OR (`id` = '277') OR (`id` = '278') OR (`id` = '279') OR (`id` = '281') OR (`id` = '283') OR (`id` = '285') OR (`id` = '286') OR (`id` = '287') OR (`id` = '288') OR (`id` = '289') OR (`id` = '290') OR (`id` = '291') OR (`id` = '292') OR (`id` = '293'));
DELETE FROM `land_areas`
WHERE `title` = 'Shohor Khilgaon' AND ((`id` = '232') OR (`id` = '234') OR (`id` = '236'));
DELETE FROM `land_areas`
WHERE `title` = 'Shukrabad' AND ((`id` = '309'));
DELETE FROM `land_areas`
WHERE `title` = 'Sutrapur' AND ((`id` = '271'));
DELETE FROM `land_areas`
WHERE `title` = 'Tajgaon' AND ((`id` = '378') OR (`id` = '379') OR (`id` = '380') OR (`id` = '381') OR (`id` = '382') OR (`id` = '390'));
DELETE FROM `land_areas`
WHERE `title` = 'Tajkunipara' AND ((`id` = '178') OR (`id` = '179') OR (`id` = '180') OR (`id` = '181') OR (`id` = '190') OR (`id` = '192') OR (`id` = '193') OR (`id` = '194') OR (`id` = '365') OR (`id` = '366') OR (`id` = '367') OR (`id` = '368') OR (`id` = '369'));
DELETE FROM `land_areas`
WHERE `title` = 'Tejkuni para' AND ((`id` = '396') OR (`id` = '397'));
DELETE FROM `land_areas`
WHERE `title` = 'Ulon' AND ((`id` = '221') OR (`id` = '225') OR (`id` = '399'));
DELETE FROM `land_areas`
WHERE `title` = 'Vatara' AND ((`id` = '418'));
DELETE FROM `land_areas`
WHERE `title` = 'Victoria Park' AND ((`id` = '36'));
DELETE FROM `land_areas`
WHERE `title` = 'Wari' AND ((`id` = '261') OR (`id` = '262') OR (`id` = '263') OR (`id` = '266') OR (`id` = '272') OR (`id` = '273'));
DELETE FROM `land_areas`
WHERE ((`id` = '423'));
DELETE FROM `land_areas`
WHERE ((`id` = '432'));
--land update_by land_source_id--
UPDATE `lands` SET
`land_source_id` = '206'
WHERE `land_source_id` in ('207','233','234','235','236','237','301');
UPDATE `lands` SET
`land_source_id` = '263'
WHERE `land_source_id` in ('264','265','266','267','291','292','293','294','295','296','297','298','299');
UPDATE `lands` SET
`land_source_id` = '186'
WHERE `land_source_id` in ('187','188');
UPDATE `lands` SET
`land_source_id` = '185'
WHERE `land_source_id` in ('268','269');
UPDATE `lands` SET
`land_source_id` = '129'
WHERE `land_source_id` in ('232','300','317','318','319','320','321','322','323','324','376');
UPDATE `lands` SET
`land_source_id` = '1'
WHERE `land_source_id` in ('26','27','28','29','30','31','32','33','34','35','36');
UPDATE `lands` SET
`land_source_id` = '85'
WHERE `land_source_id` in
('86', '87', '88', '89', '113', '114', '115', '116', '117', '118', '119', '120', '121', '122', '123', '137', '138', '139', '140', '141', '142', '143', '144', '145', '146', '147', '148', '149', '150', '151', '152', '153', '189', '190', '191', '192', '193', '194', '209', '210', '211', '212', '213', '214', '215', '216', '217', '218', '219', '220', '221', '222', '243', '245', '246', '247', '248', '249', '250', '251', '252', '253', '270', '271', '272', '273', '274', '275', '276', '277', '278', '279', '280', '281', '282', '283', '284', '303', '304', '305', '306', '307', '308', '309', '310', '311', '325', '326', '327', '328', '329', '330', '331', '332', '333', '334', '335', '336', '337', '338', '339', '340', '341');
UPDATE `lands` SET
`land_source_id` = '22'
WHERE `land_source_id` in
( '23', '24', '25', '51', '52', '53', '54', '55', '56', '57', '58', '59', '60', '61', '62', '63', '64', '65', '66', '112', '238', '239', '240', '241', '242', '244');
UPDATE `lands` SET
`land_source_id` = '3'
WHERE `land_source_id` in ('5','6');
UPDATE `lands` SET
`land_source_id` = '40'
WHERE `land_source_id` in ('41','42','68');
UPDATE `lands` SET
`land_source_id` = '92'
WHERE `land_source_id` in ('96','97');
UPDATE `lands` SET
`land_source_id` = '90'
WHERE `land_source_id` = '91';
UPDATE `lands` SET
`land_source_id` = '15'
WHERE `land_source_id` = '16';
UPDATE `lands` SET
`land_source_id` = '77'
WHERE `land_source_id` in ('45','78','79','80','81','100','101','102','103','104','105','106','108');
UPDATE `lands` SET
`land_source_id` = '47'
WHERE `land_source_id` in ('48','49','50','110');
UPDATE `lands` SET
`land_source_id` = '82'
WHERE `land_source_id` in ('83','84','178','179','180','181','182','183','184');
UPDATE `lands` SET
`land_source_id` = '15'
WHERE `land_source_id` in ( '46', '109', '130', '131', '132', '133', '134', '135', '136', '176', '205');
UPDATE `lands` SET
`land_source_id` = '159'
WHERE `land_source_id` in ( '196', '346');
UPDATE `lands` SET
`land_source_id` = '354'
WHERE `land_source_id` in ( '355', '356');
UPDATE `lands` SET
`land_source_id` = '256'
WHERE `land_source_id` = '260';
UPDATE `lands` SET
`land_source_id` = '347'
WHERE `land_source_id` in ( '161', '162','166','352');
UPDATE `lands` SET
`land_source_id` = '228'
WHERE `land_source_id` in ( '229', '255','345');
UPDATE `lands` SET
`land_source_id` = '171'
WHERE `land_source_id` = '369';
--land_source_update--
UPDATE `land_sources` SET
`title` = 'To Buy From Rajuk'
WHERE `id` = '15';
UPDATE `land_sources` SET
`title` = 'LA CASE NO. 30/81-82'
WHERE `id` = '397';
UPDATE `land_sources` SET
`title` = 'LA CASE NO. 22/89-89'
WHERE `id` = '399';
UPDATE `land_sources` SET
`title` = 'LA CASE NO. 40/89-90'
WHERE `id` = '400';
UPDATE `land_sources` SET
`title` = 'LA CASE NO. 38/89-90'
WHERE `id` = '401';
--land_source_delete--

DELETE FROM `land_sources`
WHERE ((`id` = '207') OR (`id` = '233') OR (`id` = '234') OR (`id` = '235') OR (`id` = '236') OR (`id` = '237') OR (`id` = '301'));
DELETE FROM `land_sources`
WHERE ((`id` = '264') OR (`id` = '265') OR (`id` = '266') OR (`id` = '267') OR (`id` = '291') OR (`id` = '292') OR (`id` = '293') OR (`id` = '294') OR (`id` = '295') OR (`id` = '296') OR (`id` = '297') OR (`id` = '298') OR (`id` = '299'));
DELETE FROM `land_sources`
WHERE ((`id` = '187') OR (`id` = '188'));
DELETE FROM `land_sources`
WHERE ((`id` = '268') OR (`id` = '269'));
DELETE FROM `land_sources`
WHERE ((`id` = '232') OR (`id` = '300') OR (`id` = '317') OR (`id` = '318') OR (`id` = '319') OR (`id` = '320') OR (`id` = '321') OR (`id` = '322') OR (`id` = '323') OR (`id` = '324') OR (`id` = '376'));
DELETE FROM `land_sources`
WHERE ((`id` = '26') OR (`id` = '27') OR (`id` = '28') OR (`id` = '29') OR (`id` = '30') OR (`id` = '31') OR (`id` = '32') OR (`id` = '33') OR (`id` = '34') OR (`id` = '35') OR (`id` = '36'));
DELETE FROM `land_sources`
WHERE ((`id` = '86') OR (`id` = '87') OR (`id` = '88') OR (`id` = '89') OR (`id` = '113') OR (`id` = '114') OR (`id` = '115') OR (`id` = '116') OR (`id` = '117') OR (`id` = '118') OR (`id` = '119') OR (`id` = '120') OR (`id` = '121') OR (`id` = '122') OR (`id` = '123') OR (`id` = '137') OR (`id` = '138') OR (`id` = '139') OR (`id` = '140') OR (`id` = '141') OR (`id` = '142') OR (`id` = '143') OR (`id` = '144') OR (`id` = '145') OR (`id` = '146') OR (`id` = '147') OR (`id` = '148') OR (`id` = '149') OR (`id` = '150') OR (`id` = '151') OR (`id` = '152') OR (`id` = '153') OR (`id` = '189') OR (`id` = '190') OR (`id` = '191') OR (`id` = '192') OR (`id` = '193') OR (`id` = '194') OR (`id` = '209') OR (`id` = '210') OR (`id` = '211') OR (`id` = '212') OR (`id` = '213') OR (`id` = '214') OR (`id` = '215') OR (`id` = '216') OR (`id` = '217') OR (`id` = '218') OR (`id` = '219') OR (`id` = '220') OR (`id` = '221') OR (`id` = '222') OR (`id` = '243') OR (`id` = '245') OR (`id` = '246') OR (`id` = '247') OR (`id` = '248') OR (`id` = '249') OR (`id` = '250') OR (`id` = '251') OR (`id` = '252') OR (`id` = '253') OR (`id` = '270') OR (`id` = '271') OR (`id` = '272') OR (`id` = '273') OR (`id` = '274') OR (`id` = '275') OR (`id` = '276') OR (`id` = '277') OR (`id` = '278') OR (`id` = '279') OR (`id` = '280') OR (`id` = '281') OR (`id` = '282') OR (`id` = '283') OR (`id` = '284') OR (`id` = '303') OR (`id` = '304') OR (`id` = '305') OR (`id` = '306') OR (`id` = '307') OR (`id` = '308') OR (`id` = '309') OR (`id` = '310') OR (`id` = '311') OR (`id` = '325') OR (`id` = '326') OR (`id` = '327') OR (`id` = '328') OR (`id` = '329') OR (`id` = '330') OR (`id` = '331') OR (`id` = '332') OR (`id` = '333') OR (`id` = '334') OR (`id` = '335') OR (`id` = '336') OR (`id` = '337') OR (`id` = '338') OR (`id` = '339') OR (`id` = '340') OR (`id` = '341'));
DELETE FROM `land_sources`
WHERE ((`id` = '23') OR (`id` = '24') OR (`id` = '25') OR (`id` = '51') OR (`id` = '52') OR (`id` = '53') OR (`id` = '54') OR (`id` = '55') OR (`id` = '56') OR (`id` = '57') OR (`id` = '58') OR (`id` = '59') OR (`id` = '60') OR (`id` = '61') OR (`id` = '62') OR (`id` = '63') OR (`id` = '64') OR (`id` = '65') OR (`id` = '66') OR (`id` = '112') OR (`id` = '238') OR (`id` = '239') OR (`id` = '240') OR (`id` = '241') OR (`id` = '242') OR (`id` = '244'));
DELETE FROM `land_sources`
WHERE ((`id` = '5') OR (`id` = '6'));
DELETE FROM `land_sources`
WHERE ((`id` = '41') OR (`id` = '42') OR (`id` = '68'));
DELETE FROM `land_sources`
WHERE ((`id` = '96') OR (`id` = '97'));
DELETE FROM `land_sources`
WHERE ((`id` = '91'));
DELETE FROM `land_sources`
WHERE ((`id` = '16'));
DELETE FROM `land_sources`
WHERE ((`id` = '45') OR (`id` = '78') OR (`id` = '79') OR (`id` = '80') OR (`id` = '81') OR (`id` = '100') OR (`id` = '101') OR (`id` = '103') OR (`id` = '103') OR (`id` = '104') OR (`id` = '105') OR (`id` = '106') OR (`id` = '108'));
DELETE FROM `land_sources`
WHERE ((`id` = '48') OR (`id` = '49') OR (`id` = '50') OR (`id` = '110'));
DELETE FROM `land_sources`
WHERE ((`id` = '46') OR (`id` = '109') OR (`id` = '130') OR (`id` = '131') OR (`id` = '132') OR (`id` = '133') OR (`id` = '134') OR (`id` = '135') OR (`id` = '136') OR (`id` = '176') OR (`id` = '205'));
DELETE FROM `land_sources`
WHERE ((`id` = '196') OR (`id` = '346'));
DELETE FROM `land_sources`
WHERE ((`id` = '195'));
DELETE FROM `land_sources`
WHERE ((`id` = '355') OR (`id` = '356'));
DELETE FROM `land_sources`
WHERE ((`id` = '127'));
DELETE FROM `land_sources`
WHERE ((`id` = '128'));
DELETE FROM `land_sources`
WHERE ((`id` = '124'));
DELETE FROM `land_sources`
WHERE ((`id` = '161') OR (`id` = '162') OR (`id` = '166') OR (`id` = '352'));
DELETE FROM `land_sources`
WHERE ((`id` = '165'));
DELETE FROM `land_sources`
WHERE ((`id` = '154'));
DELETE FROM `land_sources`
WHERE ((`id` = '155'));
DELETE FROM `land_sources`
WHERE ((`id` = '157') OR (`id` = '158'));
DELETE FROM `land_sources`
WHERE ((`id` = '229') OR (`id` = '255') OR (`id` = '345'));
DELETE FROM `land_sources`
WHERE ((`id` = '369'));
DELETE FROM `land_sources`
WHERE ((`id` = '126'));
DELETE FROM `land_sources`
WHERE ((`id` = '74'));
DELETE FROM `land_sources`
WHERE ((`id` = '10'));
DELETE FROM `land_sources`
WHERE ((`id` = '398'));
DELETE FROM `land_sources`
WHERE ((`id` = '83') OR (`id` = '84') OR (`id` = '178') OR (`id` = '179') OR (`id` = '180') OR (`id` = '181') OR (`id` = '182') OR (`id` = '183') OR (`id` = '184'));
DELETE FROM `land_sources`
WHERE ((`id` = '160') OR (`id` = '163') OR (`id` = '349'));
-- live at 31-05-2020 --

ALTER TABLE `employee_payroll_settings`
ADD `h_rent_type` tinyint(1) NULL DEFAULT '0' COMMENT '1= Building 2= Tin Shed' AFTER `h_rent`;

UPDATE `employee_payroll_settings` SET `h_rent_type` = '1' WHERE `h_rent` = '1' and `h_rent_type` = '0';
select pfno From employee_payroll_settings WHERE h_rent = 0 and h_rent_type > 0;
SELECT `hr_arr`, `h_rent` FROM `payrolls` WHERE `pfno` IN (3729,6081,1913,2082,3339,3953,6487,6122,3494,2144);
UPDATE payrolls SET h_rent = 0 WHERE pfno in ('3729', '6081','1913','2082','3339','3953','6487','6122','3494','2144');
UPDATE employee_payroll_settings SET h_rent_type = 0 WHERE pfno in ('3729', '6081','1913','2082','3339','3953','6487','6122','3494','2144');
-- live 20-07-2020 --
INSERT INTO `pay_scale_list` (`max_house_loan`, `scale_year`, `grade`, `scale`, `serial`, `status`, `created_by`, `created_at`, `updated_by`, `updated_at`)
VALUES ('900000', '2015', '10', '28810', '13', '2', NULL, now(), NULL, NULL);
-- live 24-08-2020 --

ALTER TABLE `loan_info`
CHANGE `ref_no` `ref_no` varchar(255) COLLATE 'latin1_swedish_ci' NULL AFTER `parent_id`,
CHANGE `ref_date` `ref_date` date NULL AFTER `generated_id`,
CHANGE `loan_eff_date` `loan_eff_date` date NULL AFTER `ref_date`,
CHANGE `cheque_no` `cheque_no` varchar(50) COLLATE 'latin1_swedish_ci' NULL AFTER `max_amount`,
CHANGE `cheque_date` `cheque_date` date NULL AFTER `cheque_no`;

ALTER TABLE `loan_ledgers`
CHANGE `principal_realization` `principal_realization` decimal(10,2) NULL DEFAULT '0' AFTER `pay_date`,
CHANGE `principal_balance` `principal_balance` decimal(16,2) NULL DEFAULT '0.00' AFTER `principal_realization`,
CHANGE `interest_charge` `interest_charge` decimal(10,2) NULL DEFAULT '0' AFTER `interest_rate`,
CHANGE `interest_realization` `interest_realization` float(10,2) NULL DEFAULT '0' AFTER `interest_charge`,
CHANGE `interest_balance` `interest_balance` decimal(10,2) NOT NULL DEFAULT '0' AFTER `interest_realization`,
CHANGE `total_balance` `total_balance` decimal(16,2) NOT NULL DEFAULT '0' AFTER `interest_balance`,
CHANGE `loan_amount` `loan_amount` decimal(16,2) NULL AFTER `loan_eff_date`;

ALTER TABLE `loan_10_14`
ADD `created_at` timestamp NULL,
ADD `updated_at` timestamp NULL AFTER `created_at`;

UPDATE `loan_14_19` SET
`hb_loan` = '0'
WHERE `hb_inttr` > '0' AND `hb_loan` IS NULL;

UPDATE `loan_14_19` SET
`hb_inttr` = '0'
WHERE `hb_loan` > '0' AND `hb_inttr` IS NULL;

UPDATE `loan_14_19` SET
`hb_loan` = NULL
WHERE `hb_inttr` IS NULL AND `hb_loan` <= '0';

UPDATE `loan_14_19` SET
`hb_inttr` = NULL
WHERE `hb_loan` IS NULL AND `hb_inttr` <= '0';

UPDATE `loan_14_19` SET
`hb_loan` = NULL,
`hb_inttr` = NULL
WHERE `hb_loan` = '0' AND `hb_inttr` = '0';

ALTER TABLE `loan_one_time_deposit`
ADD `deleted_at` timestamp NULL AFTER `updated_at`;
ALTER TABLE `loan_one_time_deposit`
ADD `deleted_by` int NULL;

ALTER TABLE `loan_ledgers`
ADD `deposit_payment` varchar(255) NULL;
ALTER TABLE `loan_one_time_deposit`
ADD `deposit_payment` varchar(255) NULL AFTER `pay_date`;
<-- live 31-08-2020 -->
UPDATE `loan_14_19` SET
`basic_pay` = '0'
WHERE `basic_pay` IS NULL;
UPDATE `loan_14_19` SET
`f_bonus` = '0'
WHERE `f_bonus` IS NULL;
<-- live 01-09-2020 -->

INSERT INTO `permissions` (`module_id`, `name`, `display_name`, `description`, `created_at`, `updated_at`)
VALUES ('2', 'manage_audit_trail', 'Manage Audit Trail', 'Manage Audit Trail', now(), NULL);
INSERT INTO `permissions` (`module_id`, `name`, `display_name`, `description`, `created_at`, `updated_at`)
VALUES ('7', 'change_salary_department', 'Change Salary Department', 'Change salary department in special case', now(), NULL);
<-- live 10-11-2020 -->

ALTER TABLE `employee_wasa_job_experiences`
ADD `current_job` tinyint NULL DEFAULT '0' AFTER `employee_id`;
ALTER TABLE `employee_transfers`
ADD `current_transfer` tinyint unsigned NOT NULL DEFAULT '0' AFTER `employee_id`;
ALTER TABLE `employee_transfers`
ADD `old_division_id` int NULL AFTER `division_id`;
<-- demo 18-11-2020 -->
