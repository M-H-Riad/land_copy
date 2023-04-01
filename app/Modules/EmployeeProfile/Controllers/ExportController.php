<?php

namespace App\Modules\EmployeeProfile\Controllers;

use App\DownloadExcel;
use App\EmployeeProfile\Model\Department;
use App\EmployeeProfile\Model\Designation;
use App\EmployeeProfile\Model\Employee;
use App\EmployeeProfile\Model\EmployeeEducation;
use App\Jobs\ExportExcleEmployee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Mpdf\Mpdf;
use Auth;

class ExportController extends Controller {

    public function downloadExcelList(){

        $data['employeeExcel'] = DownloadExcel::where('type','Employee List')->orderBy('id','desc')->paginate(20);
        return view("EmployeeProfile::download_employee_excel", $data);
    }
    public function pdfProfile($id) {
        if (!Auth::user()->can('export_cv')) {
            abort(403);
        }
        $employee = Employee::findOrFail($id);
        // $html = (view("EmployeeProfile::pdf.profile_27_Nov_2017", compact('employee')));
        $html = (view("EmployeeProfile::pdf.profile", compact('employee')));

        $defaultConfig = (new ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $mpdf = new mPDF([
            'tempDir' => storage_path(),
            'mode' => 'utf-8',
            'format' => 'A4',
            'fontDir' => array_merge($fontDirs, [
                public_path('fonts'),
            ]),
            'fontdata' => $fontData + [
        'solaimanlipi' => [
            'R' => "SolaimanLipi.ttf",
            'useOTL' => 0xFF,
        ],
//                    'nikosh' => [
//                        'R' => "Nikosh.ttf",
//                        'useOTL' => 0xFF,
//                    ]
            ],
            'default_font' => 'solaimanlipi'
//            'default_font' => 'nikosh'
        ]);

        $mpdf->SetProtection(array('print'));
        $mpdf->SetTitle("Employee Profile - WASA-PMIS");
        $mpdf->SetAuthor("SSL Wireless");
        $mpdf->SetDisplayMode('fullpage');

        $mpdf->WriteHTML($html);
        $mpdf->Output($employee->employee_id . '.pdf', 'I');
        exit;
    }

    public function getEmployeeListExcel(Request $request) {
        try {
            ini_set('max_execution_time', 900); // 900=15min

            $fileName = 'EmployeeList-' . date('d-m-Y-h:i:s');
            $downloadLink = url("downloads/export-excel/$fileName.xls");
            //user request for all employe in excel. It will take too much time. so send the request to job;
            $downloadExcel = new DownloadExcel();
            $downloadExcel->type = 'Employee List';
            $downloadExcel->url = $downloadLink;
            $downloadExcel->save();
            $data['fileName'] = $fileName;
            $data['downloadExcel'] = $downloadExcel->id;
            $data['request'] = $request->all();

            $job = (new ExportExcleEmployee($data));
            dispatch($job);
//            dispatch(new \App\Jobs\ExportExcleEmployee($data));

            return redirect('employee-excel-download')->with('success', 'Your request is under processing.');
        }catch (\Exception $e){
            Log::error(($e->getMessage()));
        }

    }

    /**
     * undocumented function
     *
     * @return void
     * @author Risul Islam risul321@gmail.com
     * */
    public function getEmployeeListExcelBasic(Request $request) {
        $employeeController = new EmployeeProfileController();
        $select = ['employees.*',];
        $result = $employeeController->employeeList($request, True, $select);

        foreach ($result as $employee) {
            $designation = '';
            $department = '';
            $grade = '';
            $job = $employee->experience;
            if ($job) {
                if ($job->designation) {
                    $designation = $job->designation->title;
                    if ($job->designation_status and $job->designation_status !=="1")
                    {
                        $designation .= ' - ' . getDesignatioStatusTitle($job->designation_status);
                    }
                }
                if ($job->department)
                    $department = $job->department->department_name;
                if ($job->scale)
                    $grade = $job->scale->grade;
            }

            $dataArray = [
                "Employee id" => $employee->employee_id,
                "Wasa id" => $employee->wasa_id,
                "PF no" => $employee->pfno,
                "Name" => $employee->first_name . ' ' . $employee->middle_name . ' ' . $employee->last_name,
                "Age" => $employee->date_of_birth->diff(\Carbon\Carbon::now())->format('%y years %m Months'),
                "Designation" => $designation,
                "Department" => $department,
                "Joining Date" => $employee->firstExperience->joining_date,
                "Grade" => $grade,
                "Date of Birth" => $employee->date_of_birth->format('d-m-Y'),
                "NID" => $employee->nid,
            ];

            $data[] = $dataArray;
        }

        Excel::create('Employee Basic List', function($excel) use($data) {
            $excel->sheet('Employee List', function($sheet) use($data) {
                $sheet->setOrientation('landscape');
                $sheet->fromArray($data);
            });
        })->export('xls');
    }
    public function getEmployeeListPdf(Request $request) {
//        ini_set('max_execution_time', 300);
//        ini_set('memory_limit', '-1');
//        ini_set("pcre.backtrack_limit", "5000000");
        $employeeController = new EmployeeProfileController();
        $select = [
            'employees.*',
        ];
        DB::enableQueryLog();

        $result = $employeeController->employeeList($request, true, $select);
//dd(DB::getQueryLog());
//dd($result->toArray());
        foreach ($result as $employee) {

            $designation = '';
            $department = '';
            $grade = '';
            $job = $employee->experience;
//            dd($job);
            if ($job) {
                if ($job->designation) {
                    $designation = $job->designation->title;
                    if ($job->designation_status and $job->designation_status !=="1")
                    {
                        $designation .= ' - ' . getDesignatioStatusTitle($job->designation_status);
                    }
                }

                if ($job->department)
                    $department = $job->department->department_name;

                if ($job->scale)
                    $grade = $job->scale->grade;
            }
            $branch_name = '';
            $bank_name = '';
            if ($employee->bankName)
                $bank_name = $employee->bankName->bank_name;

            if ($employee->bankBranch)
                $branch_name = $employee->bankBranch->branch_name;

            $dataArray = [
                "employee id" => $employee->employee_id,
                "pfno" => $employee->pfno,
                "wasa id" => $employee->wasa_id,
                "full_Name" => $employee->first_name . ' ' . $employee->middle_name . ' ' . $employee->last_name,
                "designation" => $designation,
                "department" => $department,
                "joining_date" => ($employee->firstExperience) ? $employee->firstExperience->joining_date : '',
                "grade" => $grade,
                "mobile" => $employee->mobile,
                "email" => $employee->email,
                "father_name" => $employee->father_name,
                "mother_name" => $employee->mother_name,
                "religion" => $employee->religion,
                "gender" => $employee->gender,
                "blood_group" => $employee->blood_group,
                "marital_status" => $employee->marital_status,
                "date_of_birth" => $employee->date_of_birth->format('d-m-Y'),
                "national_id" => $employee->nid,
                "tin" => $employee->tin,
                "place_of_birth" => $employee->place_of_birth,
                "spouse_name" => $employee->spouse_name,
                "spouse_qualification" => $employee->spouse_qualification,
                "spouse_profession" => $employee->spouse_profession,
                "personnel_file_no" => $employee->personnel_file_no,
                "passport_no" => $employee->passport_no,
                "bank_name" => $bank_name,
                "branch_name" => $branch_name,
                "bank_account_no" => $employee->bank_account_no,
                "provident_fund_no" => $employee->provident_fund_no,
                "current_basic_pay" => $employee->current_basic_pay,
                "first_joining_date" => $employee->first_joining_date,
            ];

            $education = EmployeeEducation::where('employee_id', $employee->id)->orderBy('passing_year', 'DESC')->first();
            $dataArray["qualification"] = ($education != null && $education->qualification_id != null) ? $education->qualification->title : '';
            $permanentAddress = $employee->address->where('address_type', 'Permanent')->last();
            $dataArray['permanent_division'] = isset($permanentAddress->division) ? $permanentAddress->division->name : '';
            $dataArray['permanent_district'] = isset($permanentAddress->district) ? $permanentAddress->district->name : '';
            $dataArray['permanent_thana'] = isset($permanentAddress->thana) ? $permanentAddress->thana->name : '';
            $dataArray['permanent_post_office'] = isset($permanentAddress->postOffice) ? $permanentAddress->postOffice->name : '';
            $dataArray['permanent_zip_code'] = isset($permanentAddress->postOffice) ? $permanentAddress->postOffice->zip_code : '';
            $dataArray['permanent_mobile'] = isset($permanentAddress->mobile) ? $permanentAddress->mobile : '';

            $presentAddress = $employee->address->where('address_type', 'Present')->last();
            $dataArray['present_division'] = isset($presentAddress->division) ? $presentAddress->division->name : '';
            $dataArray['present_district'] = isset($presentAddress->district) ? $presentAddress->district->name : '';
            $dataArray['present_thana'] = isset($presentAddress->thana) ? $presentAddress->thana->name : '';
            $dataArray['present_post_office'] = isset($presentAddress->postOffice) ? $presentAddress->postOffice->name : '';
            $dataArray['present_zip_code'] = isset($presentAddress->postOffice) ? $presentAddress->postOffice->zip_code : '';
            $dataArray['present_mobile'] = isset($presentAddress->mobile) ? $presentAddress->mobile : '';

            $data[] = $dataArray;
        }

        if (!isset($data)) {
            return redirect()->back()->withErrors('No data found');
        }
        $title = 'List of Employee';
        // $html = (view("EmployeeProfile::pdf.profile_27_Nov_2017", compact('employee')));
        $html = (view("EmployeeProfile::pdf.employeeList", compact('data')));
        //die();
//        return $html;

        $mpdf = new Mpdf([
            'format' => 'A4-L',
            'font-size' => 40,
            'tempDir' => storage_path(),
            'pagenumPrefix' => 'Page ',
            'nbpgPrefix' => ' of ',
            'nbpgSuffix' => '',
            'margin_top' => '45',
        ]);
        $mpdf->SetTitle($title." - WASA-PMIS");
        $mpdf->SetAuthor("SSL Wireless");
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHtmlHeader(view('EmployeeProfile::pdf.employeeListHeader',compact('title')));
        $mpdf->AddPage('', '', 1);
        $mpdf->WriteHTML($html);
        $mpdf->Output($title.'-' . date('Y-m-d') . '.pdf', 'I');
        exit;
    }
    public function getReligionEmployeeListPdf(Request $request) {
        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '-1');
        ini_set("pcre.backtrack_limit", "5000000");
        $this->validate($request, [
            "religion" => "required"
            ]);
        DB::enableQueryLog();
        $title = 'List of Employee';
        $designations = Designation::with(['employee' => function ($query) use ($request) {
            if($request->religion){
                if($request->religion){
                    if($request->religion == 'Hinduism'){
                        $query->whereIn('religion',[$request->religion,'Hindu']);
                    }else if($request->religion == 'Buddha'){
                        $query->whereIn('religion',[$request->religion,'Buddhist']);
                    }else{
                        $query->where('religion', $request->religion);
                    }
                }
            }
            if($request->status){
                $query->where('status', $request->status);
            }
        }])->where('status',1)->where('id','!=','1')->orderby('title','asc')->get();

        if (!isset($designations)) {
            return redirect()->back()->withErrors('No data found');
        }
        if($request->religion =='Islam' ) {

            $title = 'List of  Muslim Employee';
        }elseif($request->religion =='Hinduism' ){
            $title = 'List of  Hindu Employee';
        }elseif($request->religion =='Buddha' ){
            $title = 'List of  Buddhist Employee';
        }elseif($request->religion){
            $title = 'List of  '.$request->religion.' Employee';

        }
        $html = (view("EmployeeProfile::pdf.employee_list_religion", compact('designations')));
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
        $mpdf->SetTitle($title." - WASA-PMIS");
        $mpdf->SetAuthor("SSL Wireless");
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHtmlHeader(view('EmployeeProfile::pdf.employeeListHeader',compact('title')));
        $mpdf->AddPage('', '', 1);
        $mpdf->WriteHTML($html);
        $mpdf->Output($title.'-' . date('Y-m-d') . '.pdf', 'I');
        exit;
    }

    public function getEmployeeListPDFBasic(Request $request) {
        $employeeController = new EmployeeProfileController();
        $select = ['employees.*',];
        $result = $employeeController->employeeList($request, True, $select);

        foreach ($result as $employee) {
            $designation = '';
            $department = '';
            $grade = '';
            $job = $employee->experience;
            if ($job) {
                if ($job->designation) {
                    $designation = $job->designation->title;
                    if ($job->designation_status and $job->designation_status !=="1")
                    {
                        $designation .= ' - ' . getDesignatioStatusTitle($job->designation_status);
                    }
                        
                }
                if ($job->department)
                    $department = $job->department->department_name;
                if ($job->scale)
                    $grade = $job->scale->grade;
            }

            $dataArray = [
                "employee_id" => $employee->employee_id,
                "pf_no" => $employee->pfno,
                "wasa_id" => $employee->wasa_id,
                "full_Name" => $employee->first_name . ' ' . $employee->middle_name . ' ' . $employee->last_name,
                "age" => $employee->date_of_birth->diff(\Carbon\Carbon::now())->format('%y years %m Months'),
                "designation" => $designation,
                "department" => $department,
                "joining_date" => ($employee->firstExperience) ? $employee->firstExperience->joining_date : '',
                "grade" => $grade,
                "date_of_birth" => $employee->date_of_birth->format('d-m-Y'),
                "nid" => $employee->nid,
            ];

            $data[] = $dataArray;
        }

        if (!count($data) > 0) {
            return redirect()->back()->withErrors('No data found');
        }
        $title = 'List of Employee';

        $html = (view("EmployeeProfile::pdf.employeeListBasic", compact('data')));

        $mpdf = new Mpdf([
            'format' => 'A4-L',
            'font-size' => 40,
            'tempDir' => storage_path(),
            'pagenumPrefix' => 'Page ',
            'nbpgPrefix' => ' of ',
            'nbpgSuffix' => '',
            'margin_top' => '45',
        ]);
        $mpdf->SetTitle($title." - WASA-PMIS");
        $mpdf->SetAuthor("SSL Wireless");
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHtmlHeader(view('EmployeeProfile::pdf.employeeListHeader',compact('title')));
        $mpdf->AddPage('', '', 1);
        $mpdf->WriteHTML($html);
        $mpdf->Output($title.'-' . date('Y-m-d') . '.pdf', 'I');
        exit;
    }


}
