<?php

/**
 * 	LoanApplication Helper  
 */
if (!function_exists("get_loan_status")) {

    function get_loan_status($default = false) {
        if ($default) {
            return [
                'Rejected' => 'Rejected',
                'Approved' => 'Approved',
            ];
        }
        return [
            'Pending' => 'Pending',
            'Rejected' => 'Rejected',
            'Approved' => 'Approved',
            'Withdraw' => 'Withdraw',
        ];
    }

}

if (!function_exists("get_color_by_loan_status")) {

    function get_color_by_loan_status($status = 'Pending') {

        $defaultColors = [
            'Pending' => 'warning',
            'Rejected' => 'danger',
            'Approved' => 'success',
            'Withdraw' => 'danger',
            'Waiting for HOD' => 'warning',
            'Waiting for Admin' => 'warning',
            'Waiting for Committee' => 'warning',
            'Waiting for AS' => 'warning',
            'Waiting for Secretary' => 'warning',
            'Waiting for DS' => 'warning',
            'Waiting for LDA' => 'warning',
        ];

        return $defaultColors[$status] ?? 'warning';
    }

}

if (!function_exists("get_loan_approver_type")) {

    function get_loan_approver_type($status = true) {

        $defaultType = [
            'Witness' => 'Witness',
            'Guarantor' => 'Guarantor',
            'Admin' => 'Admin',
            'MD' => 'MD',
        ];

        return $defaultType;
    }

}
if (!function_exists("get_loan_committee_user_type")) {

    function get_loan_committee_user_type() {

        $defaultType = [
//            'Admin' => 'Admin',
//            'Committee' => 'Committee',
            'Office Super' => 'Office Super',
            'AS' => 'AS',
            'DS' => 'DS',
            'Secretary' => 'Secretary',
            'MD' => 'MD',
            'DMD' => 'DMD',
            'Accounts' => 'Accounts',
//            'DS Admin' => 'DS Admin',
//            'LDA' => 'LDA',
        ];

        return $defaultType;
    }

}

function get_loan_category_by_id($id) {
    return \App\Modules\LoanManagement\Models\LoanCategories::where('status', 1)->where('id', $id)->pluck('title', 'id')->toArray();
}

if (!function_exists("get_committee_status")) {

    function get_committee_status() {
        return [
            'Active' => 'Active',
            'Inactive' => 'Inactive',
        ];
    }

}


if (!function_exists("setStartDateEndDate")) {

    function setStartDateEndDate($start_date, $end_date, $format = "Y-m-d H:i:s") {

        if ($start_date) {
            $date = new \DateTime($start_date);
            $start_date = $date->format($format);
        }
        if ($end_date) {
            $date = new \DateTime($end_date);
            $end_date = $date->format($format);
        }

        if ((isset($start_date) && $start_date != null ) && ( isset($end_date) && $end_date != null )) {
            if ($start_date > $end_date) {
                $tempDate = $start_date;
                $start_date = $end_date;
                $end_date = $tempDate;
            }
        } else if ((isset($start_date) && $start_date != null ) && ( isset($end_date) && $end_date == null )) {
            $start_date = $start_date;
            $end_date = $start_date;
        } else {
            $start_date = $end_date;
            $end_date = $end_date;
        }

        return ['from' => $start_date, 'to' => $end_date];
    }

}

// All loan statues
//==========================

const LOAN_STATUS_PENDING = "Pending";
const LOAN_STATUS_APPROVED = "Approved";
const LOAN_STATUS_REJECTED = "Rejected";
const LOAN_STATUS_WITHDRAW = "Withdraw";
const LOAN_STATUS_WAITING_FOR_HOD = "Waiting for HOD";
const LOAN_STATUS_WAITING_FOR_ADMIN = "Waiting for Admin";
const LOAN_STATUS_WAITING_FOR_COMMITTEE = "Waiting for Committee";
const LOAN_STATUS_WAITING_FOR_OFFICE_SUPER = "Waiting for Office Super";
const LOAN_STATUS_WAITING_FOR_AS = "Waiting for AS";
const LOAN_STATUS_WAITING_FOR_DS = "Waiting for DS";
const LOAN_STATUS_WAITING_FOR_SECRETARY = "Waiting for Secretary";
const LOAN_STATUS_WAITING_FOR_MD = "Waiting for MD";
const LOAN_STATUS_WAITING_FOR_DMD = "Waiting for DMD";
const LOAN_STATUS_WAITING_FOR_DS_ADMIN = "Waiting for DS (Admin)";
const LOAN_PENDING_OFFICE_ORDER = "Pending Office Order";
const LOAN_STATUS_WAITING_FOR_ACCOUNTS = "Waiting for Accounts";
const LOAN_STATUS_WAITING_FOR_LDA = "Waiting for LDA";
// All approvers
//==========================
const LOAN_APPROVER_WITNESS = "Witness";
const LOAN_APPROVER_GUARANTOR = "Guarantor";
const LOAN_APPROVER_HOD = "HOD";
const LOAN_APPROVER_ADMIN = "Admin";
const LOAN_APPROVER_COMMITTEE = "Committee";
const LOAN_APPROVER_OFFICE_SUPER = "Office Super";
const LOAN_APPROVER_AS = "AS";
const LOAN_APPROVER_DS = "DS";
const LOAN_APPROVER_SECRETARY = "Secretary";
const LOAN_APPROVER_MD = "MD";
const LOAN_APPROVER_DMD = "DMD";
const LOAN_APPROVER_ACCOUNTS = "Accounts";
const LOAN_APPROVER_DS_ADMIN = "DS Admin";
const LOAN_APPROVER_LDA = "LDA";



