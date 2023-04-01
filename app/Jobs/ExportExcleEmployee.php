<?php

namespace App\Jobs;

use App\DownloadExcel;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Storage;
use Excel;
use App\EmployeeProfile\Model\Employee;
use App\Modules\EmployeeProfile\Controllers\EmployeeProfileController;

class ExportExcleEmployee implements ShouldQueue {

    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $fileName;
    private $downloadExcelId;
    private $request;

    public function __construct($data) {

        $this->fileName        = $data['fileName'];
        $this->downloadExcelId =  $data['downloadExcel'];
        $this->request         =  $data['request'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        Log::info("employee excel start.. ");
        ini_set('memory_limit', '250M');
//        $employeeController = new EmployeeProfileController();

        $result = $this->__getData();

        foreach ($result as $employee) {
            $designation = '';
            $department = '';
            $grade = '';
            $job = $employee->experience;
            if ($job) {
                if ($job->designation) {
                    $designation = $job->designation->title;
                    if ($job->designation_status and $job->designation_status !== "1") {
                        $designation .= ' - ' . getDesignatioStatusTitle($job->designation_status);
                    }
                }
                if ($job->department)
                    $department = $job->department->department_name;

                if ($job->scale)
                    $grade      = $job->scale->grade;
            }
            $branch_name        = '';
            $bank_name          = '';
            if ($employee->bankName)
                $bank_name      = $employee->bankName->bank_name;

            if ($employee->bankBranch)
                $branch_name    = $employee->bankBranch->branch_name;

            $dataArray = [
                "employee_id"          => $employee->employee_id,
                "pfno"                 => $employee->pfno,
                "wasa_id"              => $employee->wasa_id,
                "full_Name"            => $employee->first_name . ' ' . $employee->middle_name . ' ' . $employee->last_name,
                "designation"          => $designation,
                "department"           => $department,
                "current_basic_pay"    => $employee->current_basic_pay,
                "last_basic_pay"       => $employee->last_basic_pay,
                "first_joining_date"   => dateFormat($employee->first_joining_date),
                "grade"                => $grade,
                "bank_name"            => $bank_name,
                "branch_name"          => $branch_name,
                "bank_account_no"      => $employee->bank_account_no,
                "provident_fund_no"    => $employee->provident_fund_no,
                "mobile"               => $employee->mobile,
                "email"                => $employee->email,
                "father_name"          => $employee->father_name,
                "mother_name"          => $employee->mother_name,
                "religion"             => $employee->religion,
                "gender"               => $employee->gender,
                "blood_group"          => $employee->blood_group,
                "marital_status"       => $employee->marital_status,
                "date_of_birth"        => dateFormat($employee->date_of_birth),
                "national_id"          => $employee->nid,
                "tin"                  => $employee->tin,
                "place_of_birth"       => $employee->place_of_birth,
                "spouse_name"          => $employee->spouse_name,
                "spouse_qualification" => $employee->spouse_qualification,
                "spouse_profession"    => $employee->spouse_profession,
                "personnel_file_no"    => $employee->personnel_file_no,
                "passport_no"          => $employee->passport_no,

            ];

            $permanentAddress = $employee->address->where('address_type', 'Permanent')->last();
            $dataArray['permanent_division']    = isset($permanentAddress->division) ? $permanentAddress->division->name : '';
            $dataArray['permanent_district']    = isset($permanentAddress->district) ? $permanentAddress->district->name : '';
            $dataArray['permanent_thana']       = isset($permanentAddress->thana) ? $permanentAddress->thana->name : '';
            $dataArray['permanent_post_office'] = isset($permanentAddress->postOffice) ? $permanentAddress->postOffice->name : '';
            $dataArray['permanent_zip_code']    = isset($permanentAddress->postOffice) ? $permanentAddress->postOffice->zip_code : '';

            $presentAddress = $employee->address->where('address_type', 'Present')->last();
            $dataArray['present_division']      = isset($presentAddress->division) ? $presentAddress->division->name : '';
            $dataArray['present_district']      = isset($presentAddress->district) ? $presentAddress->district->name : '';
            $dataArray['present_thana']         = isset($presentAddress->thana) ? $presentAddress->thana->name : '';
            $dataArray['present_post_office']   = isset($presentAddress->postOffice) ? $presentAddress->postOffice->name : '';
            $dataArray['present_zip_code']      = isset($presentAddress->postOffice) ? $presentAddress->postOffice->zip_code : '';

            $data[] = $dataArray;
        }


        Excel::create($this->fileName, function($excel) use($data) {
            $excel->sheet('Employee List', function($sheet) use($data) {
                $sheet->setOrientation('landscape');
                $sheet->fromArray($data);
            });
        })->store('xls', public_path() . "/downloads/export-excel");

        $downloadExcel         = DownloadExcel::where('id',$this->downloadExcelId)->first();
        $downloadExcel->status = 1;
        $downloadExcel->save();
        Log::info("employee excel end.. ");
        return true;
    }

    private function __getData() {

        $query = Employee::select('*')->with('wasaJobExprience', 'designation', 'department');
        if(!empty($this->request)) {
            if (isset($this->request['role_id']) && $this->request['role_id']) {
                $query->leftJoin('users', 'employees.id', 'users.employee_id');
                $query->leftJoin('role_user', 'users.id', 'role_user.user_id');
                $query->where('role_user.role_id', $this->request['role_id']);
            }
            if (isset($this->request['designation'])) {
                    $query->whereIn('employees.designation_id', $this->request['designation']);
            }
            if ( isset($this->request['department'])) {
                    $query->where('employees.office_id', $this->request['department']);
            }
            if (isset($this->request['district']) || isset($this->request['division']) || isset($this->request['thana']) || isset($this->request['postOffice'])) {
                $query->join('employee_addresses as ea', function ($join) {
                    $join->on('ea.employee_id', '=', 'employees.id');
                    $join->where('ea.address_type', '=', "Permanent");
                });

                if (isset($this->request['division']) && $this->request['division']) {
                    $query->where('ea.division_id', $this->request['division']);
                }
                if (isset($this->request['district']) && $this->request['district']) {
                    $query->where('ea.district_id', $this->request['district']);
                }
                if (isset($this->request['thana']) && $this->request['thana']) {
                    $query->where('ea.thana_id', $this->request['thana']);
                }
                if (isset($this->request['postOffice']) && $this->request['postOffice']) {
                    $query->where('ea.post_office', $this->request['postOffice']);
                }
            }
            if (isset($this->request['location']) && $this->request['location']) {
                $location = $this->request['location'];
                $query->Join('employee_quarters as eq', function ($join) use ($location) {
                    $join->on('eq.employee_id', '=', 'employees.id');
                    $join->where('eq.location', '=', $location);
                });
            }
            if ( isset($this->request['prlStart']) && isset($this->request['prlEnd'])) {
                if (isset($this->request['age']) && $this->request['age']) {
                    $age = $this->request['age'];
                } else {
                    $age = 59;
                }
                $prlStart = \Carbon\Carbon::parse(changeDateFormatToDb($this->request['prlStart']));
                $prlStart = $prlStart->subYears($age)->format('Y-m-d');
                $prlEnd = \Carbon\Carbon::parse(changeDateFormatToDb($this->request['prlEnd']));
                $prlEnd = $prlEnd->subYears($age)->format('Y-m-d');
                $dateFrom = \Carbon\Carbon::parse(changeDateFormatToDb($this->request['prlStart']));
                $dateTo = \Carbon\Carbon::parse(changeDateFormatToDb($this->request['prlEnd']));
                if ($this->request['age_type'] == "service") {

                    $query->whereBetween('first_joining_date', [$prlStart, $prlEnd]);
                } else if ($this->request['age_type'] == "age") {
                    $query->whereBetween('date_of_birth', [$prlStart, $prlEnd]);
                } else if ($this->request['age_type'] == "joinday") {
                    $query->whereBetween('first_joining_date', [$dateFrom, $dateTo]);
                } else if ($this->request['age_type'] == "birthday") {
                    $query->whereBetween('date_of_birth', [$dateFrom, $dateTo]);
                } else if ($this->request['age_type'] == "leave") {
                    $query->leftJoin('employee_leaves as el', 'employees.id', 'el.employee_id');
                    $query->where('el.from_date', '>', $dateFrom);
                    $query->where('el.to_date', '<', $dateTo);
                    if ($this->request->leave_type > 0)
                        $query->where('el.type_id', $this->request->leave_type);
                    $query->groupBy('employees.id');
                }
            } else if (isset($this->request['age']) && $this->request['age']) {

                $date = \Carbon\Carbon::now();
                $to = $date->subYear($this->request['age'])->format('Y-m-d');
                $from = $date->subYear()->format('Y-m-d');

                $query->whereBetween('employees.date_of_birth', [$from, $to]);
            }

            if (isset($this->request['employee_id']) && $this->request['employee_id']) {
                $query->where('employees.employee_id', $this->request['employee_id']);
            }
            if (isset($this->request['wasa_id']) && $this->request['wasa_id']) {
                $query->where('employees.wasa_id', $this->request['wasa_id']);
            }
            if (isset($this->request['nid']) && $this->request['nid']) {
                $query->where('employees.nid', $this->request['nid']);
            }
            if (isset($this->request['pfno']) && $this->request['pfno']) {
                $pfno = array_map('trim', explode(',', $this->request['pfno']));
                $query->whereIn('employees.pfno', $pfno);
            }
            if (isset($this->request['name']) && $this->request['name']) {
                $requestName = $this->request['name'];
                $query->where(function ($q) use ($requestName) {
                    $q->where('employees.first_name', 'like', "%{$requestName}%");
                    $q->orWhere('employees.middle_name', 'like', "%{$requestName}%");
                    $q->orWhere('employees.last_name', 'like', "%{$requestName}%");
                });
            }
            if (isset( $this->request['mobile'] ) && $this->request['mobile']) {
                $query->where('employees.mobile', $this->request['mobile']);
            }
            if (isset($this->request['religion']) && $this->request['religion']) {
                $query->where('employees.religion', $this->request['religion']);
            }
            if (isset($this->request['merital_status']) && $this->request['merital_status']) {
                $query->where('employees.marital_status', $this->request['merital_status']);
            }

            if (isset($this->request['sex']) && $this->request['sex']) {
                $query->where('employees.gender', $this->request['sex']);
            }
            if (isset($this->request['date_of_birth']) && $this->request['date_of_birth']) {
                $birth_date = changeDateFormatToDb($this->request['date_of_birth']);
                $query->where('employees.date_of_birth', $birth_date);
            }

            if (isset($this->request['ppo_no']) && $this->request['ppo_no']) {
                $ppo_no = $this->request['ppo_no'];
                $query->whereHas('search_by_ppo_no', function ($q) use ($ppo_no) {
                    $q->where('ppo_no', $ppo_no);
                });
            }

            if (isset($this->request['quota']) && $this->request['quota']) {
                $query->where('quota_id', $this->request['quota']);
            }

            if (isset($this->request['status']) && $this->request['status']) {
                $query->whereIn('employees.status', $this->request['status']);
            }
            if (isset($this->request['grade']) && $this->request['grade']) {
                $query->whereIn('employees.grade',  $this->request['->grade']);
            }
        }
        $list = $query->get();
        Log::info($query->count());
        return $list;

//        return Employee::select('*')->with('wasaJobExprience', 'designation', 'department')->get();
    }


}
