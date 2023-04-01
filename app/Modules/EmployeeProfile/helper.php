<?php

use App\Modules\Pension\Models\PensionMonthly;

/**
 *    EmployeeProfile Helper
 */
function get_sex_array()
{
    return array('' => 'Sex', 'Male' => 'Male', 'Female' => 'Female', 'Others' => 'Others');
}

function get_marital_tatus_array()
{
    return array('' => 'Marital Status', 'Married' => 'Married', 'Unmarried' => 'Unmarried', 'Widow' => 'Widow', 'Divorce' => 'Divorce');
}

function get_blood_grouop_array()
{
    return array('' => 'Blood Group', 'A+' => 'A+', 'A-' => 'A-', 'B+' => 'B+', 'B-' => 'B-', 'O+' => 'O+', 'O-' => 'O-', 'AB+' => 'AB+', 'AB-' => 'AB-');
}

function get_discipline_array()
{
//    $data = [('Engineering' => 'Engineering', 'Medical' => 'Medical', 'Science' => 'Science', 'Arts' => 'Arts', 'Commerce' => 'Commerce', 'Class-VIII' => 'Class-VIII', 'Others' => 'Others');
    $data = [
        "Arts" => "Arts",
        "Class-VIII" => "Class-VIII",
        "Commerce" => "Commerce",
        "Engineering" => "Engineering",
        "Medical" => "Medical",
        "Others" => "Others",
        "Science" => "Science",
    ];
    asort($data);
    $data = array_merge(['' => 'Select Discipline'], $data);
//    dd($data);
    return $data;
}

function get_qualification_array()
{
    return ['' => 'Select Qualification'] + \App\EmployeeProfile\Model\Qualification::pluck('title', 'id')->all();
}

function get_suspension_type_array()
{
    return array('suspension' => 'Suspension', 'withdrawn' => 'Withdrawn');
}

function get_religion_array()
{
    return array('' => 'Religion',
        'Islam' => 'Islam',
        'Hinduism' => 'Hinduism',
        'Christian' => 'Christian',
        'Buddha' => 'Buddha',
        'Other' => 'Other'
    );
}
function get_gpf_report_array()
{
    return array('' => 'Select Report Type',
        'pf_refund' => 'Provident Fund Refund (Allowance)',
        'prv_fund'  => 'Provident Fund (Deduction)',
        'pf_loan'   => 'Provident Fund Advance (Deduction)',
        'pf_inttr'  => 'Provident Fund Interest (Deduction)',
    );
}
function get_deduction_info_array()
{
    return array('' => 'Select Deduction Type',
        'hb_loan'   => 'HB Loan Deduction',
        'h_rent'    => 'House Rent Deduction',
        'titas_gas' => 'Titas Gas Deduction',
        'it_ded'    => 'Income Tax Deduction',
        'dps_fee'   => 'DPS Fee Deduction',
        'union_sub' => 'Union Sub Deduction',
        'deas_fee'  => 'DEAS Fee Deduction',
        'dhak_usf'  => 'DHAKUSF Deduction',
    );
}
if (!function_exists('get_status_array')) {
    function get_status_array()
    {
        return [
            "" => "Status",
            "Continue" => "Continue",
            "Lien" => "Lien",
            "OSD" => "OSD",
            "PRL" => "PRL",
            "Suspended" => "Suspended",
            "Dead" => "Dead",
            "Dismissed/Removed" => "Dismissed/Removed",
            "Salary Stopped"    => "Salary Stopped",
        ];
    }
}
if (!function_exists('get_class_array')) {
function get_class_array()
{
    return array(
        ''    => 'Select Class',
        '1'   => 'Class-1',
        '2'   => 'Class-2',
        '3'   => 'Class-3',
        '4'   => 'Class-4',
    );
}
}
function get_country_array()
{
//	return \App\Modules\Location\Models\Country::selectRaw("CONCAT(name,' (',code,')') as c_name,id")->where('status',1)->pluck('name','name');
    return ['' => 'Country'] + \App\Modules\Location\Models\Country::where('status', 1)->orderBy('name')->pluck('name', 'name')->all();
}

function get_membership_organization()
{
    return \App\EmployeeProfile\Model\MembershipOrganization::orderBy('title')->get();
}

function get_office_zone($placeholder = 'Office/Zone')
{
    return ['' => $placeholder] + App\EmployeeProfile\Model\Department::orderBy('department_name', 'ASC')->where('id','!=',123)->pluck('department_name', 'id')->all();
}

function get_designation()
{
//    return ['' => 'Designation'] + \App\EmployeeProfile\Model\Designation::orderBy('title', 'asc')->whereStatus(1)->pluck('title', 'id')->all();
    return \App\EmployeeProfile\Model\Designation::orderBy('title', 'asc')->whereStatus(1)->pluck('title', 'id')->all();
}

function get_bank_list()
{
    return ['' => 'Bank'] + \App\Modules\EmployeeProfile\Models\Bank::whereStatus(1)->orderBy('bank_name', 'ASC')->pluck('bank_name', 'id')->all();
}

function get_scale()
{
    $data = ['' => 'Pay Scale'] + App\Modules\GeneralConfiguration\Models\PayScaleList::select('id', DB::raw("concat('Grade-',grade,'-',group_concat(scale ORDER BY scale ASC)) as scale"))->groupBy('grade')->orderBy('grade', 'asc')->whereStatus(1)->pluck('scale', 'id')->all();

    return $data;
}

function get_scale_new()
{
    $data = ['' => 'Pay Scale'] + App\Modules\GeneralConfiguration\Models\PayScaleList::
        select('id', DB::raw("concat('Grade-',grade,'-',group_concat(scale ORDER BY scale ASC)) as scale"))
            ->groupBy('grade')
//            ->groupBy('scale')

            ->orderBy('grade', 'asc')->whereStatus(1)->pluck('scale', 'id')->all();

    return $data;
}

function get_scale_by_year($year)
{
    $data = App\Modules\GeneralConfiguration\Models\PayScaleList::select('id', DB::raw("concat('Grade-',grade,'-',group_concat(scale ORDER BY scale ASC)) as scale"))->groupBy('grade')->orderBy('grade', 'asc')->whereStatus(1)->whereScaleYear($year)->pluck('scale', 'id')->all();

    return $data;
}

function get_scale_year()
{
    return ['' => 'Scale Year'] + App\Modules\GeneralConfiguration\Models\PayScaleList::select('scale_year')->groupBy('scale_year')->orderBy('scale_year', 'desc')->pluck('scale_year', 'scale_year')->all();
}

function getScaleByGrade($grade, $scaleYear)
{
//    $data = App\Modules\GeneralConfiguration\Models\PayScaleList::select('id', "scale")->orderBy('scale', 'asc')->whereStatus(1)->whereGrade($grade)->whereScaleYear($scaleYear)->pluck('scale', 'id')->all();
    $data = App\Modules\GeneralConfiguration\Models\PayScaleList::select('id', "scale")->orderBy('serial', 'asc')->whereStatus(1)->whereGrade($grade)->whereScaleYear($scaleYear)->pluck('scale', 'scale');
    return $data;
}

function get_district()
{
    return ['' => 'District'] + \App\Modules\Location\Models\District::orderBy('name', 'asc')->pluck('name', 'id')->all();
}

function get_division()
{
    return ['' => 'Division'] + \App\Modules\Location\Models\Division::orderBy('name', 'asc')->pluck('name', 'id')->all();
}

function get_thana()
{
    return ['' => 'Thana'] + \App\Modules\Location\Models\Thana::orderBy('name', 'asc')->pluck('name', 'id')->all();
}

function get_post_office()
{
    return ['' => 'Post Office'] + \App\Modules\Location\Models\PostOffice::orderBy('name', 'asc')->pluck('name', 'id')->all();
}

function get_file_types()
{
    if (Auth::user()->hasRole('pensionadmin')) {
        return ['' => 'File Type'] + \App\EmployeeProfile\Model\FileType::whereSelectable(2)->orderBy('title', 'ASC')->pluck('title', 'id')->all();
    } else {
        return ['' => 'File Type'] + \App\EmployeeProfile\Model\FileType::whereSelectable(1)->orderBy('title', 'ASC')->pluck('title', 'id')->all();
    }
}

function dateFormat($date, $format = 'd-m-Y')
{
    if (is_null($date)) {
        return "";
    }
    return date($format, strtotime($date));
}

function changeDateFormatToDb($date)
{
    if (is_null($date)) {
        return null;
    }
    $date = str_replace('/', '-', $date);
    return date('Y-m-d', strtotime($date));
}

function getGradeList()
{
    $i = 1;
    $grade = [];
    for ($i = 1; $i <= 20; $i++) {
        $grade[$i] = $i;
    }

    return $grade;
}

function getDesignationStatus()
{
    return \App\DesignationStatus::orderBy('order')->pluck('title', 'id')->toArray();
}

function getUniversityType()
{
    return array(
        '' => 'Univrsity Type',
        'Private' => 'Private',
        'Public' => 'Public'
    );
}

function getUniversityList()
{
    return ['' => 'University'] + App\Modules\GeneralConfiguration\Models\University::where('status', 1)->orderBy('name', 'ASC')->pluck('name', 'name')->toArray();
}

function getBoardList()
{
    return array(
        '' => 'Board',
        'Barisal' => 'Barisal',
        'Chittagong' => 'Chittagong',
        'Comilla' => 'Comilla',
        'Dhaka' => 'Dhaka',
        'Dinajpur' => 'Dinajpur',
        'Rajshahi' => 'Rajshahi',
        'Jessore' => 'Jessore',
        'Sylhet' => 'Sylhet',
        'Madrasah' => 'Madrasah'
    );
}

function getPlaceOfBirth()
{
    return ['' => 'Place Of Birth'] + \App\Modules\Location\Models\District::orderBy('name', 'asc')->pluck('name', 'name')->all();
}

function taka_format($amount = 0)
{
    $tmp = explode('.', $amount);  // for float or double values
    $strMoney = '';
    $amount = $tmp[0];
    $strMoney .= substr($amount, -3, 3);
    $amount = substr($amount, 0, -3);
    while (strlen($amount) > 0) {
        $strMoney = substr($amount, -2, 2) . ',' . $strMoney;
        $amount = substr($amount, 0, -2);
    }

    if (isset($tmp[1])) {         // if float and double add the decimal digits here.
        return $strMoney . '.' . $tmp[1];
    }
    return $strMoney;
}

// masud
function get_age_by_date_of_birth($date_of_birth, $custom_date = null)
{
    $date = new \DateTime($date_of_birth);
    if (!is_null($custom_date)) {
        //dd($custom_date);
        $days = cal_days_in_month(CAL_GREGORIAN, $custom_date['month'], $custom_date['year']);
        //dd($days);
        $final_custom_date = $custom_date['year'] . '-' . $custom_date['month'] . '-' . $days;
        //dd($final_custom_date);
        $now = new \DateTime($final_custom_date);
    } else {
        $now = new \DateTime();
    }
    $interval = $now->diff($date);
    return $interval;
}

function get_employee_last_basic_pay($emp_id)
{
    $basic_pay = \App\EmployeeProfile\Model\EmployeeWasaJobExperience::select('basic_pay')->where('employee_id', $emp_id)->orderBy('joining_date', 'DESC')->first();
    if (count($basic_pay) > 0) {
        return $basic_pay->basic_pay;
    }
    return null;
}

function get_employee_service_time_period($emp_id, $birth_day)
{
    $dt = \Carbon\Carbon::parse($birth_day);
    $total_time = $dt->addYears(58)->addMonths(9)->format('Y-m-d');
    $first_joining_date = \App\EmployeeProfile\Model\EmployeeWasaJobExperience::select('joining_date')->where('employee_id', $emp_id)->orderBy('joining_date', 'ASC')->first();
    if (count($first_joining_date) > 0) {
        $date = new \DateTime($first_joining_date->joining_date);
        $now = new \DateTime($total_time);
        $interval = $now->diff($date);
        return $interval->y;
    }
    return null;
}

function get_pension_percent_by_service_time($service_time)
{
    $all_percents = \App\Modules\Pension\Models\PensionableTimePeriodYear::where('status', 1)->get();

    if (count($all_percents) > 0) {
        $max = 0;
        $max_obj = [];
        foreach ($all_percents as $all_percent) {
            if ($all_percent->title > $max) {
                $max = $all_percent->title;
                $max_obj = $all_percent;
            }
            if ($service_time == $all_percent->title) {
                return ($all_percent->get_percentage ? $all_percent->get_percentage->id : null);
            }
        }
        if ($service_time > $max_obj->title) {
            return ($max_obj->get_percentage ? $max_obj->get_percentage->id : null);
        }
    }
    return null;
}

function get_gratuity_by_service_time($service_time)
{
    $all_years = \App\Modules\Pension\Models\GratuityYear::where('status', 1)->get();

    if (count($all_years) > 0) {
        foreach ($all_years as $all_year) {
            if (is_null($all_year->max_year) and ($service_time >= $all_year->min_year)) {
                return ($all_year->get_value ? $all_year->get_value->id : null);
            }
            if (($service_time >= $all_year->min_year) and ($service_time < $all_year->max_year)) {
                return ($all_year->get_value ? $all_year->get_value->id : null);
            }
        }
    }
    return null;
}

function get_pay_able_amount($percent_id, $gratuity_id, $last_basi_pay)
{
    $percent = \App\Modules\Pension\Models\PensionableTimePeriodPercentage::where('status', 1)->findOrFail($percent_id);
    $gratuity = \App\Modules\Pension\Models\GratuityValue::where('status', 1)->findOrFail($gratuity_id);
    $amount = 0;
    $amount = (($last_basi_pay * $percent->percent) / 2) * $gratuity->value;
    return $amount;
}

function get_medical_allowance($age)
{
    $medical_allowance = 0;
    if ($age >= 65) {
        $medical_allowance = 2500;
    } elseif ($age < 65) {
        $medical_allowance = 1500;
    }
    return $medical_allowance;
}

function get_branch_list($bank_id = '')
{
    if ($bank_id) {
        return ['' => 'Branch'] + \App\Modules\EmployeeProfile\Models\BankBranch::where('bank_id', $bank_id)->orderBy('branch_name')->pluck('branch_name', 'id')->all();
    } else {
        return ['' => 'Branch'] + \App\Modules\EmployeeProfile\Models\BankBranch::orderBy('branch_name', 'ASC')->pluck('branch_name', 'id')->all();
    }
}

function relations()
{
    $relation = ['Father', 'Mother', 'Brother', 'Sister', 'Husband', 'Wife', 'Children-Male', 'Children-Female', 'Uncle', 'Aunt', 'Others'];
    $relation = array_combine($relation, $relation);
//    asort($relation);
    return $relation;
}

function get_pension_type()
{
    return ['' => 'Pension Type'] + \App\EmployeeProfile\Model\PensionType::orderBy('type', 'ASC')->pluck('type', 'id')->all();
}

function get_holder_type()
{
    return ['' => 'Pension Holder Type', 'Self' => 'Self', 'Family' => 'Family'];
}

function get_quarter_location_dropdown()
{
    return ['' => 'Quarter Location'] + \App\Modules\Location\Models\QuarterLocation::select('location')->orderBy('location', 'ASC')->pluck('location', 'location')->all();
}

function objExist($object)
{
    return isset($object) ? $object : '';
}

function engToBanNumber($input)
{
    $bn_digits = array('০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯');
    return $output = str_replace(range(0, 9), $bn_digits, $input);
}

function engDateToBanDate($currentDate)
{

    $engDATE = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 0, "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December", "Saturday", "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday");
    $bangDATE = array('১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '০', 'জানুয়ারী', 'ফেব্রুয়ারী', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর', 'শনিবার', 'রবিবার', 'সোমবার', 'মঙ্গলবার', '
        বুধবার', 'বৃহস্পতিবার', 'শুক্রবার'
    );
    return str_replace($engDATE, $bangDATE, $currentDate);
}

function get_quota()
{
    return App\Modules\GeneralConfiguration\Models\Quota::where('status', 1)->pluck('name', 'id')->toArray();
}

function get_leave_type()
{
    return ['' => 'Leave Type'] + \App\Modules\GeneralConfiguration\Models\LeaveType::pluck('title', 'id')->all();
}

//function get_status()
//{
//    return ['' => 'Status'] + \App\EmployeeProfile\Model\Employee::select('status')->groupBy('status')->pluck('status', 'status')->all();
//}
if (!function_exists('get_status')) {
    function get_status()
    {
        return [
//            ""                  => "Status",
            "Continue"          => "Continue",
            "Lien"              => "Lien",
            "OSD"               => "OSD",
            "PRL"               => "PRL",
            "Retirement"        => "Retirement",
            "Suspended"         => "Suspended",
            "New"               => "New",
            "Dead"              => "Dead",
            "Dismissed/Removed" => "Dismissed/Removed",
            "Salary Stopped"    => "Salary Stopped",
        ];
    }
}
function getDesignationRanking($designationId)
{
    if (is_null($designationId)) {
        return null;
    }
    $ranking = \App\EmployeeProfile\Model\Designation::select('ranking_id')->where('id', $designationId)->first();
    if ($ranking) {
        return $ranking->ranking_id;
    } else {
        return null;
    }
}

function getDesignationStatusOrder($designationStatusId)
{
    if (is_null($designationStatusId)) {
        return null;
    }
    $designationStatusOrder = \App\DesignationStatus::where('id', $designationStatusId)->first();
    if ($designationStatusOrder) {
        return $designationStatusOrder->order;
    } else {
        return null;
    }
}

function getDesignatioStatusTitle($designationStatusId)
{
    if (!$designationStatusId) {
        return '';
    }


    $data = \App\DesignationStatus::select('title')->where('id', $designationStatusId)->first();
    if ($data) {
        return $data->title;
    } else {
        return '';
    }
}

function getAgeYearMonth($date)
{
    $datetime1 = new DateTime($date);
    $datetime2 = new DateTime(date('Y-m-d'));
    $interval = $datetime1->diff($datetime2);
    echo $interval->format('%y years %m months and %d days');
}

function isFresherPensionar($employeeId)
{
    if (App\Modules\Pension\Models\PensionMonthly::where('employee_id', $employeeId)->exists()) {
        //this employee is not fresher
        return false;
    } else {
        //yes this employee is fresher
        return true;
    }
}

function isFresher15PlusPensioner($date_time)
{
    if ($date_time) {
        if (date('m', strtotime($date_time)) == date('m')) {
            return true;
        }
    }

    return false;
}