
<-- 18.11.2020-->
CREATE TABLE `loan_applications` (
`id` int(10) UNSIGNED NOT NULL,
`employee_id` int(10) UNSIGNED NOT NULL,
`pfno` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`loan_category_id` int(10) UNSIGNED NOT NULL,
`loan_amount` int(11) DEFAULT NULL,
`max_loan_amount` int(11) DEFAULT NULL,
`loan_eff_date` date DEFAULT NULL,
`status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending' COMMENT 'Pending, Approved, Reject',
`created_by` int(10) UNSIGNED DEFAULT NULL,
`updated_by` int(10) UNSIGNED DEFAULT NULL,
`deleted_by` int(10) UNSIGNED DEFAULT NULL,
`deleted_at` timestamp NULL DEFAULT NULL,
`created_at` timestamp NULL DEFAULT NULL,
`updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `loan_applications`
ADD PRIMARY KEY (`id`);

ALTER TABLE `loan_applications`
MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;


CREATE TABLE `loan_approves` (
`id` int(10) UNSIGNED NOT NULL,
`loan_application_id` int(10) UNSIGNED NOT NULL,
`approver_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Guarantor,Witness, MD, DMD, Admin',
`approver_id` int(10) UNSIGNED DEFAULT NULL,
`status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending' COMMENT 'Pending, Rejected, Approved',
`remarks` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`created_at` timestamp NULL DEFAULT NULL,
`updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE `loan_approves`
ADD PRIMARY KEY (`id`);

ALTER TABLE `loan_approves`
MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;


INSERT INTO `permissions` (`module_id`,`name`, `display_name`, `description`, `created_at`, `updated_at`)
VALUES ('7','loan_application', 'Loan Application', 'Allow user to apply Loan Application', NULL, NULL);

INSERT INTO `permissions` (`module_id`,`name`, `display_name`, `description`, `created_at`, `updated_at`)
VALUES ('7','loan_application_approve_witness_guarantor', 'Loan Application manage by Witness & Guarantor', 'Allow Witness & Guarantor user to manage waiting Loan', NULL, NULL);


CREATE TABLE `loan_approval_histories` (
`id` int(10) UNSIGNED NOT NULL,
`loan_application_id` int(10) UNSIGNED NOT NULL,
`loan_approve_id` int(10) UNSIGNED DEFAULT NULL,
`approver_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`approved_by` int(10) UNSIGNED DEFAULT NULL,
`remarks` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`loan_status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`status` int(11) NOT NULL DEFAULT 1,
`created_at` timestamp NULL DEFAULT NULL,
`updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE `loan_approval_histories`
ADD PRIMARY KEY (`id`);

ALTER TABLE `loan_approval_histories`
MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

INSERT INTO `permissions` (`module_id`,`name`, `display_name`, `description`, `created_at`, `updated_at`)
VALUES ('7','loan_application_history', 'Loan Application History ', 'Allow user to see Loan Application History', NULL, NULL);

INSERT INTO `permissions` (`module_id`,`name`, `display_name`, `description`, `created_at`, `updated_at`)
VALUES ('7','manage_all_loan_applications', 'All Loan Applications Waiting to Admin Approval', 'Allow admin user to approve All Loan Applications after witness and guarantor approval', NULL, NULL);


<--- 25-11-2020 --->

INSERT INTO `permissions` (`module_id`,`name`, `display_name`, `description`, `created_at`, `updated_at`)
VALUES ('7','manage_loan_committee_setup', 'Loan Committee Setup', 'Allow users to setup loan committee', NULL, NULL);


CREATE TABLE `loan_committees` (
`id` int(10) UNSIGNED NOT NULL,
`employee_id` int(10) UNSIGNED NOT NULL,
`user_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
`joined_at` date DEFAULT NULL,
`end_at` date DEFAULT NULL,
`status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
`created_by` int(10) UNSIGNED DEFAULT NULL,
`deleted_by` int(10) UNSIGNED DEFAULT NULL,
`deleted_at` timestamp NULL DEFAULT NULL,
`created_at` timestamp NULL DEFAULT NULL,
`updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE `loan_committees`
ADD PRIMARY KEY (`id`);

ALTER TABLE `loan_committees`
MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;


<--  26-11-2020 -->

INSERT INTO `permissions` (`module_id`,`name`, `display_name`, `description`, `created_at`, `updated_at`)
VALUES ('7','committee_manage_all_loan_applications', 'Allow committee users to manage waiting loan', 'Allow committee users to manage waiting loan', NULL, NULL);

INSERT INTO `permissions` (`module_id`,`name`, `display_name`, `description`, `created_at`, `updated_at`)
VALUES ('7','as_user_manage_all_loan_applications', 'Allow AS users to manage waiting loan', 'Allow AS users to manage waiting loan', NULL, NULL);


INSERT INTO `permissions` (`module_id`,`name`, `display_name`, `description`, `created_at`, `updated_at`)
VALUES ('7','ds_user_manage_all_loan_applications', 'Allow DS users to manage waiting loan', 'Allow DS users to manage waiting loan', NULL, NULL);

INSERT INTO `permissions` (`module_id`,`name`, `display_name`, `description`, `created_at`, `updated_at`)
VALUES ('7','secretary_manage_all_loan_applications', 'Allow Secretary users to manage waiting loan', 'Allow Secretary users to manage waiting loan', NULL, NULL);

INSERT INTO `permissions` (`module_id`,`name`, `display_name`, `description`, `created_at`, `updated_at`)
VALUES ('7','md_manage_all_loan_applications', 'Allow MD users to manage waiting loan', 'Allow MD users to manage waiting loan', NULL, NULL);

INSERT INTO `permissions` (`module_id`,`name`, `display_name`, `description`, `created_at`, `updated_at`)
VALUES ('7','dmd_manage_all_loan_applications', 'Allow DMD users to manage waiting loan', 'Allow DMD users to manage waiting loan', NULL, NULL);

