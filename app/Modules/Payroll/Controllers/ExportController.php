<?php

namespace App\Modules\Payroll\Controllers;

use App\EmployeeProfile\Model\Department;
use App\EmployeeProfile\Model\DepartmentGroup;
use App\EmployeeProfile\Model\Employee;
use App\EmployeeProfile\Model\EmployeeEducation;
use App\Modules\Payroll\Models\Bonus;
use App\Modules\Payroll\Models\BonusEmployee;
use App\Modules\Payroll\Models\IfterBill;
use App\Modules\Payroll\Models\NightAllowance;
use App\Modules\Payroll\Models\Overtime;
use App\Modules\Payroll\Models\PayrollEmployee;
use App\Modules\Payroll\Models\PayrollHead;
use App\Modules\Payroll\Models\PayrollMonth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf;

//use Maatwebsite\Excel\Concerns\FromQuery;
//use Maatwebsite\Excel\Concerns\Exportable;
//
//class InvoicesExport implements FromQuery
//{
//    use Exportable;
//
//    public function query()
//    {
//        return Invoice::query();
//    }
//}
class ExportController extends Controller {

    public function downloadSalaryCsv($month_id)
    {
        $monthData = PayrollMonth::findOrFail($month_id);
        $results = DB::select("
        select  
       -- e.pfno, e.bank_account_no, e.employee_id, CONCAT_WS('',e.first_name,' ',e.middle_name,' ', e.last_name) name , 'June-2018' as salary_month, e.status,   	depu_arr as DeputationAllowance, 
    pe.employee_data, basic_pay as BasicPay, f_bonus as FastivalBonus, tech_pay as TechnicalPay,	spl_pay as SpecialPay,	house_alw as HouseAllowance,	med_alw as MedicalAllowance, conv_alw as Conveyance,
    wash_alw as WashAllowance,	chrg_alw as ChargeAllowance, gas_alw as GasAllowance, ws_alw as WaterSewerageAllowance,	per_pay as PersonalPay,
    dearness as DearnessAllowance,	tiffin_alw as TiffinAllowance,	edu_alw as EducationAllowance,	pf_refund as PFRefund,	hb_refund as HBRefund,
    vhl_refund as VehicleRefund,	salary_arr as SalaryArrear,	hr_arr as HRArrear, vhl_alw as VehicleAllowance,
    other_alw as OtherAllowance,	prv_fund as ProvidantFund,	pf_loan as PFLoanAdvance,	pf_inttr as PFInterest, ben_fund as BenevolentFund,
    hr_main as HRMaintenanceCharge,	hb_loan as HBDeduction, hb_inttr as HBInterest,	h_rent as HouseRentDeduction,	welfare as Welfare,	trusty_fund as TrustyFund,
    gr_insu as GroupInsurance,	elec_bill as ElectricBill,	ws_ded as WaterandSewerageDeduction, titas_gas as TitasGas,	water_gov as WaterGov,
    transport as TransportCharge,	pf_refund_ded as PFRefundDeduction,	vhcl_loan as VehicleLoan, vhcl_inttr as VehicleInterest,
    dps_fee as DPSFee,	union_sub as UnionSub,	deas_fee as DEASFee,	dhak_usf as DHAKUSFee,sal_ded as SalaryDeduction,pc_loan as PCLoan,
    pc_inttr as PCInterest, day_sal as OneDaySalaryDeduction,	other_ded as OthersDeduction,rev_stamp as RevenueStamp,it_ded as ITDeduct,it_arrear_ded as ITArrearDeduct,
    gross_pay as GrossPay, total_ded as TotalDeduction,net_payable as NetPayAmount
    from payroll_employees pe
    -- left join employees e on pe.employee_id=e.id
    where month_id='{$month_id}' and pe.deleted_at is null
  --   limit 10
  ");
        $results = array_map(function ($row) {

            $rowArray = (array) $row;
            $jsonData = (array) json_decode($rowArray['employee_data']);
            $result = [];
            $result['PFNO'] = $jsonData['pfno'];
            $result['Name'] = $jsonData['name'];
            $result['BankAccountNo'] = $jsonData['bank_acc'];
            $result['Grade'] = $jsonData['grade'];

//            if($jsonData['ds'] ==2 ) {
//                $designationStatus = ' (AC)';
//            }elseif($jsonData['ds'] ==3){
//                $designationStatus = ' (CC)';
//            }elseif($jsonData['ds'] ==4){
//                $designationStatus = ' (EC)';
//            }else{
//                $designationStatus = '';
//            }
//            $result['Designation'] = $jsonData['designation'] . $designationStatus;
            $result['Designation'] = $jsonData['designation'];
            $result['Department'] = $jsonData['department'];
            $result['GroupName'] = trim($jsonData['group_name']);
            $result['JoiningDate'] = $jsonData['joining_date'];
            $result['BankName'] = $jsonData['bank_name'];
            $result['BranchName'] = $jsonData['branch_name'];
            $result['Status'] = $jsonData['status'];

            unset($rowArray['employee_data']);
            $result += $rowArray;
            return $result;
        }, $results);

        $fileName = $monthData->title . ' Salary '.'('. $monthData->generate_count .') '. '.csv';

        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header('Content-Description: File Transfer');
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename={$fileName}");
        header("Expires: 0");
        header("Pragma: public");

        $fh = @fopen( 'php://output', 'w' );

        $headerDisplayed = false;


        foreach ( $results as $data ) {
            // Add a header row if it hasn't been added yet
            if ( !$headerDisplayed ) {
                // Use the keys from $data as the titles
                fputcsv($fh, array_keys($data));
                $headerDisplayed = true;
            }

            // Put the data into the stream
            fputcsv($fh, $data);
        }
        // Close the file
        fclose($fh);
        // Make sure nothing else is sent, our file is done
        exit;
    }

//    public function downloadBankPdf($month_id)
//    {
//        $monthData = PayrollMonth::findOrFail($month_id);
////        dd($monthData);
//
//        $results = DB::select("
//        select
//                pe.employee_data, basic_pay,	tech_pay,	spl_pay,	house_alw,	med_alw,	f_bonus,	conv_alw,
//                net_payable,
//                e.bank_account_no, e.bank_account_no_t24
//            from payroll_employees pe
//            left join employees e on pe.employee_id=e.id
//            where month_id='{$month_id}' and pe.deleted_at is null
//            and bank_id=27 and branch_id=8674
//            -- order by e.bank_account_no
//        -- limit 10
//        ");
//        $results = array_map(function ($position, $row) {
//            $rowArray = (array) $row;
//            $jsonData = (array) json_decode($rowArray['employee_data']);
//            $result = [];
//            $result['sl_no'] = ++$position;
////            $result['account_no'] = str_replace('AW','',$jsonData['bank_acc']);
//            $result['account_no'] = preg_replace('/[^0-9]/', '', $rowArray['bank_account_no']);
//            $result['t24_account_no'] = $rowArray['bank_account_no_t24'];
//            $result['name'] = $jsonData['name'];
//
//            if($jsonData['ds'] ==2 ) {
//                $designationStatus = ' (AC)';
//            }elseif($jsonData['ds'] ==3){
//                $designationStatus = ' (CC)';
//            }elseif($jsonData['ds'] ==4){
//                $designationStatus = ' (EC)';
//            }else{
//                $designationStatus = '';
//            }
//            $result['designation'] = $jsonData['designation'] . $designationStatus;
//            $result['net_payable'] = $rowArray['net_payable'];
//
//            return $result;
//        }, array_keys($results), $results);
//
//        $fileName = $monthData->title .'('. $monthData->is_generated .') '. date('YmdHis') . '.csv';
//
//        $mpdf = new mPDF([
//            'format' => 'A4-L',
//            'font-size' => 40,
//            'tempDir' => storage_path(),
//            'pagenumPrefix' => 'Page ',
//            'nbpgPrefix' => ' of ',
//            'nbpgSuffix' => '',
//            'margin_top' => '30',
//            'margin_left' => '5',
//            'margin_right' => '5',
//        ]);
//        $mpdf->SetTitle("Monthly Summery Report - WASA-Payroll");
//        $mpdf->SetAuthor("SSL Wireless");
//        $mpdf->SetDisplayMode('fullpage');
//        $mpdf->SetHtmlHeader(view('Payroll::report.header',compact('monthData')));
////        $mpdf->SetHtmlFooter(view('Payroll::pdf.footer'));
////        $mpdf->SetHeader('{PAGENO}{nbpg}');
//        $mpdf->AddPage('', '', 1);
//        $mpdf->WriteHTML($html);
//        $mpdf->Output($monthData->title.'-'.time().'.pdf','I'); exit;
//    }

    public function downloadSummery($month_id, $group_id, PayrollMonth $payrollMonth)
    {
        $monthData = PayrollMonth::findOrFail($month_id);
        $payrollHeads = PayrollHead::whereActive(1)->orderBy('order')->get(['title','db_field','type']);
        $departmentGroup = DepartmentGroup::findOrFail($group_id);

        $data = $payrollMonth->summeryList($month_id, $group_id);
        $data = collect($data)->first();
        $html = view('Payroll::report.head-summery', compact('data','monthData','payrollHeads','departmentGroup'));
//        return $html;

        $mpdf = new mPDF([
            'format' => 'A4-L',
            'font-size' => 40,
            'tempDir' => storage_path(),
            'pagenumPrefix' => 'Page ',
            'nbpgPrefix' => ' of ',
            'nbpgSuffix' => '',
            'margin_top' => '30',
            'margin_left' => '5',
            'margin_right' => '5',
        ]);
        $mpdf->SetTitle("Monthly Summery Report - WASA-Payroll");
        $mpdf->SetAuthor("SSL Wireless");
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHtmlHeader(view('Payroll::report.header',compact('monthData')));
//        $mpdf->SetHtmlFooter(view('Payroll::pdf.footer'));
//        $mpdf->SetHeader('{PAGENO}{nbpg}');
        $mpdf->AddPage('', '', 1);
        $mpdf->WriteHTML($html);
        $mpdf->Output($monthData->title.'-'.trim($departmentGroup->group_name).'.pdf','I'); exit;
    }
    public function downloadTotalSummery($month_id, PayrollMonth $payrollMonth)
    {
        $monthData = PayrollMonth::findOrFail($month_id);
        $payrollHeads = PayrollHead::whereActive(1)->orderBy('order')->get(['title','db_field','type']);
        $data = $payrollMonth->totalSummeryList($month_id);
        $data = collect($data)->first();
        $html = view('Payroll::report.total-head-summery', compact('data','monthData','payrollHeads'));
//        return $html;

        $mpdf = new mPDF([
            'format' => 'A4-L',
            'font-size' => 40,
            'tempDir' => storage_path(),
            'pagenumPrefix' => 'Page ',
            'nbpgPrefix' => ' of ',
            'nbpgSuffix' => '',
            'margin_top' => '30',
            'margin_left' => '5',
            'margin_right' => '5',
        ]);
        $mpdf->SetTitle("Monthly Summery Report - WASA-Payroll");
        $mpdf->SetAuthor("SSL Wireless");
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHtmlHeader(view('Payroll::report.header',compact('monthData')));
//        $mpdf->SetHtmlFooter(view('Payroll::pdf.footer'));
//        $mpdf->SetHeader('{PAGENO}{nbpg}');
        $mpdf->AddPage('', '', 1);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Summery of '.$monthData->title .'.pdf','I'); exit;
    }

//select
//sum(basic_pay) as basic_pay,
//sum(house_alw) as house_alw,
//sum(med_alw) as med_alw,
//sum(conv_alw) as conv_alw,
//sum(wash_alw) as wash_alw,
//sum(chrg_alw) as chrg_alw,
//sum(gas_alw) as gas_alw,
//sum(ws_alw) as ws_alw,
//sum(tiffin_alw) as tiffin_alw,
//sum(edu_alw) as edu_alw,
//sum(vhl_alw) as vhl_alw,
//sum(conv_alw) as conv_alw,
//sum(prv_fund) as prv_fund,
//sum(pf_loan) as pf_loan,
//sum(pf_inttr) as pf_inttr,
//sum(hb_loan) as hb_loan,
//
//count(pe.employee_id) as employees,
//sum(gross_pay) as gross_pay,
//sum(total_ded) as total_ded,
//sum(net_payable) as net_payable
//from payroll_employees pe
//left join employees e on pe.employee_id=e.id
//left join departments d on e.office_id=d.id
//where pe.deleted_at is null
//and month_id=10
//and d.department_group_id=3


//    public function getEmployeeListExcel(Request $request) {
////        ini_set('max_execution_time', 900); // 900=15min
////         if(!Auth::user()->can('excel_employee_list')){
////             abort(403);
////         }
//
//
//        $employeeController = new PayrollEmployee();
//        $select = [
//            'employees.*',
//        ];
//
//        $result = $employeeController->employeeList($request, True, $select);
//
//
//        foreach ($result as $employee) {
//            $designation = '';
//            $department = '';
//            $grade = '';
//            $job = $employee->experience;
//            if ($job) {
//                if ($job->designation) {
//                    $designation = $job->designation->title;
//                    if ($job->ds and $job->ds !=="1")
//                    {
//                        $designation .= ' - ' . getDesignatioStatusTitle($job->ds);
//                    }
//                }
//
//                if ($job->department)
//                    $department = $job->department->department_name;
//
//                if ($job->scale)
//                    $grade = $job->scale->grade;
//            }
//            $branch_name = '';
//            $bank_name = '';
//            if ($employee->bankName)
//                $bank_name = $employee->bankName->bank_name;
//
//            if ($employee->bankBranch)
//                $branch_name = $employee->bankBranch->branch_name;
//
//            $dataArray = [
//                "employee_id" => $employee->employee_id,
//                "pfno" => $employee->pfno,
//                "wasa_id" => $employee->wasa_id,
//                "full_Name" => $employee->first_name . ' ' . $employee->middle_name . ' ' . $employee->last_name,
//                "designation" => $designation,
//                "department" => $department,
//                "grade" => $grade,
//                "mobile" => $employee->mobile,
//                "email" => $employee->email,
//                "father_name" => $employee->father_name,
//                "mother_name" => $employee->mother_name,
//                "religion" => $employee->religion,
//                "gender" => $employee->gender,
//                "blood_group" => $employee->blood_group,
//                "marital_status" => $employee->marital_status,
//                "date_of_birth" => dateFormat($employee->date_of_birth),
//                "national_id" => $employee->nid,
//                "tin" => $employee->tin,
//                "place_of_birth" => $employee->place_of_birth,
//                "spouse_name" => $employee->spouse_name,
//                "spouse_qualification" => $employee->spouse_qualification,
//                "spouse_profession" => $employee->spouse_profession,
//                "personnel_file_no" => $employee->personnel_file_no,
//                "passport_no" => $employee->passport_no,
//                "bank_name" => $bank_name,
//                "branch_name" => $branch_name,
//                "bank_account_no" => $employee->bank_account_no,
//                "provident_fund_no" => $employee->provident_fund_no,
//                "current_basic_pay" => $employee->current_basic_pay,
//                "first_joining_date" => dateFormat($employee->first_joining_date),
//            ];
//
//            $permanentAddress = $employee->address->where('address_type', 'Permanent')->last();
//            $dataArray['permanent_division'] = isset($permanentAddress->division) ? $permanentAddress->division->name : '';
//            $dataArray['permanent_district'] = isset($permanentAddress->district) ? $permanentAddress->district->name : '';
//            $dataArray['permanent_thana'] = isset($permanentAddress->thana) ? $permanentAddress->thana->name : '';
//            $dataArray['permanent_post_office'] = isset($permanentAddress->postOffice) ? $permanentAddress->postOffice->name : '';
//            $dataArray['permanent_zip_code'] = isset($permanentAddress->postOffice) ? $permanentAddress->postOffice->zip_code : '';
//
//            $presentAddress = $employee->address->where('address_type', 'Present')->last();
//            $dataArray['present_division'] = isset($presentAddress->division) ? $presentAddress->division->name : '';
//            $dataArray['present_district'] = isset($presentAddress->district) ? $presentAddress->district->name : '';
//            $dataArray['present_thana'] = isset($presentAddress->thana) ? $presentAddress->thana->name : '';
//            $dataArray['present_post_office'] = isset($presentAddress->postOffice) ? $presentAddress->postOffice->name : '';
//            $dataArray['present_zip_code'] = isset($presentAddress->postOffice) ? $presentAddress->postOffice->zip_code : '';
//
//            $data[] = $dataArray;
//        }
//
//        Excel::create('Employee List', function($excel) use($data) {
//            $excel->sheet('Employee List', function($sheet) use($data) {
//                $sheet->setOrientation('landscape');
//                $sheet->fromArray($data);
//            });
//        })->export('xls');
//
//    }
    public function downloadDepartmentReport($month_id, $department_id)
    {
        $monthData = PayrollMonth::findOrFail($month_id);
        $data = PayrollEmployee::where(['month_id'=>$month_id,'office_id'=> $department_id]) ->get();
        $department = Department::findOrFail($department_id);
        $html = view("Payroll::pdf.department-monthly-salary-export-pdf", compact('data','monthData','department'));

        $mpdf = new mPDF([
            'format' => 'A4-L',
            'font-size' => 40,
            'tempDir' => storage_path(),
            'pagenumPrefix' => 'Page ',
            'nbpgPrefix' => ' of ',
            'nbpgSuffix' => '',
            'margin_top' => '30',
            'margin_left' => '5',
            'margin_right' => '5',
        ]);
        $mpdf->SetTitle("Monthly Salary Report - WASA-Payroll");
        $mpdf->SetAuthor("SSL Wireless");
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHtmlHeader(view('Payroll::pdf.header',compact('monthData','department')));
        $mpdf->SetHtmlFooter(view('Payroll::pdf.footer'));
//        $mpdf->SetHeader('{PAGENO}{nbpg}');
        $mpdf->AddPage('', '', 1);
        $mpdf->WriteHTML($html);
        $mpdf->Output($department->department_name.'-'.$monthData->title.'.pdf','I'); exit;
    }
    public function downloadDepartmentSummery($month_id,PayrollMonth $payrollMonth)
    {
        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '-1');
        ini_set("pcre.backtrack_limit", "5000000");
        $monthData = PayrollMonth::findOrFail($month_id);

        $data = $payrollMonth->departmentSummeryList($month_id);

        $html = view("Payroll::pdf.department-monthly-salary-summery-pdf", compact('data','monthData'));
//        return $html;
        $mpdf = new mPDF([
            'format' => 'A4-L',
            'font-size' => 40,
            'tempDir' => storage_path(),
            'pagenumPrefix' => 'Page ',
            'nbpgPrefix' => ' of ',
            'nbpgSuffix' => '',
            'margin_top' => '30',
            'margin_left' => '5',
            'margin_right' => '5',
        ]);
        $mpdf->SetTitle("Department Salary Summery - WASA-Payroll");
        $mpdf->SetAuthor("SSL Wireless");
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHtmlHeader(view('Payroll::pdf.departmentSummeryHeader',compact('monthData')));
        $mpdf->SetHtmlFooter(view('Payroll::pdf.footer'));
//        $mpdf->SetHeader('{PAGENO}{nbpg}');
        $mpdf->AddPage('', '', 1);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Department Summery'.'-'.$monthData->title.'.pdf','I'); exit;
    }
// bonus report
    public function downloadBonusCsv($bonus_id)
    {
        $bonus = Bonus::findOrFail($bonus_id);

        $results = DB::select("select employee_data, basic_pay as BasicPay, bonus as FestivalBonus ,rev_stamp as RevenueStamp ,net_payable as NetPayAmount 
                from bonus_employees  where bonus_id='{$bonus_id}' and deleted_at is null
                ");
        $results = array_map(function ($row) {

            $rowArray                   = (array) $row;
            $jsonData                   = (array) json_decode($rowArray['employee_data']);
            $result                     = [];
            $result['PFNO']             = $jsonData['pfno'];
            $result['Name']             = $jsonData['name'];
            $result['BankAccountNo']    = $jsonData['bank_acc'];
            $result['Grade']            = $jsonData['grade'];

            if($jsonData['ds'] ==2 ) {
                $designationStatus = ' (AC)';
            }elseif($jsonData['ds'] ==3){
                $designationStatus = ' (CC)';
            }elseif($jsonData['ds'] ==4){
                $designationStatus = ' (EC)';
            }else{
                $designationStatus = '';
            }
            $result['Designation']      = $jsonData['designation'] . $designationStatus;
            $result['Department']       = $jsonData['department'];
            $result['GroupName']        = trim($jsonData['group_name']);
            $result['JoiningDate']      = $jsonData['joining_date'];
            $result['BankName']         = $jsonData['bank_name'];
            $result['BranchName']       = $jsonData['branch_name'];
            $result['Status']           = $jsonData['status'];
            $result['FestivalBonus']    = $rowArray['FestivalBonus'];
            $result['RevenueStamp']     = $rowArray['RevenueStamp'];
            $result['NetPayAmount']     = $rowArray['NetPayAmount'] > 0 ? $rowArray['NetPayAmount'] : $rowArray['FestivalBonus'] ;
            //            unset($rowArray['employee_data']);
            //            $result += $rowArray;
            return $result;
        }, $results);

        $fileName = $bonus->title .'('. $bonus->generate_count .') '. date('YmdHis') . '.csv';

        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header('Content-Description: File Transfer');
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename={$fileName}");
        header("Expires: 0");
        header("Pragma: public");

        $fh = @fopen( 'php://output', 'w' );

        $headerDisplayed = false;


        foreach ( $results as $data ) {
            // Add a header row if it hasn't been added yet
            if ( !$headerDisplayed ) {
                // Use the keys from $data as the titles
                fputcsv($fh, array_keys($data));
                $headerDisplayed = true;
            }

            // Put the data into the stream
            fputcsv($fh, $data);
        }
        // Close the file
        fclose($fh);
        // Make sure nothing else is sent, our file is done
        exit;
    }
    public function downloadTotalBonusSummery($month_id, Bonus $festivalBonus)
    {
        $bonusData = Bonus::findOrFail($month_id);
        $data = $festivalBonus->totalSummeryList($month_id);
        $data = collect($data)->first();

        $html = view('Payroll::report.bonus-summery', compact('data','bonusData'));
//        return $html;

        $mpdf = new mPDF([
            'format' => 'A4-L',
            'font-size' => 40,
            'tempDir' => storage_path(),
            'pagenumPrefix' => 'Page ',
            'nbpgPrefix' => ' of ',
            'nbpgSuffix' => '',
            'margin_top' => '30',
            'margin_left' => '5',
            'margin_right' => '5',
        ]);
        $mpdf->SetTitle("Festival Bonus Summery Report - WASA-Payroll");
        $mpdf->SetAuthor("SSL Wireless");
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHtmlHeader(view('Payroll::report.bonus-header',compact('bonusData')));
        $mpdf->AddPage('', '', 1);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Summery of '.$bonusData->title .'.pdf','I'); exit;
    }
    public function downloadBonusSummery($bonusId, $group_id, Bonus $festivalBonus)
    {
        $bonusData = Bonus::findOrFail($bonusId);
        $departmentGroup = DepartmentGroup::findOrFail($group_id);

        $data = $festivalBonus->summeryList($bonusId, $group_id);

        $data = collect($data)->first();
        $html = view('Payroll::report.bonus-summery', compact('data','bonusData','departmentGroup'));
//        return $html;

        $mpdf = new mPDF([
            'format' => 'A4-P',
            'font-size' => 40,
            'tempDir' => storage_path(),
            'pagenumPrefix' => 'Page ',
            'nbpgPrefix' => ' of ',
            'nbpgSuffix' => '',
            'margin_top' => '30',
        ]);
        $mpdf->SetTitle("Festival Bonus Report - WASA-Payroll");
        $mpdf->SetAuthor("SSL Wireless");
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHtmlHeader(view('Payroll::report.bonus-header',compact('bonusData')));

        $mpdf->AddPage('', '', 1);
        $mpdf->WriteHTML($html);
        $mpdf->Output($bonusData->title.'-'.time().'.pdf','I'); exit;
    }
    public function downloadBonusDepartmentReport($bonusId, $department_id)
    {
        $bonusData = Bonus::findOrFail($bonusId);
        $data = BonusEmployee::where(['bonus_id'=>$bonusId,'office_id'=> $department_id]) ->get();
        $department = Department::findOrFail($department_id);
        $html = view("Payroll::pdf.department-bonus-export-pdf", compact('data','bonusData','department'));

        $mpdf = new mPDF([
            'format' => 'A4-P',
            'font-size' => 40,
            'tempDir' => storage_path(),
            'pagenumPrefix' => 'Page ',
            'nbpgPrefix' => ' of ',
            'nbpgSuffix' => '',
            'margin_top' => '30',
        ]);
        $mpdf->SetTitle("Festival Bonus Report - WASA-Payroll");
        $mpdf->SetAuthor("SSL Wireless");
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHtmlHeader(view('Payroll::pdf.bonus_header',compact('bonusData','department')));
        $mpdf->SetHtmlFooter(view('Payroll::pdf.footer'));

        $mpdf->AddPage('', '', 1);
        $mpdf->WriteHTML($html);
        $mpdf->Output($department->department_name.'-festival bonus-'.$bonusData->title.'.pdf','I'); exit;
    }
    public function downloadBonusDepartmentSummery($bonus_id,Bonus $festivalBonus)
    {
        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '-1');
        ini_set("pcre.backtrack_limit", "5000000");
        $monthData = Bonus::findOrFail($bonus_id);

        $data = $festivalBonus->departmentSummeryList($bonus_id);
//dd($data);
//        $department = Department::whereStatus(1)->where('id','!=',123)->orderBy('department_name','asc')->get();

        $html = view("Payroll::pdf.department-bonus-summery-pdf", compact('data','monthData'));
//        return $html;
        $mpdf = new mPDF([
            'format' => 'A4-L',
            'font-size' => 40,
            'tempDir' => storage_path(),
            'pagenumPrefix' => 'Page ',
            'nbpgPrefix' => ' of ',
            'nbpgSuffix' => '',
            'margin_top' => '30',
            'margin_left' => '5',
            'margin_right' => '5',
        ]);
        $mpdf->SetTitle("Department Bonus  Summery - WASA-Payroll");
        $mpdf->SetAuthor("SSL Wireless");
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHtmlHeader(view('Payroll::pdf.departmentBonusSummeryHeader',compact('monthData')));
        $mpdf->SetHtmlFooter(view('Payroll::pdf.footer'));
//        $mpdf->SetHeader('{PAGENO}{nbpg}');
        $mpdf->AddPage('', '', 1);
        $mpdf->WriteHTML($html);
        $mpdf->Output("Department Summery"."-".$monthData->title.".pdf",'I'); exit;
    }
// bonus report
    public function downloadOvertimeDepartmentReport($id,$department_id = false) {
        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '-1');
        ini_set("pcre.backtrack_limit", "5000000");

        DB::enableQueryLog();
        $overtime = Overtime::findOrFail($id);
        $title = $overtime->title;
        $sheetTitle = "OVERTIME  SHEET";
        $departments = Department::with(['overtimeEmployee'=>function ($query) use ($id) {
            $query->where('overtime_id',$id);
        }])->where('status',1)->orderby('department_name','asc');
        if($department_id){
            $departments =  $departments->where('id',$department_id);
        }
        $departments =  $departments->get();

        if (!isset($departments)) {
            return redirect()->back()->withErrors('No data found');
        }

        $html = (view("Payroll::pdf.overtime", compact('departments','department_id','title','overtime')));
        //die();
//          return $html;
        $mpdf = new Mpdf([
            'format' => 'A4-L',
            'font-size' => 40,
            'tempDir' => storage_path(),
            'pagenumPrefix' => 'Page ',
            'nbpgPrefix' => ' of ',
            'nbpgSuffix' => '',
            'margin_top' => '45',
        ]);
        $mpdf->SetTitle('Overtime '.$title." - WASA");
        $mpdf->SetAuthor("SSL Wireless");
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHtmlHeader(view('Payroll::pdf.commonAllowanceHeader',compact('title','sheetTitle','department_id')));
        $mpdf->AddPage('', '', 1);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Overtime '.$title.'.pdf', 'I');
        exit;
    }
    public function downloadNightAllowanceDepartmentReport($id,$department_id = false) {
        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '-1');
        ini_set("pcre.backtrack_limit", "5000000");

        DB::enableQueryLog();
        $nightAllowance = NightAllowance::findOrFail($id);
        $title = $nightAllowance->title;
        $sheetTitle = "NIGHT ALLOWANCE SHEET";
        $departments = Department::with(['nightAllowanceEmployee'=>function ($query) use ($id) {
            $query->where('night_allowance_id',$id);
        }])->where('status',1)->orderby('department_name','asc');
        if($department_id){
            $departments =  $departments->where('id',$department_id);
        }
        $departments =  $departments->get();

        if (!isset($departments)) {
            return redirect()->back()->withErrors('No data found');
        }

        $html = (view("Payroll::pdf.night_allowance", compact('departments','department_id','title','nightAllowance')));
        //die();
//          return $html;
        $mpdf = new Mpdf([
            'format' => 'A4-L',
            'font-size' => 40,
            'tempDir' => storage_path(),
            'pagenumPrefix' => 'Page ',
            'nbpgPrefix' => ' of ',
            'nbpgSuffix' => '',
            'margin_top' => '45',
        ]);
        $mpdf->SetTitle('Night Allowance '.$title." - WASA");
        $mpdf->SetAuthor("SSL Wireless");
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHtmlHeader(view('Payroll::pdf.commonAllowanceHeader',compact('title','sheetTitle','department_id')));
        $mpdf->AddPage('', '', 1);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Night Allowance '.$title. '.pdf', 'I');
        exit;
    }
    public function downloadIfterBillDepartmentReport($id,$department_id = false) {
        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '-1');
        ini_set("pcre.backtrack_limit", "5000000");

        DB::enableQueryLog();
        $ifterBill = IfterBill::findOrFail($id);
        $title = $ifterBill->title;
        $sheetTitle = "IFTER BILL SHEET";
        $departments = Department::with(['ifterBillEmployee'=>function ($query) use ($id) {
            $query->where('ifter_bill_id',$id);
        }])->where('status',1)->orderby('department_name','asc');
        if($department_id){
            $departments =  $departments->where('id',$department_id);
        }
        $departments =  $departments->get();

        if (!isset($departments)) {
            return redirect()->back()->withErrors('No data found');
        }

        $html = (view("Payroll::pdf.ifter_bill", compact('departments','department_id','title','ifterBill')));
        //die();
//          return $html;
        $mpdf = new Mpdf([
            'format' => 'A4-L',
            'font-size' => 40,
            'tempDir' => storage_path(),
            'pagenumPrefix' => 'Page ',
            'nbpgPrefix' => ' of ',
            'nbpgSuffix' => '',
            'margin_top' => '45',
        ]);
        $mpdf->SetTitle('Ifter Bill'.$title." - WASA");
        $mpdf->SetAuthor("SSL Wireless");
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHtmlHeader(view('Payroll::pdf.commonAllowanceHeader',compact('title','sheetTitle','department_id')));
        $mpdf->AddPage('', '', 1);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Ifter Bill '.$title. '.pdf', 'I');
        exit;
    }
}
