
-- ------------ 07-03-2018 --------------------

update employees e, (SELECT employee_id id, joining_date current_joining_date, designation_status,scale_id,
grade,	office_id,	 basic_pay	current_basic_pay,	designation_id,
(SELECT min(joining_date)
    FROM employee_wasa_job_experiences AS d
    WHERE a.employee_id = d.employee_id
     ) as first_joining_date
FROM employee_wasa_job_experiences AS a
WHERE joining_date = (
    SELECT MAX(joining_date)
    FROM employee_wasa_job_experiences AS b
    WHERE a.employee_id = b.employee_id
     -- and office_id=28
)) t

set e.current_joining_date=t.current_joining_date,
e.designation_status=t.designation_status,
e.scale_id=t.scale_id,
e.grade=t.grade,
e.office_id=t.office_id,
e.current_basic_pay = t.current_basic_pay,
e.designation_id=t.designation_id,
e.first_joining_date=t.first_joining_date
where e.id=t.id;


-- ------------ 08-03-2018 --------------------

ALTER TABLE `pension_employee`
  ADD `first_joining_date` date NULL AFTER `freedom_fighter`;


-- ------------ 14-05-2018 --------------------
ALTER TABLE `payroll_employees`
  ADD `vhl_alw` float NOT NULL DEFAULT '0' AFTER `depu_arr`;

ALTER TABLE `lab_dmas`
  DROP `unit`,
  DROP `min_value`,
  DROP `max_value`,
  DROP `standard`;

ALTER TABLE `lab_units`
  add  `min_value` varchar(20) COLLATE 'utf8mb4_unicode_ci' NULL ,
  add  `max_value` varchar(20) COLLATE 'utf8mb4_unicode_ci' NULL AFTER `min_value`,
  add `standard` varchar(20) COLLATE 'utf8mb4_unicode_ci' NULL AFTER `max_value`;

CREATE TABLE `lab_institutes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `address` varchar(255)  NULL,
  `phone` varchar(21)   NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

ALTER TABLE `lab_test_results`
  ADD `dma_id` int(11) NOT NULL,
  ADD `institute_id` int(11) NOT NULL AFTER `dma_id`;


-- ------------ 21-05-2018 --------------------

CREATE TABLE `pension_prl_payables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `application_id` int(11) NOT NULL,
  `month_id` int(11) NOT NULL,
  `basic_pay` decimal(10,2) NOT NULL DEFAULT '0',
  `house_alw` decimal(10,2) DEFAULT '0',
  `med_alw` decimal(10,2) DEFAULT '0',
  `f_bonus` decimal(10,2) DEFAULT '0',
  `tiffin_alw` decimal(10,2) NOT NULL DEFAULT '0',
  `conv_alw` decimal(10,2) NOT NULL DEFAULT '0',
  `ws_alw` decimal(10,2) NOT NULL DEFAULT '0',
  `wash_alw` decimal(10,2) NOT NULL DEFAULT '0',
  `dearness` decimal(10,2) NOT NULL DEFAULT '0',
  `payable_basic_pay` decimal(10,2) NOT NULL DEFAULT '0',
  `payable_house_alw` decimal(10,2) DEFAULT '0',
  `payable_med_alw` decimal(10,2) DEFAULT '0',
  `payable_f_bonus` decimal(10,2) DEFAULT '0',
  `payable_tiffin_alw` decimal(10,2) NOT NULL DEFAULT '0',
  `payable_conv_alw` decimal(10,2) NOT NULL DEFAULT '0',
  `payable_ws_alw` decimal(10,2) NOT NULL DEFAULT '0',
  `payable_wash_alw` decimal(10,2) NOT NULL DEFAULT '0',
  `payable_dearness` decimal(10,2) NOT NULL DEFAULT '0',

  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `month_id` (`month_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

ALTER TABLE `pension_prl_payables`
add `created_at` timestamp NULL DEFAULT NULL,
  add `updated_at` timestamp NULL DEFAULT NULL,
  add `deleted_at` timestamp NULL DEFAULT NULL,
  add `created_by` int(11) DEFAULT NULL,
  add `updated_by` int(11) DEFAULT NULL,
  add `deleted_by` int(11) DEFAULT NULL;


-- ------------ 22-10-2018 --------------------

ALTER TABLE `users`
  ADD `status` tinyint(2) NULL DEFAULT '1' AFTER `password`;

ALTER TABLE `users`
  ADD UNIQUE `user_name_unique` (`user_name`);

INSERT INTO `permissions` (`module_id`, `name`, `display_name`, `description`, `created_at`, `updated_at`)
SELECT '1', 'manage_permanent-address', 'Manage Permanent Address', NULL, now(), now()
FROM `permissions`
WHERE (`id` = '36');


INSERT INTO `permissions` (`module_id`, `name`, `display_name`, `description`, `created_at`, `updated_at`)
SELECT '1', 'permanent-address_view_only', 'Permanent Address View Only', NULL, now(), now()
FROM `permissions`
WHERE (`id` = '37');


-- ------------ 20-11-2018 --------------------
ALTER TABLE `payroll_months`
  ADD `queued_at` timestamp NULL AFTER `is_locked`,
  ADD `queue_start` timestamp NULL AFTER `queued_at`,
  ADD `queue_done` timestamp NULL AFTER `queue_start`;


-- end; updated in live server by Arnob Bhai-------------


-- ------------ 10-12-2018 --------------------
CREATE TABLE `loan_ledger_drafts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `loan_id` int(11) NOT NULL,
  `payroll_id` int(11) DEFAULT NULL,
  `employee_id` int(11) NOT NULL,
  `pay_date` date DEFAULT NULL,
  `principal_realization` float DEFAULT '0',
  `principal_balance` float DEFAULT '0',
  `interest_rate` float DEFAULT '0',
  `interest_charge` float DEFAULT '0',
  `interest_realization` float DEFAULT '0',
  `interest_balance` float NOT NULL DEFAULT '0',
  `total_balance` float NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `loan_category_id` int(11) DEFAULT NULL,
  `parent_loan_id` int(11) DEFAULT '0',
  `ref_no` varchar(255) DEFAULT NULL,
  `ref_date` date DEFAULT NULL,
  `loan_eff_date` date DEFAULT NULL,
  `loan_amount` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `payroll_employees_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `employee_data` varchar(1000) DEFAULT NULL,
  `bank_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `month_id` int(11) NOT NULL,
  `basic_pay` float NOT NULL DEFAULT '0',
  `tech_pay` float DEFAULT '0',
  `spl_pay` float DEFAULT '0',
  `house_alw` float DEFAULT '0',
  `med_alw` float DEFAULT '0',
  `f_bonus` float DEFAULT '0',
  `conv_alw` float NOT NULL DEFAULT '0',
  `wash_alw` float NOT NULL DEFAULT '0',
  `chrg_alw` float NOT NULL DEFAULT '0',
  `gas_alw` float NOT NULL DEFAULT '0',
  `ws_alw` float NOT NULL DEFAULT '0',
  `per_pay` float NOT NULL DEFAULT '0',
  `dearness` float NOT NULL DEFAULT '0',
  `tiffin_alw` float NOT NULL DEFAULT '0',
  `edu_alw` float NOT NULL DEFAULT '0',
  `pf_refund` float NOT NULL DEFAULT '0',
  `hb_refund` float NOT NULL DEFAULT '0',
  `vhl_refund` float NOT NULL DEFAULT '0',
  `salary_arr` float NOT NULL DEFAULT '0',
  `hr_arr` float NOT NULL DEFAULT '0',
  `depu_arr` float NOT NULL DEFAULT '0',
  `vhl_alw` float NOT NULL DEFAULT '0',
  `other_alw` float DEFAULT '0',
  `gross_pay` float DEFAULT '0',
  `prv_fund` float NOT NULL DEFAULT '0',
  `pf_loan` float NOT NULL DEFAULT '0',
  `pf_inttr` float NOT NULL DEFAULT '0',
  `hr_main` float NOT NULL DEFAULT '0',
  `hb_loan` float NOT NULL DEFAULT '0',
  `h_rent` float NOT NULL DEFAULT '0',
  `welfare` float NOT NULL DEFAULT '0',
  `trusty_fund` float NOT NULL DEFAULT '0',
  `ben_fund` float NOT NULL DEFAULT '0',
  `gr_insu` float NOT NULL DEFAULT '0',
  `elec_bill` float NOT NULL DEFAULT '0',
  `pc_inttr` float NOT NULL DEFAULT '0',
  `ws_ded` float NOT NULL DEFAULT '0',
  `titas_gas` float NOT NULL DEFAULT '0',
  `water_gov` float NOT NULL DEFAULT '0',
  `transport` float NOT NULL DEFAULT '0',
  `pf_refund_ded` float NOT NULL DEFAULT '0',
  `vhcl_loan` float NOT NULL,
  `vhcl_inttr` float NOT NULL DEFAULT '0',
  `hb_inttr` float NOT NULL DEFAULT '0',
  `it_ded` float NOT NULL DEFAULT '0',
  `dps_fee` float NOT NULL DEFAULT '0',
  `union_sub` float NOT NULL DEFAULT '0',
  `deas_fee` float NOT NULL DEFAULT '0',
  `dhak_usf` float NOT NULL DEFAULT '0',
  `sal_ded` float NOT NULL DEFAULT '0',
  `pc_loan` float NOT NULL DEFAULT '0',
  `other_ded` float NOT NULL DEFAULT '0',
  `day_sal` float NOT NULL DEFAULT '0',
  `total_ded` float NOT NULL DEFAULT '0',
  `rev_stamp` float NOT NULL DEFAULT '0',
  `net_payable` float NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `month_id` (`month_id`),
  KEY `bank_id` (`bank_id`),
  KEY `branch_id` (`branch_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `payroll_heads` (`id`, `title`, `type`, `in_short`, `db_field`, `order`, `active`, `is_deduction`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
      (1,	'Basic Pay',	'allowance',	'Basic Pay',	'basic_pay',	1,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (2,	'Technical Pay',	'allowance',	'Tech. Pay',	'tech_pay',	2,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (3,	'Special Pay',	'allowance',	'Spl. Pay',	'spl_pay',	3,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (4,	'House Rent Allowance',	'allowance',	'House Allw',	'house_alw',	4,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (5,	'Medical Allowance',	'allowance',	'Med. Allw',	'med_alw',	5,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (6,	'Festival Bonus',	'allowance',	'BNY/F.Bonus',	'f_bonus',	6,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (7,	'New Year Bonus',	'allowance',	'BNY/F.Bonus',	'f_bonus',	7,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (8,	'Conveyance Allowance',	'allowance',	'Conv. Allw',	'conv_alw',	8,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (9,	'Washing Allowance',	'allowance',	'Wash Allw',	'wash_alw',	9,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (10,	'Charge Allowance',	'allowance',	'chrg_alw',	'chrg_alw',	10,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (11,	'Gas Allowance',	'allowance',	'gas_alw',	'gas_alw',	11,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (12,	'Water & Sewer Allow.',	'allowance',	'ws_alw',	'ws_alw',	12,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (13,	'Personal Pay',	'allowance',	'per_pay',	'per_pay',	13,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (14,	'Dearness Allowance',	'allowance',	'dearness',	'dearness',	14,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (15,	'Tiffin Allowance',	'allowance',	'tiffin_alw',	'tiffin_alw',	15,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (16,	'Education Allowance',	'allowance',	NULL,	'edu_alw',	16,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (17,	'Provident Fund Refund',	'allowance',	NULL,	'pf_refund',	17,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (18,	'HBL Refund',	'allowance',	NULL,	'hb_refund',	18,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (19,	'Vehicle Refund',	'allowance',	NULL,	'vhl_refund',	19,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (20,	'Salary Arrear',	'allowance',	NULL,	'salary_arr',	20,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (21,	'House Rent Arrears',	'allowance',	NULL,	'hr_arr',	21,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (22,	'Deputation Allowance',	'allowance',	NULL,	'depu_arr',	22,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (23,	'Other Allowance',	'allowance',	NULL,	'vhl_alw',	23,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (24,	'Gross Pay',	'allowance',	NULL,	'gross_pay',	24,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (284,	'Provident Fund',	'deduction',	NULL,	'prv_fund',	284,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (285,	'House Rent',	'deduction',	NULL,	'h_rent',	285,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (286,	'House Rent Maintenance ',	'deduction',	NULL,	'hr_main',	286,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (287,	'Welfare',	'deduction',	NULL,	'welfare',	287,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (288,	'Trusty Fund',	'deduction',	NULL,	'trusty_fund',	288,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (289,	'Gr. Insurance',	'deduction',	NULL,	'gr_insu',	289,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (290,	'House Building Deduction',	'deduction',	NULL,	'hb_loan',	290,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (291,	'Electric Bill',	'deduction',	NULL,	'elec_bill',	291,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (292,	'W&S Deduction',	'deduction',	NULL,	'ws_ded',	292,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (293,	'Titas Gas Deduction',	'deduction',	NULL,	'titas_gas',	293,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (294,	'Water Govt.',	'deduction',	NULL,	'water_gov',	294,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (295,	'Transport',	'deduction',	NULL,	'transport',	295,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (296,	'DPS Fee',	'deduction',	NULL,	'dps_fee',	296,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (297,	'Union Sub',	'deduction',	NULL,	'union_sub',	297,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (298,	'DEAS Fee',	'deduction',	NULL,	'deas_fee',	298,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (299,	'DHAKUSF',	'deduction',	NULL,	'dhak_usf',	299,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (300,	'Salary Deduction',	'deduction',	NULL,	'sal_ded',	300,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (301,	'Provident Fund Advance',	'deduction',	NULL,	'pf_loan',	301,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (302,	'Provident Fund Interest',	'deduction',	NULL,	'pf_inttr',	302,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (303,	'HB Loan Deduction',	'deduction',	NULL,	'hb_loan',	303,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (304,	'HB Interest',	'deduction',	NULL,	'hb_inttr',	304,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (305,	'PC Loan',	'deduction',	NULL,	'pc_loan',	305,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (306,	'PC Interest',	'deduction',	NULL,	'pc_inttr',	306,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (307,	'Vehicle/Car Loan',	'deduction',	NULL,	'vhcl_loan',	307,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (308,	'Vehicle Interest',	'deduction',	NULL,	'vhcl_inttr',	308,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (309,	'Income Tax Deduction',	'deduction',	NULL,	'it_ded',	309,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (310,	'PF Refund',	'deduction',	NULL,	'pf_refund_ded',	310,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (311,	'Other Deduction',	'deduction',	NULL,	'other_ded',	311,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (312,	'1 Day Salary',	'deduction',	NULL,	'day_sal',	312,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (313,	'Rev. Stamp',	'deduction',	NULL,	'rev_stamp',	313,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (314,	'Total Deduction',	'deduction',	NULL,	'total_ded',	314,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
      (315,	'Net Payable',	'deduction',	NULL,	'net_payable',	315,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL);

ALTER TABLE payroll_months
ADD queue_status varchar(20) NULL AFTER waiting_job;


-- -----------Johnny---------------------------------

CREATE TABLE `pension_application_approval` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `application_id` INT(11) NOT NULL,
  `application_step` INT(11) NOT NULL,
  `approved_by` INT(11) NOT NULL COMMENT 'employee id',
  `approved_time` DATETIME NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `pension_application_author` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `application_id` INT(11) NOT NULL,
  `employee_department_id` INT(11) NOT NULL,
  `application_step` INT(11) NOT NULL,
  `author_id` INT(11) NOT NULL DEFAULT '0',
  `status` TINYINT(4) NOT NULL DEFAULT '1',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4;


CREATE TABLE `lab_chlorine_demand_sample_characteristic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lab_chlorine_demand_test_id` int(11) NOT NULL,
  `parameter_id` int(11) DEFAULT NULL,
  `value` varchar(200) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `lab_chlorine_demand_test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sample_name` varchar(200) DEFAULT NULL,
  `test_date` datetime DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;


CREATE TABLE `lab_chlorine_demand_test_concentration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lab_chlorine_demand_test_id` int(11) NOT NULL,
  `chlorine` varchar(200) DEFAULT NULL,
  `unit_id_for_chlorine` int(11) DEFAULT NULL,
  `volume` varchar(200) DEFAULT NULL,
  `unit_id_for_volume` int(11) DEFAULT NULL,
  `before_experiment` varchar(200) DEFAULT NULL,
  `unit_id_for_before_experiment` int(11) DEFAULT NULL,
  `after_experiment` varchar(200) DEFAULT NULL,
  `unit_id_for_after_experiment` int(11) DEFAULT NULL,
  `break_point_ration` varchar(200) DEFAULT NULL,
  `unit_of_break_point` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `lab_chlorine_demand_test_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lab_chlorine_demand_test_id` int(11) NOT NULL,
  `test_parameter_id` int(11) NOT NULL,
  `test_parameter_unit_id` int(11) NOT NULL,
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
  `test_13` varchar(200) DEFAULT NULL,
  `test_14` varchar(200) DEFAULT NULL,
  `test_15` varchar(200) DEFAULT NULL,
  `test_16` varchar(200) DEFAULT NULL,
  `test_17` varchar(200) DEFAULT NULL,
  `test_18` varchar(200) DEFAULT NULL,
  `test_19` varchar(200) DEFAULT NULL,
  `test_20` varchar(200) DEFAULT NULL,
  `test_21` varchar(200) DEFAULT NULL,
  `test_22` varchar(200) DEFAULT NULL,
  `test_23` varchar(200) DEFAULT NULL,
  `test_24` varchar(200) DEFAULT NULL,
  `test_25` varchar(200) DEFAULT NULL,
  `staus` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;


--------------- 31/1/2019 ---------------------------------
ALTER TABLE pension_application_approval ADD file_path VARCHAR(200) NULL AFTER approved_by;

INSERT INTO permissions (id, module_id, NAME, display_name, description, created_at, updated_at) VALUES (NULL, '3', 'assign_hod', 'Assign HOD', NULL, NULL, NULL);

CREATE TABLE lab_test_table_head (
  id INT(11) NOT NULL AUTO_INCREMENT,
  lab_chlorine_demand_test_id INT(11) NOT NULL,
  table_head VARCHAR(200) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=INNODB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;
------------------------------ Updated in live --------------------------
