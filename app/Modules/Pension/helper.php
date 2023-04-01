<?php

/**
 * 	Pension Helper
 */
function get_pension_fund_statuss(){
    return ['0' => 'Holded Pension','1' => 'Active Pension'];
}
function get_year_dropdown($status = 1) {
    return \App\Modules\Pension\Models\PensionableTimePeriodYear::selectRaw("CONCAT(title,' Year') as title,id")->where('status', $status)->pluck('title', 'id');
}

function get_gratuity_year_dropdown($status = 1) {
    return \App\Modules\Pension\Models\GratuityYear::selectRaw("case when max_year IS NULL or max_year = ''
      then CONCAT(min_year,' year or greater')
      else  CONCAT(min_year,' year or greater',' but less then ',max_year)
       end as title,id")->where('status', $status)->pluck('title', 'id');
}

function get_pension_application_status() {
    return ['1' => 'Pending', '2' => 'Bank Info Updated', '3' => 'Done'];
}

function monthName($index) {
    $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    return $months[$index - 1];
}

function sendCustomMessage2($sms) {

    // $url="http://sms.sslwireless.com/pushapi/dynamic/server.php"; $param="user=".config('app.sms_user')."&pass=".config('app.sms_password')."&sms[0][0]= 880XXXXXXXXXX &sms[0][1]=".urlencode("Test SMS 1")."&sms[0][2]=123456789&sms[1][0]= 880XXXXXXXXXX &sms[1][1]=".urlencode("Test SMS &2")."&sms[1][2]=123456790&sid=".config('app.sid');

    $url = "http://sms.sslwireless.com/pushapi/dynamic/server.php";
    $param = "user=" . config('app.sms_user') . "&pass=" . config('app.sms_password') . "$sms&sid=" . config('app.sms_sid');
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($crl, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($crl, CURLOPT_URL, $url);
    curl_setopt($crl, CURLOPT_HEADER, 0);
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($crl, CURLOPT_POST, 1);
    curl_setopt($crl, CURLOPT_POSTFIELDS, $param);
    $response = curl_exec($crl);
    curl_close($crl);
    Log::info($response);
}

function get_tables_column_name_array(){
    return [
        'ppo_no' => 'PPO No',
        //
        'employee_full_name' => 'Employee Name',
        'nid' => 'NID',
        'religion' => 'Religion',
        'date_of_birth' => 'Date Of Birth',
        //
        'type' => 'Pension Type',
        'pension_holder_name' => 'Pension Holder Name',
        'mobile_no' => 'Mobile Number',
        'present_address' => 'Present Address',
        'permanent_address' => 'Permanent Address',
        'pension_holder_type' => 'Pension Holder Type',
        'opening_net_pension' => 'Opening Net Pension',
        'current_net_pension' => 'Current Net Pension',
        'date_of_retirement' => 'Date Of Retirement',
        'previous_date' => 'Previous Pension Date',
        'expire_date' => 'Expire Date',
        'bank_name' => 'Bank Name',
        'branch_name' => 'Branch Name',
        'branch_code' => 'Branch Code',
        'account_no_t24' => 'Bank Account No (T24)',
        'account_no_old' => 'Bank Old Account No',
        'account_holder_name' => 'Bank Account Holder Name',
    ];
}

function convert_number_to_sentence($number)
{
    $my_number = $number;
    if (($number < 0) || ($number > 999999999))
    {
        return "Number is out of range";
    }
    $Kt = floor($number / 10000000); /* Koti/Crore */
    $number -= $Kt * 10000000;
    $Gn = floor($number / 100000);  /* lakh  */
    $number -= $Gn * 100000;
    $kn = floor($number / 1000);     /* Thousands (kilo) */
    $number -= $kn * 1000;
    $Hn = floor($number / 100);      /* Hundreds (hecto) */
    $number -= $Hn * 100;
    $Dn = floor($number / 10);       /* Tens (deca) */
    $n = $number % 10;               /* Ones */
    $res = "";
    if ($Kt)
    {
        $res .= convert_number_to_sentence($Kt) . " Crore ";
    }
    if ($Gn)
    {
        $res .= convert_number_to_sentence($Gn) . " Lac";
    }
    if ($kn)
    {
        $res .= (empty($res) ? "" : " ") .
        convert_number_to_sentence($kn) . " Thousand";
    }
    if ($Hn)
    {
        $res .= (empty($res) ? "" : " ") .
        convert_number_to_sentence($Hn) . " Hundred";
    }
    $ones = array("", "One", "Two", "Three", "Four", "Five", "Six",
        "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen",
        "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen",
        "Nineteen");
    $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty",
        "Seventy", "Eighty", "Ninety");
    if ($Dn || $n)
    {
        if (!empty($res))
        {
            $res .= " ";
        }
        if ($Dn < 2)
        {
            $res .= $ones[$Dn * 10 + $n];
        }
        else
        {
            $res .= $tens[$Dn];
            if ($n)
            {
                $res .= " " . $ones[$n];
            }
        }
    }
    if (empty($res))
    {
        $res = "zero";
    }
    return $res;
}
