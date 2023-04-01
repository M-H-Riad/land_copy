<?php

namespace App\Modules\EmployeeProfile\Controllers;

use App\EmployeeProfile\Model\EmployeeChildren;
use App\EmployeeProfile\Model\Scale;
use App\Http\Controllers\Controller;
use App\Mail\SendAlertMail;
use App\Modules\GeneralConfiguration\Models\PayScaleList;
use App\Modules\LoanManagement\Models\LoanInfo;
use App\Modules\LoanManagement\Models\LoanLedger;
use App\Modules\Payroll\Models\ArrDedOffAlert;
use App\Modules\Payroll\Models\Payroll;
use App\Modules\Payroll\Models\PayrollSettings;
use App\Modules\Payroll\Traits\IncomeTaxTrait;
use Carbon\Carbon;
use http\Exception;
use Illuminate\Http\Request;
use DB;
use Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Log;
use App\EmployeeProfile\Model\Employee;
use App\EmployeeProfile\Model\EmployeePayrollSetting;
use App\Modules\Payroll\Models\PayrollEmployee;
use App\EmployeeProfile\Model\EmployeeMembership;
use App\EmployeeProfile\Model\EmployeeWasaJobExperience;
use App\EmployeeProfile\Model\Designation;
use App\EmployeeProfile\Model\Department;

class TestImportController extends Controller {

    use IncomeTaxTrait;
    public function index() {
        $address = public_path('doc/pimsdata.xls');
        try {
            DB::beginTransaction();
            $notFoundEmp = '';
            Excel::load($address, function($reader)use (&$notFoundEmp) {
                $results = $reader->get();
                foreach ($results as $cel) {

                    $employee = Employee::where('pfno', $cel->pfno)->first();
                    if (is_null($employee)) {
                        echo "<br/>" . $cel->pfno;
                    } else {

                        $empPS = EmployeePayrollSetting::where('employee_id', $employee->id)->first();
                        if (is_null($empPS)) {
                            $empPS = new EmployeePayrollSetting();
                        }

                        $empPS->salary_arr = $cel->salary_arr;
                        $empPS->hr_arr = $cel->hr_arr;
                        $empPS->other_alw = $cel->other_alw;
                        $empPS->save();

//                        if ($cel->dpsfee > 0) {
//                            $dpsfee = ['employee_id' => $employee->id, 'membership_organization_id' => 6];
//
//                            $em = EmployeeMembership::where($dpsfee)->first();
//                            if (is_null($em)) {
//                                EmployeeMembership::create($dpsfee);
//                            }
//                        }
//
//                        if ($cel->deasfee > 0) {
//                            $deasfee = ['employee_id' => $employee->id, 'membership_organization_id' => 7];
//
//                            $em = EmployeeMembership::where($deasfee)->first();
//                            if (is_null($em)) {
//                                EmployeeMembership::create($deasfee);
//                            }
//                        }
//
//                        if ($cel->dhakusfee > 0) {
//                            $dhakusfee = ['employee_id' => $employee->id, 'membership_organization_id' => 8];
//
//                            $em = EmployeeMembership::where($dhakusfee)->first();
//                            if (is_null($em)) {
//                                EmployeeMembership::create($dhakusfee);
//                            }
//                        }
//
//                        if ($cel->unionsub > 0) {
//                            $unionsub = ['employee_id' => $employee->id, 'membership_organization_id' => 9];
//
//                            $em = EmployeeMembership::where($unionsub)->first();
//                            if (is_null($em)) {
//                                EmployeeMembership::create($unionsub);
//                            }
//                        }
//                        $employee->bank_name = ($cel->bank_id == 2) ? 27 : NULL;
//                        $employee->branch_name = ($cel->branch_id == 4) ? 8674 : NULL;
//                        $employee->bank_account_no = ($cel->bankaccoun) ? $cel->bankaccoun : NULL;
//                        $employee->designation_id = ($cel->desig_id) ? $cel->desig_id : NULL;
//                        $employee->designation_ranking = ($cel->rankingid) ? $cel->rankingid : NULL;
//                        $employee->office_id = ($cel->dept_id) ? $cel->dept_id : NULL;
//                        $employee->scale_id = ($cel->scale_id) ? $cel->scale_id : NULL;
//                        $employee->grade = ($cel->scale_grd) ? $cel->scale_grd : NULL;
//                        $employee->current_basic_pay = ($cel->basicpay) ? $cel->basicpay : NULL;
//                        $employee->save();
//
//                        $empPS = EmployeePayrollSetting::where('employee_id', $employee->id)->first();
//                        if (is_null($empPS)) {
//                            $empPS = new EmployeePayrollSetting();
//                        }
//
//                        $empPS->employee_id = $employee->id;
//                        $empPS->it_ded = trim($cel->itdeduct);
//                        $empPS->vhl_alw = trim($cel->deputation);
//                        $empPS->pfno = $cel->pfno;
//                        $empPS->pf_loan = $cel->pfloanadva;
//                        $empPS->hb_loan = $cel->hbdeductio;
//                        $empPS->h_rent = ($cel->houserentd > 0) ? 1 : 0;
//                        $empPS->stove = ($cel->titasgas == 800) ? 2 : 0;
//                        $empPS->gas_alw = ($cel->titasgas == 800) ? 1 : 0;
//                        $empPS->transport = $cel->transportc;
//                        $empPS->hb_inttr = $cel->hbinterest;
//                        $empPS->sal_ded = $cel->salarydedu;
//                        $empPS->pc_loan = $cel->computerlo;
//                        $empPS->other_ded = $cel->othersdedu;
//                        $empPS->updated_at = \Carbon\Carbon::now();
//                        $empPS->save();
//
//
//                        if ($cel->educationa > 0) {
//                            $input = [
//                                'employee_id' => $employee->id,
//                                'pfno' => $employee->pfno,
//                                'children_name' => 'Children',
//                                'date_of_birth' => '2018-01-01',
//                            ];
//                            $exist_children = \App\EmployeeProfile\Model\EmployeeChildren::where('employee_id', $employee->id)->count();
//                            if ($cel->educationa == 1000) {
//                                if ($exist_children <= 0) {
//                                    \App\EmployeeProfile\Model\EmployeeChildren::create($input);
//                                    \App\EmployeeProfile\Model\EmployeeChildren::create($input);
//                                } elseif ($exist_children == 1) {
//                                    \App\EmployeeProfile\Model\EmployeeChildren::create($input);
//                                }
//                            } elseif ($cel->educationa == 500 || $cel->educationa == 300) {
//                                if ($exist_children <= 0) {
//                                    \App\EmployeeProfile\Model\EmployeeChildren::create($input);
//                                }
//                            }
//                        }
                    }
                }
            });
            DB::commit();

            dd("Done", $notFoundEmp);
        } catch (\Exception $ex) {

            DB::rollback();
            dd($ex);
        }
    }

    public function match() {
        $address = public_path('doc/pimsdata.xls');
        try {
            DB::beginTransaction();
            $pfno[] = null;
            Excel::load($address, function($reader)use (&$pfno) {
                $results = $reader->get();
                foreach ($results as $cel) {

                    $pfno[] = $cel->pfno;
                    $empPS = EmployeePayrollSetting::where('employee_id', $employee->id)->first();
                    if (is_null($empPS)) {
                        $empPS = new EmployeePayrollSetting();
                    }
                }
            });


            $emp = PayrollEmployee::select('employees.pfno')
                ->join('employees', 'employees.id', 'payroll_employees.employee_id')
                ->where('payroll_employees.month_id', 10)
                ->get();

            foreach ($emp as $e) {
                if (!in_array($e->pfno, $pfno)) {
                    echo $e->pfno . ",";
                }
            }

            DB::commit();

            dd("Done");
        } catch (\Exception $ex) {

            DB::rollback();
            dd($ex);
        }
    }

    public function matchAcCc() {
        $address = public_path('doc/pimsdata.xls');
        try {
            DB::beginTransaction();
            $pfno[] = null;
            Excel::load($address, function($reader)use (&$pfno) {
                $results = $reader->get();
                $i = 0;
                foreach ($results as $cel) {

                    if ($cel->washallowa > 0) {

                        $p[$i++]['pfno'] = $cel->pfno;
                        $emp = Employee::where('pfno', $cel->pfno)->first();
                        $empPS = EmployeePayrollSetting::where('employee_id', $emp->id)->first();

//                        $empPS->h_rent = 1;
                        $empPS->wash_alw = $cel->washallowa;
                        $empPS->save();
//                        if($empPS->h_rent == 1 and $empPS->stove==2)
//                        {
//
//                        }
//                        else
//                        {
//                             echo $empPS->id.", ";
//                        }
//                        EmployeePayrollSetting::where('id',$empPS->id)->update(['other_alw'=>$cel->otherallow]);
//                        $emp = Employee::where('pfno',$cel->pfno)->first();
//                        if(($emp->designation_status == 2 or $emp->designation_status ==3 or $emp->designation_status==4) and $emp->status == 'Continue')
//                        {
//                            $p[$i]['id']=$emp->id;
//                            $p[$i]['pfno']=$cel->pfno;
//                            $p[$i]['desig_name']=$cel->desig_name;
//                            $p[$i]['status']=$emp->status;
//                            $p[$i++]['designation_status']=$emp->designation_status;
//                        }
//                        else
//                        {
//
//;
//                        }
                    }
                }
            });




            DB::commit();

            dd("Done");
        } catch (\Exception $ex) {

            DB::rollback();
            dd($ex);
        }
    }

    private function washallowa() {

    }

    public function importDataMiss() {
        $address = public_path('doc/Arif_EMP_20180712.xlsx');
        try {
            DB::beginTransaction();
            $notFoundEmp[] = null;
            Excel::load($address, function($reader)use (&$notFoundEmp) {
                $results = $reader->get();
                //dd($results);
                $missingPf = explode(',', "6668,6684,6677,6675,6680,6683,6676,6674,6678,6669,6682,6671,6670,6673,6681,6672,6679,6334,1948,6329,1724,2846,2479,1752,4745,6317,1744,6335,3618,6312,2050,6652,6649,6650,6653,6654,6655,6651,6644,6656,6657,6645,6646,6659,6647,6660,6662,6661,6648,4649,6666,6667,6664,6663,6658,6642");
                $i = 1;
                foreach ($results as $cel) {

                    if (in_array($cel->pfno, $missingPf)) {
                        $emp = new Employee();

                        $emp->pfno = $cel->pfno;
                        $emp->nid = $cel->nationalidno;
                        $emp->first_name = $cel->empname;
                        $emp->father_name = $cel->fathername;
                        $emp->mother_name = $cel->mothername;
                        $emp->gender = $cel->gender;
                        $emp->marital_status = $cel->maritalstatus;
                        $emp->religion = $cel->religion;
                        $emp->date_of_birth = date('Y-m-d', strtotime($cel->dob));
                        $emp->first_joining_date = date('Y-m-d', strtotime($cel->doj));
                        $emp->current_joining_date = date('Y-m-d', strtotime($cel->doj));
                        $emp->bank_account_no = $cel->bankaccountno;
                        $emp->bank_account_no_t24 = $cel->t_24_act;
                        $emp->status = ($cel->statuss == 'PRL') ? 'PRL' : 'Continue';
                        $emp->freedom_fighter = ($cel->freedomfighter == 'N/A') ? 'N/A' : 'yes';
                        $emp->save();
                    }
                }
            });
            DB::commit();

            dd("Done", $notFoundEmp);
        } catch (\Exception $ex) {

            DB::rollback();
            dd($ex);
        }
    }

    public function importDataAcCc() {
        $address = public_path('doc/ac_cc.xlsx');
        try {
            DB::beginTransaction();
            $notFoundEmp[] = null;
            Excel::load($address, function($reader)use (&$notFoundEmp) {
                $results = $reader->get();
                dd($results->toArray());
                $i = 1;
                foreach ($results as $cel) {

                    $employee = Employee::where('pfno', $cel->pfno)->first();
                    if (is_null($employee)) {
                        echo "<br/>" . $cel->pfno;
                    } else {
                        $employee->designation_status = ($cel->ac_cc == 'CC') ? 3 : 2;
                        $employee->save();
                    }
                }
            });
            DB::commit();

            dd("Done", $notFoundEmp);
        } catch (\Exception $ex) {

            DB::rollback();
            dd($ex);
        }
    }

    public function importEmployeeInfo() {
        ini_set('max_execution_time', 380);
        $address = public_path('doc/employeeData.xlsx');
        try {

            DB::beginTransaction();
            Excel::load($address, function($reader) {
                $results = $reader->get();
//                dd($results->toArray());
                $i = 1;
                foreach ($results as $cel) {

                    $employee = Employee::where('pfno', $cel->pfno)->first();
                    if (is_null($employee)) {
                        echo "<br/>" . $cel->pfno;
                    } else {

                        $employee->bank_account_no = $cel->bankaccountno;
                        $employee->bank_account_no_t24 = $cel->t_24_act;
                        $bankId = null;
                        $branchId = null;
                        if ($cel->bankid == 4001) {
                            $bankId = 34; //ONE BANK LTD.
                            if ($cel->branchid == 4001) {
                                $branchId = 4378;
                            } elseif ($cel->branchid == 4002) {
                                $branchId = 4365;
                            }
                        } else if ($cel->bankid == 2001) {
                            $bankId = 27; //JANATA BANK LTD.
                            if ($cel->branchid == 2006) {
                                $branchId = 8786;
                            } elseif ($cel->branchid == 2001) {
                                $branchId = 8674;
                            } elseif ($cel->branchid == 2007) {
                                $branchId = 8674;
                            }
                        }

                        $employee->bank_name = $bankId;
                        $employee->branch_name = $branchId;

//                        if (is_null($employee->designation_id)) {
//                            $des = Designation::select('id', 'ranking_id')->where('old_id', $cel->desig_id)->first();
//                            if ($des) {
//                                $employee->designation_id = $des->id;
//                                $employee->designation_ranking = $des->ranking_id;
//                            }
//                        }
//
//                        if (is_null($employee->nid)) {
//                            $employee->nid = $cel->nationalidno;
//                        }
                        $employee->save();
                    }
                }
            });
            DB::commit();

            dd("Done");
        } catch (\Exception $ex) {

            DB::rollback();
            dd($ex);
        }
    }

    public function importDepartmentGroup() {
        ini_set('max_execution_time', 280);
        $address = public_path('doc/departmentWithGroup.xlsx');
        try {

            DB::beginTransaction();
            Excel::load($address, function($reader) {
                $results = $reader->get();
//                dd($results->toArray());
                $i = 1;
                foreach ($results as $cel) {

                    $dep = Department::where('old_id', $cel->dept_id)->first();

                    if ($dep) {
                        $dep->department_group_id = $cel->dept_gr;

                        $dep->save();
                    } else {
                        echo $cel->dept_id . " , ";
                    }
                }
            });
            DB::commit();

            dd("Done");
        } catch (\Exception $ex) {

            DB::rollback();
            dd($ex);
        }
    }

    public function updateEmpeloyeeId() {
        $employee = Employee::select('id', 'employee_id', 'first_name', 'middle_name', 'last_name', 'date_of_birth')->whereNull('employee_id')->get();

        foreach ($employee as $emp) {
            $empId = $this->__makeEmployeeId($emp);

            Employee::where('id', $emp->id)->update(['employee_id' => $empId]);
        }
    }

    protected function __makeEmployeeId($request) {

        $id = "";
        if (!is_null($request->middle_name) and ! is_null($request->last_name)) {
            $id = $id . substr($request->middle_name, 0, 1);
            $id = $id . substr($request->last_name, 0, 1);
        } else if (!is_null($request->first_name) and ! is_null($request->middle_name)) {

            $id = $id . substr($request->first_name, 0, 1);
            $id = $id . substr($request->middle_name, 0, 1);
        } else {
            $id = $id . substr($request->first_name, 0, 2);
        }

        $id = $id . str_replace('-', '', date('Y-m-d', strtotime($request->date_of_birth)));
        $inc = "001";

        while (1) {
            $check = $id . "" . sprintf("%03d", $inc);
            if (!Employee::select('id')->whereEmployeeId($check)->exists()) {

                return strtoupper($check);
            }
            $inc++;
        }
    }

    public function updateWasaJobExp() {
        $employee = Employee::get();

        foreach ($employee as $emp) {
            if (!EmployeeWasaJobExperience::where('employee_id', $emp->id)->where('basic_pay', $emp->current_basic_pay)->exists()) {
                echo $emp->id . "<br>";
//                dd("not found");
                $data = array(
                    'employee_id' => $emp->id,
                    'basic_pay' => $emp->current_basic_pay,
                    'pfno' => $emp->pfno,
                    'joining_date' => $emp->current_joining_date,
                    'designation_id' => $emp->designation_id,
                    'designation_status' => $emp->designation_status,
                    'scale_id' => $emp->scale_id,
                    'grade' => $emp->grade,
                );


                EmployeeWasaJobExperience::create($data);
            } else {
//                dd("found");
            }
        }
    }

    public function importEmployeeInfoForSalary() {
//        $return = EmployeeChildren::where('pfno',6055)->where('date_of_birth','>=',\Carbon\Carbon::now()->subYears(21))->count();

//exit('off');
        set_time_limit(900);
        ini_set('max_execution_time', 1000);
        ini_set('memory_limit', '-1');
//        $address = public_path('doc/HRM_EMP_NAME.xls');
        $address = public_path('doc/Payroll20190829.xls');
//        $employees = Employee::select('id','pfno','grade','current_basic_pay','incremented_amount','last_basic_pay','scale_id','office_id','designation_id','designation_status','gender')->where('status','Continue')->get();
//        foreach ($employees as $employee){
//        $t = $this->incomeTax($employee);
//
//        $data = [
//             'totalIncome' => $this->totalIncome,
//             'taxFreeAmount' => $this->taxFreeAmount,
//             'rebateAmount' => $this->rebateAmount,
//             'taxableAmount' => $this->taxableAmount,
//             'totalTax' => $this->totalTax,
//             'monthlyTax' => $this->monthlyTax,
//        ];
//
//
//            dd($employee->current_basic_pay,$data,$t    );
//        }


//
        $payrollSettings = EmployeePayrollSetting::with('relEmployee')->get();
        dd('ok');
        foreach ( $payrollSettings  as $item){

            if( $item->spl_pay_amount > 0){
                $item->spl_pay = 1;
                $item->spl_pay_end = '2019-09-30';
            }else{
                $item->spl_pay = 0;
            }
            if( $item->per_pay > 0){
                $item->personal_pay = 1;
                $item->per_pay_end = '2019-09-30';
            }else{
                $item->personal_pay = 0;
            }
            if( $item->salary_arr > 0){
                $item->salary_arrears = 1;
                $item->salary_arr_end = '2019-09-30';
            }else{
                $item->salary_arrears = 0;
            }
            if( $item->pf_refund > 0){
                $item->pf_fund_refund = 1;
                $item->pf_refund_end = '2019-09-30';
            }else{
                $item->pf_fund_refund = 0;
            }
            if( $item->hb_refund > 0){
                $item->hb_lone_refund = 1;
                $item->hb_refund_end = '2019-09-30';
            }else{
                $item->hb_lone_refund = 0;
            }
            if( $item->vhl_alw > 0){
                $item->vehicle_allowance = 1;
                $item->vhl_alw_end = '2019-09-30';
            }else{
                $item->vehicle_allowance = 0;
            }
            if( $item->vhl_refund > 0){
                $item->vehicle_refund = 1;
                $item->vhl_refund_end = '2019-09-30';
            }else{
                $item->vehicle_refund = 0;
            }
            if( $item->hr_arr > 0){
                $item->house_rent_arr = 1;
                $item->hr_arr_end = '2019-09-30';
            }else{
                $item->house_rent_arr = 0;
            }
            if( $item->other_alw > 0){
                $item->other_allowance = 1;
                $item->other_alw_end = '2019-09-30';
            }else{
                $item->other_allowance = 0;
            }
            if( $item->transport > 0){
                $item->transport_ded = 1;
                $item->transport_end = '2019-09-30';
            }else{
                $item->transport_ded = 0;
            }
            if( $item->sal_ded > 0){
                $item->salary_ded = 1;
                $item->sal_ded_end = '2019-09-30';
            }else{
                $item->salary_ded = 0;
            }
            if( $item->it_arrear_ded > 0){
                $item->it_arr_ded = 1;
                $item->it_arrear_ded_end = '2019-09-30';
            }else{
                $item->it_arr_ded = 0;
            }
            if( $item->other_ded > 0){
                $item->other_deduction = 1;
                $item->other_ded_end = '2019-09-30';
            }else{
                $item->other_deduction = 0;
            }
            if( $item->hb_loan > 0){
                $item->hb_loan_ded = 1;
                $item->hb_loan_ded_end = '2019-09-30';
            }else{
                $item->hb_loan_ded = 0;
            }
            if( $item->hb_inttr > 0){
                $item->hb_interest_ded = 1;
                $item->hb_inttr_ded_end = '2019-09-30';
            }else{
                $item->hb_interest_ded = 0;
            }
            if( $item->pc_loan > 0){
                $item->pc_loan_ded = 1;
                $item->pc_loan_ded_end = '2019-09-30';
            }else{
                $item->pc_loan_ded = 0;
            }
            if( $item->pc_inttr > 0){
                $item->pc_interest_ded = 1;
                $item->pc_inttr_ded_end = '2019-09-30';
            }else{
                $item->pc_interest_ded = 0;
            }
            if( $item->vhcl_loan > 0){
                $item->vhcl_loan_ded = 1;
                $item->vhcl_loan_ded_end = '2019-09-30';
            }else{
                $item->vhcl_loan_ded = 0;
            }
            if( $item->vhcl_inttr > 0){
                $item->vhcl_interest_ded = 1;
                $item->vhcl_inttr_ded_end = '2019-09-30';
            }else{
                $item->vhcl_interest_ded = 0;
            }
            if( $item->pf_loan > 0){
                $item->pf_loan_ded = 1;
                $item->pf_loan_ded_end = '2019-09-30';
            }else{
                $item->pf_loan_ded = 0;
            }
            if( $item->pf_inttr > 0){
                $item->pf_interest_ded = 1;
                $item->pf_inttr_ded_end = '2019-09-30';
            }else{
                $item->pf_interest_ded = 0;
            }
            $item->save();
        }


        /**
         * employee job experience update

        //        $employee = Employee::where('status','Continue')->orWhere('status','PRL')->orWhere('status','Suspended')->get();
        //
        ////        $wasaJob = EmployeeWasaJobExperience::get();
        //        foreach ($employee as $e){
        //            $job = EmployeeWasaJobExperience::where('employee_id',$e->id)->orderBy('id','desc')->first();
        //
        //            if($job instanceof EmployeeWasaJobExperience){
        //
        //                if($job->scale_year == null){
        //                    $job->scale_year = 2015;
        //                }
        //                if($job->scale_id == null){
        //                    $job->scale_id = $e->scale_id;
        //                }
        //                if($job->grade == null){
        //                    $job->grade = $e->grade;
        //                }
        //                if($e->current_basic_pay > $job->basic_pay){
        //                    $job->basic_pay = $e->current_basic_pay;
        //                }
        //                if($job->designation_idv == null){
        //                    $job->designation_id = $e->designation_id;
        //                }
        //                $job->updated_at  = Carbon::now();
        //                $job->updated_by = Auth::user()->id;
        //                $job->save();
        //            }else{
        //                $job = new EmployeeWasaJobExperience();
        //                $job->employee_id = $e->id;
        //                $job->pfno = $e->pfno;
        //                $job->scale_year = 2015;
        //                $job->scale_id = $e->scale_id;
        //                $job->basic_pay = $e->current_basic_pay;
        //                $job->designation_id = $e->designation_id;
        //                $job->office_id = $e->office_id;
        //                $job->joining_date = $e->joining_date;
        //                $job->save();
        //            }
        //        }
        //        exit('off');
         */


//        try {
//            DB::beginTransaction();
//
////            $d = EmployeePayrollSetting::whereNotIn('pfno',[1246,1251,1266,1274,1275,1292,1318,1332,1336,1618,1619,1623,1625,1630,1640,1641,1643,1645,1827,1828,1829,1831,1832,1834,1838,1839,1852,2005,2010,2013,2023,2029,2030,2031,2034,2037,2166,2167,2173,2174,2175,2178,2180,2182,2186,2338,2341,2342,2344,2345,2346,2362,2363,2365,2509,2511,2512,2513,2514,2515,2518,2520,2522,2643,2644,2647,2648,2649,2651,2655,2656,2660,2762,2764,2765,2766,2767,2770,2773,2774,2775,2864,2865,2866,2867,2868,2869,2870,2871,2872,2946,2949,2953,2954,2955,2956,2957,2958,2959,3064,3065,3066,3068,3069,3070,3071,3072,3073,3132,3133,3134,3135,3136,3137,3138,3139,3140,3209,3213,3215,3217,3220,3221,3224,3226,3228,3296,3297,3298,3299,3300,3301,3302,3303,3304,3364,3365,3366,3367,3368,3369,3372,3373,3374,3437,3438,3439,3440,3441,3442,3443,3444,3445,3503,3504,3505,3506,3507,3508,3509,3510,3511,3581,3582,3584,3585,3586,3587,3589,3590,3591,3652,3653,3654,3655,3656,3657,3658,3659,3660,3719,3720,3721,3722,3723,3724,3725,3727,3728,3783,3785,3786,3787,3788,3789,3790,3791,3792,3847,3848,3851,3852,3853,3854,3855,3857,3858,3914,3915,3916,3917,3918,3919,3920,3921,3922,3974,3975,3976,3977,3978,3979,3980,3981,3982,4033,4034,4035,4038,4039,4040,4041,4042,4043,4089,4090,4091,4092,4093,4094,4095,4096,4097,4147,4148,4149,4151,4152,4153,4154,4155,4156,3141,3142,3143,3145,3146,3147,3148,3152,3154,4203,4205,4206,4207,4208,4209,4210,4211,4212,3229,3230,3231,3234,3235,3237,3238,3239,3241,4259,4260,4261,4262,4263,4264,4265,4266,4267,3306,3307,3308,3309,3310,3311,3313,3314,3315,4317,4318,4319,4320,4321,4322,4323,4324,4325,3375,3376,3377,3379,3380,3381,3383,3384,3385,4374,4375,4376,4377,4378,4379,4380,4381,4384,2187,2193,2194,2197,2200,2201,2203,2207,2209,3446,3447,3448,3449,3450,3451,3452,3453,3454,2366,2370,2375,2386,2387,2388,2398,2399,2400,4434,4435,4436,4437,4438,4439,4440,4441,4442,2523,2524,2525,2527,2528,2529,2534,2535,2536,3512,3514,3515,3518,3519,3521,3523,3526,3527,2661,2662,2664,2667,2669,2670,2671,2672,2673,4491,4492,4494,4495,4497,4499,4500,4501,4502,2776,2777,2781,2782,2783,2785,2786,2787,2789,3592,3594,3595,3596,3597,3598,3599,3600,3601,2873,2874,2875,2876,2877,2878,2880,2882,2883,4554,4555,4556,4557,4558,4559,4560,4561,4562,1348,1349,1350,1354,1359,1364,1365,1377,1378,2960,2961,2962,2963,2964,2965,2971,2972,2973,1647,1651,1656,1661,1664,1666,1668,1678,1682,3661,3662,3663,3664,3665,3666,3668,3669,3670,1853,1856,1859,1860,1861,1862,1869,1871,1873,3074,3075,3076,3077,3078,3079,3080,3081,3082,2040,2041,2043,2049,2050,2054,2055,2056,2057,4614,4615,4616,4617,4619,4620,4621,4622,4623,1390,1398,1400,1401,1405,1428,1430,1434,1439,1683,1684,1685,1686,1695,1700,1702,1708,1714,1874,1878,1880,1883,1887,1889,1893,1895,1899,2060,2063,2064,2065,2067,2069,2072,2073,2075,2210,2214,2216,2218,2219,2222,2224,2225,2227,2409,2416,2417,2420,2421,2422,2423,2424,2429,2537,2538,2539,2540,2543,2544,2545,2546,2547,2674,2677,2679,2680,2681,2683,2685,2686,2687,2791,2795,2797,2803,2805,2807,2808,2811,2812,2884,2885,2887,2888,2889,2890,2891,2892,2893,2975,2979,2989,2995,3010,3011,3012,3013,3244,3245,3246,3247,3249,3250,3251,3316,3318,3319,3320,3321,3014,3084,3085,3087,3088,3089,3090,3091,3092,3093,3155,3156,3157,3158,3159,3162,3163,3164,3165,3242,3243,3322,3323,3324,3325,3386,3388,3389,3390,3391,3392,3393,3395,3396,3455,3456,3457,3458,3459,3460,3461,3463,3464,3530,3531,3532,3533,3534,3535,3536,3537,3538,3603,3604,3605,3606,3607,3608,3609,3610,3611,3671,3672,3673,3674,3675,3676,3677,3678,3679,3729,3730,3731,3732,3733,3734,3735,3736,3737,3793,3794,3795,3796,3797,3798,3799,3800,3801,3859,3860,3861,3862,3863,3864,3865,3866,3867,3923,3924,3925,3926,3927,3928,3929,3930,3932,3983,3984,3985,3986,3987,3988,3989,3990,3992,4044,4045,4046,4047,4048,4049,4050,4051,4052,4098,4099,4100,4101,4103,4104,4105,4106,4107,4157,4158,4159,4160,4161,4162,4163,4164,4165,4213,4214,4215,4216,4217,4218,4219,4220,4221,4269,4270,4271,4272,4273,4274,4275,4276,4277,4326,4327,4328,4329,4330,4331,4332,4333,4334,4385,4386,4387,4388,4389,4390,4391,4392,4393,4443,4444,4446,4447,4449,4450,4451,4452,4453,4503,4504,4505,4506,4507,4508,4509,4510,4511,4563,4564,4565,4567,4568,4569,4570,4571,4572,4624,4626,4627,4628,4629,4630,4631,4632,4633,4673,4674,4675,4676,4677,4678,4679,4680,4681,4718,4719,4720,4721,4722,4723,4724,4725,4726,4764,4765,4766,4767,4768,4769,4770,4771,4772,4809,4810,4811,4812,4814,4815,4816,4817,4818,4858,4860,4861,4862,4863,4864,4865,4866,4867,4905,4907,4908,4909,4910,4911,4912,4913,4954,4955,4956,4957,4958,4959,4960,4961,4962,5006,5007,5008,5009,5010,5011,5012,5013,5014,5056,5059,5060,5063,5064,5065,5066,5067,5068,6008,6010,6011,6012,6013,6015,6016,6019,6021,6066,6067,6068,6069,6070,6072,6073,6076,6077,6124,6125,6126,6127,6128,6129,6130,6131,6132,6178,6179,6180,6181,6182,6183,6184,6185,6186,6228,6229,6230,6233,6234,6235,6236,6237,6239,6291,6293,6295,6297,6300,6301,6302,6304,6305,6351,6352,6353,6354,6355,6356,6358,6359,6360,6400,6401,6402,6403,6404,6405,6406,6407,6408,6452,6453,6454,6455,6456,6457,6459,6460,6461,6498,6499,6500,6501,6502,6503,6504,6505,6506,6547,6548,6550,6551,6554,6556,6557,6558,6559,6597,6598,6599,6600,6601,6602,6603,6604,6605,6644,6645,6646,6647,6648,6649,6650,6651,6652,6693,6694,6695,6696,6697,6698,6699,6700,6701,6409,6410,6411,6417,6419,6420,6421,6422,6423,6462,6463,6464,6465,6466,6467,6468,6469,6470,6507,6508,6509,6510,6511,6512,6513,6514,6515,6560,6561,6562,6563,6564,6565,6566,6567,6568,5069,5071,5072,5073,5074,5075,5076,5077,5078,6606,6607,6086,6087,6089,6090,6653,6654,6608,6609,6610,6611,6612,6613,6614,6022,6024,6027,6028,6029,6030,6031,6032,6033,6079,6080,6081,6084,6085,6655,6656,6657,6658,6659,6660,6661,6134,6135,6137,6138,6139,6142,6143,6144,6145,4682,4683,4684,4685,4686,4687,4688,4689,4690,6187,6188,6189,6191,6192,6193,6194,6195,6197,4727,4728,4729,4730,4731,4732,4733,4734,4735,6702,6703,6704,6705,6706,6707,6708,6709,6710,4773,4774,4775,4776,4777,4778,4779,4781,4782,6240,6241,6242,6243,6245,6252,6253,6254,6257,4819,4820,4821,4822,4823,4824,4825,4826,4280,4281,4282,4283,4284,4285,4286,6306,6307,6308,6309,6310,6311,6312,6313,6314,4335,4336,4827,4222,4223,4224,4225,4226,4227,4228,4229,4230,4868,4869,4870,4871,4872,4873,4874,4875,4876,4278,4279,4337,4338,4339,4340,4341,4342,4344,4914,4915,4916,4917,4918,4919,4920,4922,4923,4394,4395,4396,4397,4398,4399,4401,4402,4403,3738,3739,3740,3741,3742,3743,3744,3745,3746,4454,4455,4457,4458,4459,4460,4461,4462,4463,3802,3803,3804,3805,3806,3807,3809,3810,3811,4963,4964,4965,4967,4969,4971,4972,4973,4974,3868,3870,3871,3872,3875,3876,3879,3880,3881,4512,4513,4514,4515,4517,4518,4519,4521,4522,3935,3937,3938,3939,3940,3941,3942,3944,3945,6361,6362,6363,6364,6365,3473,2431,2434,6366,6367,6368,6369,3166,3167,3170,3171,3172,3173,3174,3175,3176,3994,3995,3996,3997,3998,3999,4000,4001,4002,3252,3253,3254,3255,3256,3257,3258,3262,3263,4573,4574,4575,4576,4577,4578,4579,4580,4581,3327,3328,3329,3330,3331,3332,3333,3334,3335,4053,4054,4055,4056,4057,4058,4059,4060,4061,3398,3399,3400,3401,3402,3403,3404,3405,3407,5015,5016,5017,5018,5019,5020,5021,5022,5023,2238,2240,2242,2245,2246,2247,2248,2253,2255,3465,3466,3467,3468,3469,3470,3471,3472,2435,2436,2440,2450,2451,2452,2453,4108,4109,4110,4111,4112,4113,4114,4115,4116,2548,2549,2550,2551,2553,2557,2559,2563,2566,3539,3540,3542,3543,3546,3547,3548,3549,3550,2688,2690,2691,2692,2693,2694,2695,2696,2697,4634,4635,4636,4637,4638,4639,4640,4641,4642,2813,2814,2815,2816,2817,2818,2819,2822,2823,3612,3613,3614,3615,3616,3617,3618,3619,3620,2894,2895,2896,2898,2899,2900,2901,2904,2905,4166,4167,4168,4169,4170,4171,4172,4173,4174,1478,1479,1485,1490,1491,1495,1505,1507,1511,3017,3018,3019,3021,3025,3026,3027,3028,3029,1716,1725,1728,1729,1733,1739,1741,1744,1750,3680,3681,3682,3684,3685,3686,3688,3689,3690,1902,1904,1907,1908,1911,1913,1916,1919,1923,3094,3095,3096,3097,3098,3099,3100,3101,3102,2081,2082,2087,2093,2094,2095,2096,2099,2102,1516,1520,1534,1547,1549,1552,1554,1556,1558,1756,1758,1761,1766,1770,1772,1774,1776,1778,1927,1928,1930,1931,1946,1952,1953,1954,1956,2106,2107,2110,2112,2115,2120,2122,2126,2127,2256,2260,2261,2266,2268,2271,2272,2274,2276,2457,2459,2462,2463,2465,2466,2467,2468,2471,2567,2569,2572,2573,2575,2577,2587,2591,2595,2698,2705,2708,2709,2710,2711,2713,2715,2719,2826,2827,2829,2831,2832,2833,2834,2835,2836,2908,2909,2910,2912,2913,2914,2916,2917,2918,3031,3032,3033,3034,3035,3036,3037,3038,3626,3627,3628,3629,3691,3693,3694,3695,3696,3697,3698,3699,3700,3747,3749,3039,3103,3104,3105,3106,3107,3108,3109,3110,3111,3177,3178,3179,3180,3181,3182,3185,3186,3187,3264,3266,3267,3269,3270,3271,3274,3275,3276,3336,3337,3338,3339,3340,3341,3342,3343,3344,3410,3411,3412,3413,3414,3415,3416,3417,3418,3474,3475,3476,3477,3478,3479,3480,3481,3482,3551,3552,3553,3554,3555,3556,3557,3559,3560,3621,3622,3623,3624,3625,3750,3751,3752,3753,3754,3755,3756,3813,3814,3815,3816,3818,3819,3822,3823,3824,3882,3883,3884,3885,3886,3887,3888,3889,3890,3946,3947,3948,3949,3950,3951,3952,3953,3954,4003,4004,4005,4006,4008,4009,4010,4011,4012,4062,4063,4064,4065,4066,4067,4068,4069,4070,4117,4118,4119,4121,4122,4123,4124,4125,4126,4175,4176,4177,4178,4179,4180,4181,4182,4183,4231,4232,4233,4234,4235,4236,4237,4238,4239,4287,4288,4290,4291,4292,4293,4294,4295,4296,4345,4346,4347,4348,4349,4350,4351,4352,4353,4404,4405,4406,4407,4408,4409,4410,4411,4413,4464,4465,4466,4467,4468,4469,4470,4471,4472,4523,4524,4525,4526,4527,4528,4529,4530,4531,4582,4583,4584,4585,4586,4588,4589,4591,4592,4643,4644,4645,4646,4647,4648,4649,4650,4652,4691,4692,4693,4694,4695,4696,4697,4698,4699,4736,4737,4738,4739,4740,4741,4742,4743,4744,4783,4784,4785,4786,4787,4788,4789,4790,4791,4828,4830,4831,4832,4833,4834,4835,4836,4837,4877,4878,4879,4881,4882,4883,4884,4885,4886,4924,4925,4926,4927,4928,4929,4930,4931,4932,4975,4977,4978,4980,4981,4982,4983,4984,4985,5024,5025,5026,5027,5028,5029,5030,5033,5035,5079,5080,5082,5083,5085,5086,5087,5088,5089,6034,6035,6036,6037,6038,6039,6040,6041,6042,6091,6092,6093,6094,6095,6096,6097,6099,6102,6146,6147,6148,6149,6151,6152,6155,6156,6157,6198,6199,6200,6201,6202,6204,6206,6207,6258,6259,6262,6263,6264,6265,6267,6268,6269,6315,6318,6319,6572,6573,6574,6575,6576,6577,6615,6616,6617,6618,6619,6620,6621,6622,6623,6662,6663,6664,6320,6321,6324,6325,6326,6328,6370,6371,6372,6373,6374,6376,6377,6379,6380,6424,6425,6426,6427,6428,6429,6430,6431,6432,6471,6472,6473,6474,6475,6476,6477,6478,6479,6516,6517,6518,6519,6520,6521,6522,6523,6524,6569,6570,6571,6666,6667,6668,6669,6670,6711,6214,6215,6216,6342,6343,6344,6345,6346,6347,6348,6349,6350,6270,6273,6274,6275,6276,6277,6712,6713,6714,6715,AW4334,6634,6635,6636,6637,6638,6639,6640,6642,6643,6480,6481,6482,6483,6484,6485,6486,6487,6488,6683,6684,6685,6687,6688,6689,6690,6691,6692,6525,6526,6527,6528,6529,6530,6531,6532,6489,6490,6491,6492,6493,6494,6495,6496,6497,6578,6579,6580,6581,6582,6584,6585,6586,6587,6282,6283,6284,6285,6286,6287,6288,6289,6290,6624,6625,6626,6627,6628,6629,6631,6632,6633,6536,6537,6538,6541,6542,6543,6544,6545,6546,6208,6209,6210,6211,6212,6278,6280,6281,6115,6116,6117,6118,6119,6120,6121,6122,6123,6671,6673,6675,6676,6677,6679,6680,6681,6682,6330,6331,6333,6334,6335,6337,6338,6339,6341,6168,6169,6170,6172,6173,6174,6175,6176,6177,6391,6392,6393,6394,6395,6396,6397,6398,6399,4986,4987,4988,4989,4990,4991,4992,4993,4994,5047,5048,5049,5050,5051,5052,5053,5054,5055,5037,5039,5040,5041,5042,5043,5044,5045,5046,6381,6382,6383,6384,6385,6386,6388,6389,6390,6217,6219,6220,6221,6222,6223,6224,6225,6227,5090,5091,5092,5093,5094,5095,5096,5097,5098,5099,6000,6001,6002,6003,6004,6005,6007,4896,4897,4898,4899,4900,4901,4902,4903,4904,6588,6589,6590,6591,6592,6593,6594,6595,6596,6043,6044,6045,6046,6047,6048,6049,6050,6054,4746,4747,4748,4749,4750,4751,4752,4753,4754,4943,4945,4946,4948,4949,4950,4951,4952,4953,4792,4793,4794,4795,4796,4797,4798,4799,4800,4755,4756,4757,4758,4759,4760,4761,4762,4763,6104,6105,6106,6108,6109,6110,6111,6112,6113,4838,4839,4840,4841,4842,4843,4844,4845,4846,6055,6056,6057,6059,6060,6061,6063,6064,6065,4887,4888,4889,4890,4891,4892,4893,4894,4895,4801,4802,4803,4804,4805,4806,4807,4808,4605,4606,4607,4608,4609,4610,4611,4612,4613,6433,6434,6435,6436,6437,6438,6439,6440,6441,4473,4474,4475,4476,4477,4478,4479,4480,4481,4995,4996,4997,4998,4999,5000,5001,5003,5004,4424,4425,4426,4428,4429,4430,4431,4432,4433,4534,4535,4536,4537,4538,4539,4540,4541,4543,4933,4934,4935,4936,4937,4938,4939,4940,4942,4593,4594,4595,4597,4598,4599,4601,4602,4603,6442,6443,6444,6445,6446,6447,6449,6450,6451,4482,4483,4484,4485,4486,4487,4488,4489,4490,4662,4663,4664,4665,4666,4668,4669,4670,4671,4306,4308,4309,4310,4311,4312,4313,4314,4316,4127,4128,4129,4130,4131,4132,4133,4134,4135,4653,4654,4655,4656,4657,4658,4659,4660,4661,4184,4185,4187,4188,4189,4190,4191,4192,4193,4848,4849,4850,4851,4852,4853,4854,4855,4857,4136,4137,4138,4139,4141,4142,4143,4144,4145,4240,4241,4242,4243,4244,4245,4246,4247,4248,6158,6159,6160,6161,6162,6163,6164,6165,6167,3964,3965,3966,3967,3968,3969,3970,3971,3973,4297,4298,4299,4300,4301,4302,4303,4304,4305,4700,4701,4702,4703,4704,4705,4706,4707,4708,4363,4364,4365,4367,4368,4369,4370,4371,4373,3825,3826,3827,3828,3829,3830,3831,3833,3834,4194,4195,4196,4197,4198,4199,4200,4201,4202,3892,3895,3898,3899,3900,3901,3902,3903,3904,4023,4024,4025,4026,4027,4028,4029,4030,4032,3835,3836,3837,3839,3842,3843,3844,3845,3846,3955,3956,3957,3958,3959,3960,3961,3962,3963,4354,4355,4356,4357,4358,4359,4360,4361,4362,3642,3643,3644,3645,3646,3647,3648,3649,3651,4544,4546,4547,4548,4549,4550,4551,4552,4553,4013,4014,4016,4017,4018,4019,4020,4021,4022,4709,4710,4711,4712,4713,4714,4715,4716,4717,3483,3485,3486,3488,3489,3490,3491,3492,3493,3905,3906,3907,3908,3909,3910,3911,3717,3718,3354,3355,3356,3357,3358,3359,3360,3912,3913,3494,3495,3496,3497,3498,3499,3500,3501,3502,3561,3563,3564,3565,3566,3567,3568,3569,3570,4414,4415,4416,4417,4419,4420,4421,4422,4423,3631,3632,3633,3635,3636,3637,3638,3639,3640,3710,3711,3712,3713,3714,3715,3716,3361,3363,4071,4072,4073,4074,4075,4076,4077,4078,4079,3121,3122,3123,3124,3125,3126,3127,3129,3130,3040,3044,3045,3047,3049,3050,3051,3052,3053,3701,3702,3703,3704,3705,3706,3707,3708,3709,3112,3113,3114,3115,3116,3117,3118,3119,3120,3571,3572,3573,3575,3576,3577,3578,3579,3580,4080,4081,4082,4083,4084,4085,4086,4087,4088,2932,2933,2934,2935,2936,2937,2938,2939,2941,3188,3189,3190,3191,3192,3194,3195,3196,3197,3198,3199,3201,3202,3203,3204,3205,3206,3208,4249,4250,4251,4252,4253,4254,4255,4257,4258,3277,3279,3280,3281,3282,3283,3284,3285,3286,2738,2740,2742,2743,2744,2748,2750,2754,2757,2473,2474,2476,2483,2484,2486,2489,2491,2492,3428,3429,3430,3431,3432,3433,3434,3435,3436,2602,2603,2610,2611,2617,2621,2626,2627,2628,3054,3055,3056,3057,3058,3059,3060,3062,3063,2720,2721,2722,2724,2725,2732,2733,2734,2737,2494,2496,2497,2498,2500,2501,2503,2506,2508,3345,3346,3347,3348,3349,3350,3351,3352,3353,1981,1982,1983,1986,1987,1991,1994,1996,1997,3757,3758,3761,3762,3763,3764,3765,3766,3767,2837,2838,2839,2841,2842,2844,2845,2846,2847,3768,3770,3771,3772,3773,3774,3779,3781,3782,1562,1563,1564,1569,1573,1574,1576,1577,1580,1019,1022,1032,1040,1064,1099,1107,1110,1119,2850,2852,2854,2855,2857,2858,2859,2860,2861,1581,1584,1588,1589,1590,1600,1607,1612,1617,1779,1780,1781,1783,1785,1787,1793,1794,1795,2921,2922,2923,2924,2925,2928,2929,2930,2931,1958,1961,1964,1967,1972,1973,1975,1976,1979,2150,2151,2153,2154,2155,2156,2160,2163,2165,2629,2631,2633,2634,2635,2636,2637,2639,2640,2133,2136,2137,2138,2140,2144,2147,2148,2149,1796,1800,1801,1803,1809,1810,1811,1819,1823,3287,3288,3289,3290,3291,3292,3293,3294,3295,3419,3420,3421,3422,3423,3424,3425,3426,3427,2280,2281,2287,2292,2296,2299,2305,2307,2308,1121,1122,1174,1185,1187,1199,1210,1230,1233,2319,2321,2323,2324,2325,2329,2333,2334,2337])
////                ->get();
//
//
//            Excel::load($address, function($reader) {
//                $results = $reader->get();
////                dd($results);
//                $grade11 = 0;
//                $t = 0;
//                $d = 0;
//                foreach ($results as $cel) {
//
//                    $employee = Employee::where('pfno', trim($cel->pfno))->first();
////dd($cel);
//                    $grade = substr($cel->scale, 4, 2);
//                    $scale_year = substr($cel->scale, 0, 4);
////                    $AC = $pos = strpos(trim($cel->desig_name), '(AC)');
////                    $CC = $pos = strpos(trim($cel->desig_name), '(CC)');
////                    $EC = $pos = strpos(trim($cel->desig_name), '(EC)');
////                    $designation_status = 1;
////                    if($AC > 0){
////                        $designation_status = 2;
////                    }elseif($CC > 0){
////                        $designation_status = 3;
////                    }elseif($EC > 0){
////                        $designation_status = 4;
////                    }
////
////                         if($designation_status == 1 && $cel->chargeallowance < 1500 && $cel->chargeallowance > 5) {
////                             echo "<br/>".'pfno-' . trim($cel->pfno);
////                             $grade11++;
////
////                            }
////                    if($cel->providantfund > 0) {
////                        $netAmount = round($cel->basicpay * 0.125);
////                        if ($netAmount != $cel->providantfund) {
////                            $d =  $cel->providantfund - $netAmount;
////                            echo "<br/>" . 'pfno-' . trim($cel->pfno) . 'net=' . $cel->providantfund  . ' / ' . $netAmount. '=' .$d;
////                        }
////                        $t ++;
////                        $grade11 +=$d;
////                    }
//
//
////                    if($cel->houseallowance > 0) {
////                        $loc =1;
////                        if(trim($cel->department_name) == "Narayanganj Water Supply" || trim($cel->department_name) == "Revenue Zone - Narayanganj"){
////                            $loc = 2;
////                        }
////                        $p =PayrollSettings::get();
////                        $pData =$p->where('basic_pay','>=',$cel->basicpay)->where('payroll_head_id',4)->where('ref_id',$loc)->sortBy('basic_pay')->first();
////                        if($pData) {
////                            $netAllowance = $pData->rate * $cel->basicpay;
////                            $return = $netAllowance >= $pData->min ? $netAllowance : $pData->min;
////                            if($return != $cel->houseallowance){
////                                $d =  $cel->houseallowance - $return;
////
////                                echo "<br/>" . 'pfno-' . trim($cel->pfno) . 'wasa=' . $cel->houseallowance  . ' / ' . $return. '=' .$d;
////                            }
////                        }
////                        $t ++;
////                        $grade11 +=$d;
////                    }
//
////                    if($cel->groupinsurance > 1 && $grade <= 10  && $employee->status == "Continue"){
////                        echo "<br/>grade-".$grade.'- pfno-' . trim($cel->pfno);
////                        $grade11++;
////                    }
//
////                        if ($cel->chargeallowance > 0){
////                            echo "<br/>grad-".$grade.'=' . trim($cel->pfno);
////                            $grade11++;
////                        }
//
//
//
//
//                    //dd("Done");
//    continue;
//
//
//                    $employee = Employee::where('pfno', trim($cel->pfno))->first();
//
////                    if (is_null($employee)) {
////                      //  echo "<br/>" . trim($cel->pfno);
////                    } else {
//
//
//
////                        // UPDATE EMPLOYEE info
////                        $employee->first_joining_date = trim($cel->doj);
////                        $bankId = null;
////                        $branchId = null;
////                        if ($cel->bankid == 1001) {
////                            $bankId = 41; //Sonali Bank Ltd.
////                            if ($cel->branchid == 1001) {
////                                $branchId = 6746; //NARAYANGANJ CORPORATE(121)
////                            }
////                        }elseif ($cel->bankid == 5001) {
////                            $bankId = 25; //   ISLAMI BANK BANGLDESH LTD.
////                            if ($cel->branchid == 5001) {
////                                $branchId = 2877; //KARWAN BAZAR(253)
////                            }
////                        }elseif ($cel->bankid == 3001) {
////                            $bankId = 36; //   PUBALI BANK LTD.
////                            if ($cel->branchid == 3001) {
////                                $branchId = 4633; //KARWAN BAZAR(253)
////                            }
////                        }else if ($cel->bankid == 4001) {
////                            $bankId = 34; //ONE BANK LTD.
////                            if ($cel->branchid == 4001) {
//////                                $branchId = 4378; //NAWABGANJ(469)
////                                $branchId = 4388; //Narayangonj
////                            } elseif ($cel->branchid == 4002) {
////                                $branchId = 4365; //KARWAN BAZAR(253)
////                            }
////                        } else if ($cel->bankid == 2001) {
////                            $bankId = 27; //JANATA BANK LTD.
////                            if ($cel->branchid == 2006) {
////                                $branchId = 8786;//Motijheel Corporate
////                            } elseif ($cel->branchid == 2001) {
////                                $branchId = 8674;//Kawran Bazar Corporate
////                            } elseif ($cel->branchid == 2007) {
////                                $branchId = 8674;//Kawran Bazar Corporate
////                            } elseif ($cel->branchid == 2004) {
////                                $branchId = 8899; //Posta Branch
////                            } elseif ($cel->branchid == 2002) {
////                                $branchId = 9075; //Topkhana Rd Corporate
////                            } elseif ($cel->branchid == 2003) {
////                                $branchId = 9103; //WAPDA Corporate Branch
////                            } elseif ($cel->branchid == 2005) {
////                                $branchId = 8367; //Chakbazar
////                            }
////                        }
////                        $employee->bank_name = trim($bankId);
////                        $employee->branch_name = trim($branchId);
////
////                        $employee->bank_account_no = trim($cel->bankaccountno);
////                        $employee->bank_account_no_t24 = trim($cel->t_24_act);
////
////                        $employee->status = trim($cel->statuss);
////                        $employee->updated_by = Auth::user()->id;
////                        $employee->save();
////                    }
//
//                }
//                echo '<br>total' . $t;
//                echo '<br>total' . $grade11;
//            });
//            DB::commit();
//
//            echo '<br>Complete';
//            dd("Done");
//        } catch (\Exception $ex) {
//            DB::rollback();
//            dd($ex);
//        }
    }

    public function updateEmployeeBasicSalary() {

//        set_time_limit(900);
//        ini_set('max_execution_time', 1000);
        ini_set('memory_limit', '-1');
//        $address = public_path('doc/Payroll20190829.xls');
//        $address = public_path('doc/september/HRM_EMP_NAME_September.xlsx');
//        $address = public_path('doc/september/Salarysheet_September2019.xlsx');
        $address = public_path('doc/october/Salarysheet_October2019.xlsx');
        try {
            DB::beginTransaction();
            Excel::load($address, function($reader) {
                $results = $reader->get();
//                dd($results);

                $employeeChildren = 0 ;
                $newPayRollSetting = 0 ;
                foreach ($results as $cel) {
                    dd($cel);
                    $employee = Employee::where('pfno', trim($cel->pfno))->first();

                    if (is_null($employee)) {
                        echo "<br/>" . trim($cel->pfno);
                    }
                    else {

//                     //    UPDATE EMPLOYEE BASIC PAY AND SCALE
////                        if($cel->basicpay > 0){
////                            $employee->last_basic_pay =  $employee->current_basic_pay;
////                            $employee->current_basic_pay = $cel->basicpay;
////                        }
////
////                            $grade = substr($cel->scale, 4, 2);
////                            $scale_year = substr($cel->scale, 0, 4);
////                            $employee->grade = $grade;
////                        $AC = $pos = strpos(trim($cel->desig_name), '(AC)');
////                        $CC = $pos = strpos(trim($cel->desig_name), '(CC)');
////                        $EC = $pos = strpos(trim($cel->desig_name), '(EC)');
////
////                        $designation_status = 1;
////                        if($AC > 0){
////                            $designation_status = 2;
////                        }elseif($CC > 0){
////                            $designation_status = 3;
////                        }elseif($EC > 0){
////                            $designation_status = 4;
////                        }
//                        $d = Department::where('old_id',$cel->dept_id)->first();
//                        if($d->id != $employee->office_id )
//                        {
//                            $employee->office_id = $d->id;
//                        }
//                        $designation_id = Designation::where('old_id',$cel->desig_id)->first();
////                        dd($employee,$designation_id,$d);
//////
//////                        $employee->designation_id = $designation_id->id;
//////                        $employee->designation_ranking = $designation_id->ranking_id;
//////    $employee->save();
////
//                            if($employee->designation_id != $designation_id->id){
//                                $employee->designation_id = $designation_id->id;
//                            }
//                            if($employee->designation_ranking !=  $designation_id->ranking_id){
//                                $employee->designation_ranking = $designation_id->ranking_id;
//                            }
////                            $employee->designation_status = $designation_status;
////                            if($designation_status > 1 ){
////                                if($cel->chargeallowance > 0){
////                                    $employee->charge_allowance_effective = '2019-09-01';
////                                }else{
////
////                                    $employee->charge_allowance_effective = '2019-09-20';
////                                }
////                            }
//
////                            $scale = PayScaleList::where(['grade'=> $grade ,'scale'=>$cel->basicpay,'scale_year'=>$scale_year])->first();
////                            if ($scale instanceof PayScaleList){
////                                $employee->scale_id = $scale->id;
////                            }
//
//                            $employee->updated_by = Auth::user()->id;
//                            $employee->save();
//                  //           Employee Wasa Job Experience Update
////                             $job = EmployeeWasaJobExperience::where('employee_id',$employee->id)->where('basic_pay',$employee->current_basic_pay)->orderBy('id','desc')->first();
////
////                            if($job instanceof EmployeeWasaJobExperience){
////
////                                if($job->scale_year == null){
////                                    $job->scale_year = 2015;
////                                }
////                                if($job->scale_id == null){
////                                    $job->scale_id = $employee->scale_id;
////                                }
////                                if($job->grade == null){
////                                    $job->grade = $employee->grade;
////                                }
//////                                if($employee->current_basic_pay > $job->basic_pay){
//////                                    $job->basic_pay = $employee->current_basic_pay;
//////                                }
////                                if($job->designation_idv == null){
////                                    $job->designation_id = $employee->designation_id;
////                                }
////                                $job->updated_at  = Carbon::now();
////                                $job->updated_by = Auth::user()->id;
////                                $job->save();
////                            }else{
////                                $job = new EmployeeWasaJobExperience();
////                                $job->employee_id = $employee->id;
////                                $job->pfno = $employee->pfno;
////                                $job->scale_year = 2015;
////                                $job->scale_id = $employee->scale_id;
////                                $job->basic_pay = $employee->current_basic_pay;
////                                $job->designation_id = $employee->designation_id;
////                                $job->office_id = $employee->office_id;
////                                $job->joining_date = $employee->joining_date;
////                                $job->save();
////                            }
//                        if($employee->current_basic_pay > 0) {
//                            $job = EmployeeWasaJobExperience::where('employee_id', $employee->id)->where('basic_pay', $employee->current_basic_pay)->where('designation_id', $employee->designation_id)->orderBy('id', 'desc')->first();
////                            dd($job,$employee->designation_id);
//                            if (!$job instanceof EmployeeWasaJobExperience) {
//                                $newPayRollSetting++;
//                                $job = new EmployeeWasaJobExperience();
//                                $job->employee_id = $employee->id;
//                                $job->order_date = '2019-08-01';
//                                $job->joining_date = '2019-09-01';
//                                $job->created_by = Auth::user()->id;
//                            } else {
//                                $job->updated_by = Auth::user()->id;
//                            }
//                            $job->pfno = $employee->pfno;
//                            $job->designation_id = $employee->designation_id;
//                            $job->scale_id = $employee->scale_id;
//                            $job->scale_year = 2015;
//                            $job->designation_status = $employee->designation_status;
//                            $job->grade = $employee->grade;
//                            $job->office_id = $employee->office_id;
//                            $job->basic_pay = $employee->current_basic_pay;
//                            $job->save();
//                        }
                        //         UPDATE EMPLOYEE PAYROLL SETTINGS

                        $employeePayrollSettings = EmployeePayrollSetting::where('employee_id', $employee->id)->first();

                        if (is_null($employeePayrollSettings)) {
                            $newPayRollSetting++;
                            $employeePayrollSettings = new EmployeePayrollSetting();
                            $employeePayrollSettings->employee_id = $employee->id;
                            $employeePayrollSettings->pfno = $employee->pfno;
                        }

                        $employeePayrollSettings->spl_pay_amount = (trim($cel->specialpay) > 0) ? trim($cel->specialpay) : 0;
                        $employeePayrollSettings->salary_arr = (trim($cel->salaryarrear) > 0) ? trim($cel->salaryarrear): 0;
                        $employeePayrollSettings->hr_arr = (trim($cel->hrarrear) > 0) ? trim($cel->hrarrear): 0;
                        $employeePayrollSettings->other_alw = (trim($cel->otherallowance) > 0) ? trim($cel->otherallowance): 0;
                        $employeePayrollSettings->it_ded = (trim($cel->itdeduct) > 0) ? trim($cel->itdeduct) : 0;
                        $employeePayrollSettings->vhl_alw = (trim($cel->deputationallowance) > 0) ? trim($cel->deputationallowance) : 0;
                        $employeePayrollSettings->wash_alw = (trim($cel->washallowance) > 0) ? trim($cel->washallowance) : 0;
                        $employeePayrollSettings->pf_refund = (trim($cel->pfrefund) > 0) ? trim($cel->pfrefund) : 0;
                        $employeePayrollSettings->prv_fund_type = (trim($cel->providantfund) > 0) ? 1 : 0;
                        $employeePayrollSettings->prv_fund = (trim($cel->providantfund) > 0) ? 12.500 : 0;

                        $employeePayrollSettings->h_rent = (trim($cel->houserentdeduction) > 0) ? 1 : 0;
                        $employeePayrollSettings->ws_ded = (trim($cel->waterandseweragededuction) > 0) ? 1 : 0;
                        $employeePayrollSettings->stove = (trim($cel->titasgas) >= 975) ? 2 : 0;
                        $employeePayrollSettings->titas_gas = (trim($cel->titasgas) > 0) ? 1 : 0;
                        $employeePayrollSettings->gas_alw = (trim($cel->gasallowance) > 0) ? 1 : 0;
                        $employeePayrollSettings->transport = (trim($cel->transportcharge) > 0 ) ? trim($cel->transportcharge) : 0;

                        $employeePayrollSettings->pf_loan =(trim($cel->pfloanadvance) > 0) ? trim($cel->pfloanadvance) : 0 ;
                        $employeePayrollSettings->hb_loan =(trim($cel->hbdeduction) > 0) ? trim($cel->hbdeduction) : 0 ;
                        $employeePayrollSettings->hb_inttr = (trim($cel->hbinterest) > 0) ? trim($cel->hbinterest) : 0;
                        $employeePayrollSettings->pc_loan = (trim( $cel->computerloan) > 0) ? trim( $cel->computerloan) : 0;


                        $employeePayrollSettings->sal_ded = (trim( $cel->salarydeduction) > 0) ? trim( $cel->salarydeduction) : 0;
                        $employeePayrollSettings->other_ded = (trim( $cel->othersdeduction) > 0) ? trim( $cel->othersdeduction) : 0;
//
                        $employeePayrollSettings->updated_at = \Carbon\Carbon::now();
                        $employeePayrollSettings->save();
                        if ($cel->educationallowance > 0) {

                            $input = [
                                'employee_id' => $employee->id,
                                'pfno' => $employee->pfno,
                                'edu_alw' => 1,
                                'children_name' => 'Children',
                                'date_of_birth' => '2010-01-01',
                            ];
                            $exist_children = \App\EmployeeProfile\Model\EmployeeChildren::where('employee_id', $employee->id)->count();
                            if ($cel->educationallowance >= 1000) {

                                if ($exist_children <= 0) {
                                    $employeeChildren +=2;
                                    \App\EmployeeProfile\Model\EmployeeChildren::create($input);
                                    \App\EmployeeProfile\Model\EmployeeChildren::create($input);
                                } elseif ($exist_children == 1) {
                                    $employeeChildren++;
                                    \App\EmployeeProfile\Model\EmployeeChildren::create($input);
                                }
                                $last2 =EmployeeChildren::where('employee_id', $employee->id)->orderBy('id','desc')->limit(2)->get();
                                foreach ($last2 as $last){
                                    $last->edu_alw = 1;
                                    if($last->children_name == null){
                                        $last->children_name = 'Children';
                                    }
                                    if($last->date_of_birth == '2018-01-01'){
                                        $last->date_of_birth = '2010-01-01';
                                    }
                                    if($last->pfno == null){
                                        $last->pfno = $cel->pfno;
                                    }
                                    $last->save();
                                }

                            } elseif ($cel->educationallowance == 500 || $cel->educationallowance == 300) {

                                if ($exist_children <= 0) {
                                    $employeeChildren++;
                                    \App\EmployeeProfile\Model\EmployeeChildren::create($input);
                                }else{
                                    $last =EmployeeChildren::where('employee_id', $employee->id)->orderBy('id','desc')->first();
                                    $last->edu_alw = 1;
                                    if($last->date_of_birth == '2018-01-01'){
                                        $last->date_of_birth = '2010-01-01';
                                    }
                                    if($last->children_name == null){
                                        $last->children_name = 'Children';
                                    }
                                    if($last->pfno == null){
                                        $last->pfno = $cel->pfno;
                                    }
                                    $last->save();
                                }

                            }

                        }else{
                            DB::table('employee_childrens')
                                ->where('employee_id', $employee->id)
                                ->update(['edu_alw' => 0,'updated_at'=> \Carbon\Carbon::now()]);
                        }

                    }
                }
                echo '<br>  Employee Children= ' . $employeeChildren ;
                echo '<br> New Payroll employee create = ' . $newPayRollSetting ;

            });
            DB::commit();
            echo '<br>Complete';
            dd("Done");
        } catch (\Exception $ex) {
            DB::rollback();
            dd($ex);
        }
    }

    public function loanData(){

        set_time_limit(900);
        ini_set('max_execution_time', 1000);
        ini_set('memory_limit', '-1');
        $address = public_path('doc/EmpDesignation.csv');
        try {
            \Illuminate\Support\Facades\DB::beginTransaction();
            Excel::load($address, function($reader) {
                $results = $reader->get();

                foreach ($results as $cel) {

                    $employee = Employee::where('pfno', trim($cel->pfno))->first();

                    if (is_null($employee)) {
                        echo "<br/>" . trim($cel->pfno);
                    } else {

                        if ($employee->house_loan_id != null && $employee->houseLoan->status != "Closed")
                            return redirect('loan-application/house-building')->withErrors("There is already pending house loan of this employee.");

                        $max_amount = $employee->experience->scale->max_house_loan;
                        /**EmployeeMembership
                        if($cel->dpsfee > 0){
                        $em = new EmployeeMembership();
                        $em->membership_organization_id = 6;
                        $em->employee_id	= 	$employee->id;
                        $em->is_exist = 1;
                        $em->save();
                        }
                        if($cel->deasfee > 0){
                        $em = new EmployeeMembership();
                        $em->membership_organization_id = 7;
                        $em->employee_id	= 	$employee->id;
                        $em->is_exist = 1;
                        $em->save();
                        }
                        if($cel->unionsub > 0){
                        $em = new EmployeeMembership();
                        $em->membership_organization_id = 9;
                        $em->employee_id	= 	$employee->id;
                        $em->is_exist = 1;
                        $em->save();
                        }
                        if($cel->dhakusfee > 0){
                        $em = new EmployeeMembership();
                        $em->membership_organization_id = 8;
                        $em->employee_id	= 	$employee->id;
                        $em->is_exist = 1;
                        $em->save();
                        }
                         */


                        $loan_category_id = 1 ;
                        $monthly_deduction_type = 0;
                        $loanAmount = $cel->hbdeduction;
//        if ($loan_category_id) {
//            $hbLoan = LoanInfo::where('employee_id', $employee->id)->where('status', '!=', 'Closed')->where('loan_category_id', $loan_category_id)->count();
//            $status = trim($cel->statuss);
//            if ($hbLoan == 0 && $loanAmount > 0  ) {
//                $loanInfo = new LoanInfo();
//                $loanInfo->employee_id = $employee->id;
//                $loanInfo->loan_category_id = $loan_category_id;
//                $loanInfo->ref_no = $employee->pfno;
//                $loanInfo->ref_date = changeDateFormatToDb('1970-01-01');
//                $loanInfo->loan_eff_date = changeDateFormatToDb('1970-01-01');
//                $loanInfo->loan_amount = $loanAmount*20;
//                $loanInfo->max_amount = $max_amount ? $max_amount : 1500000;
//                $loanInfo->cheque_no =  $employee->pfno;
//                $loanInfo->cheque_date = changeDateFormatToDb('1970-01-01');
//                $loanInfo->installment_no = 1;
//                $loanInfo->monthly_deduction = $loanAmount;
//                $loanInfo->monthly_deduction_type = $monthly_deduction_type;
//                $loanInfo->status = "Initiated"; // Initiated/ Pending/ Closed
//                $loanInfo->generated_id = date("Ymd") . $loanInfo->id;
//                $loanInfo->save();
//
//                $ledger = new LoanLedger();
//                $ledger->pay_date = $loanInfo->loan_eff_date;
//                $ledger->principal_balance = $loanInfo->loan_amount;
//                $ledger->interest_rate = getLoanInterest($loan_category_id);
//                $ledger->total_balance = $loanInfo->loan_amount;
//                $ledger->employee_id = $employee->id;
//                $ledger->loan_category_id = $loan_category_id;
//                $ledger->ref_no = $loanInfo->ref_no;
//                $ledger->ref_date = $loanInfo->ref_date;
//                $ledger->loan_eff_date = $loanInfo->loan_eff_date;
//                $ledger->loan_amount = $cel->loanamount;
//                $ledger->loan_id = $loanInfo->id;
//                $ledger->save();
//            }
//        }

                    }
                }
            });
            DB::commit();

            echo '<br>Complete';
            dd("Done");

        } catch (\Exception $ex) {
            DB::rollback();
            \Illuminate\Support\Facades\Log::error($ex);
        }
    }

    public function updateEmployeeDepartment() {
//exit('ok');
        set_time_limit(900);
        ini_set('max_execution_time', 1000);
        ini_set('memory_limit', '-1');
//        $address = public_path('doc/HRM_EMP_NAME.xls');
        $address = public_path('doc/october/HRM_EMP_NAME.xlsx');
//        $address = public_path('doc/september/HRM_EMP_NAME_September.xlsx');
//        $address = public_path('doc/september/Salarysheet_September2019.xlsx');;
        try {
            DB::beginTransaction();
            Excel::load($address, function($reader) {
                $results = $reader->get();
//                dd($results);

                $employeeChildren = 0 ;
                $newPayRollSetting = 0 ;
                foreach ($results as $cel) {

                    $employee = Employee::where('pfno', trim($cel->pfno))->first();
//                    dd($cel,$employee);
                    if (is_null($employee)) {
//                        echo "<br/>" . trim($cel->pfno);
                    } else {
//                        if( $cel->basicpay == 0)
//                        {
////                            $employee->current_basic_pay = $cel->empbasic;
//                            echo "<br/>".$newPayRollSetting++." PFNO -" . trim($cel->pfno) . ' status - '. $employee->status;
//
//                        }
                        if( $cel->religion !=null && $employee->religion == null)
                        {
                            $employee->religion = $cel->religion;

                            $employee->save();
                        }
//                        $d = Department::where('old_id',$cel->dept_id)->first();
//                        if($d->id != $employee->office_id )
//                        {
////                            echo "<br/> Department Not match -" . trim($cel->pfno);
//                        }

//                        if($d instanceof Department){
//                            $employee->office_id = $d->id;
//                            DB::table('employee_wasa_job_experiences')
//                                ->where('employee_id',$employee->id)
//                                ->update(['office_id' => $d->id]);
//                        }
//                        $designation = Designation::where('old_id',$cel->desig_id)->first();
////                        dd($cel->desig_id, $designation->id , $employee->designation_id ,$cel->pfno);
//                        if($designation->id != $employee->designation_id )
//                        {
////                            echo "<br/> Designation can  not match -" . trim($cel->pfno);
//                        }
//                        if($d instanceof Designation){
//                            $employee->designation_id = $designation->id;
//                            $employee->designation_ranking = $designation->ranking_id;
//                        }

//                        if($cel->empbasic > 0){
//                            $employee->current_basic_pay = trim($cel->empbasic);
//                        }
//                       $employee->first_joining_date = trim($cel->doj);
//                        $bankId = null;
//                        $branchId = null;
//                        if ($cel->bankid == 1001) {
//                            $bankId = 41; //Sonali Bank Ltd.
//                            if ($cel->branchid == 1001) {
//                                $branchId = 6746; //NARAYANGANJ CORPORATE(121)
//                            }
//                        }elseif ($cel->bankid == 5001) {
//                            $bankId = 25; //   ISLAMI BANK BANGLDESH LTD.
//                            if ($cel->branchid == 5001) {
//                                $branchId = 2877; //KARWAN BAZAR(253)
//                            }
//                        }elseif ($cel->bankid == 3001) {
//                            $bankId = 36; //   PUBALI BANK LTD.
//                            if ($cel->branchid == 3001) {
//                                $branchId = 4633; //KARWAN BAZAR(253)
//                            }
//                        }else if ($cel->bankid == 4001) {
//                            $bankId = 34; //ONE BANK LTD.
//                            if ($cel->branchid == 4001) {
////                                $branchId = 4378; //NAWABGANJ(469)
//                                $branchId = 4388; //Narayangonj
//                            } elseif ($cel->branchid == 4002) {
//                                $branchId = 4365; //KARWAN BAZAR(253)
//                            }
//                        } else if ($cel->bankid == 2001) {
//                            $bankId = 27; //JANATA BANK LTD.
//                            if ($cel->branchid == 2006) {
//                                $branchId = 8786;//Motijheel Corporate
//                            } elseif ($cel->branchid == 2001) {
//                                $branchId = 8674;//Kawran Bazar Corporate
//                            } elseif ($cel->branchid == 2007) {
//                                $branchId = 8674;//Kawran Bazar Corporate
//                            } elseif ($cel->branchid == 2004) {
//                                $branchId = 8899; //Posta Branch
//                            } elseif ($cel->branchid == 2002) {
//                                $branchId = 9075; //Topkhana Rd Corporate
//                            } elseif ($cel->branchid == 2003) {
//                                $branchId = 9103; //WAPDA Corporate Branch
//                            } elseif ($cel->branchid == 2005) {
//                                $branchId = 8367; //Chakbazar
//                            }
//                        }
//                        $employee->bank_name = trim($bankId);
//                        $employee->branch_name = trim($branchId);
//                        $employee->bank_account_no = trim($cel->bankaccountno);
//                        $employee->bank_account_no_t24 = trim($cel->t_24_act);
//                        $employee->status = trim($cel->statuss);

//                        $grade = substr($cel->scale, 4, 2);
////                        $scale_year = substr($cel->scale, 0, 4);
//                        if($grade != $employee->grade )
//                        {
////                            echo "<br/> grade can  not match -" . trim($cel->pfno);
//                        }
//                        $employee->grade = $grade;


//                        $employee->save();
                    }
                }

            });
            DB::commit();
            echo '<br>Complete';
            dd("Done");
        } catch (\Exception $ex) {
            DB::rollback();
            dd($ex);
        }
    }
    public function payroll() {

        set_time_limit(900);
        ini_set('max_execution_time', 1000);
        ini_set('memory_limit', '-1');
//        $address = public_path('doc/Payroll20190829.xls');
//        $address = public_path('doc/september/Salarysheet_September2019.csv');
        $address = public_path('doc/october/Salarysheet_October2019.xlsx');
        try {
            DB::beginTransaction();
            Excel::load($address, function($reader) {
                $results = $reader->get();
//                dd($results);

                foreach ($results as $cel) {
//                    if($cel->pfno == 2936){
//                        dd($cel->salaryarrear,trim($cel->salaryarrear));
//
//                    }
//                    $payroll = new Payroll();

                    $employee = Employee::where('pfno', trim($cel->pfno))->first();
//dd($cel);
                    if (is_null($employee)) {
                        echo "<br/>" . trim($cel->pfno);
                    }
                    else {
                        $d = Department::where('department_name', trim($cel->department_name))->first();
                        $designation = Designation::where('title',trim($cel->desig_name))->first();

                        if($designation != null)
                        {

                            if("Office Asstt. cum DEO" == trim($cel->desig_name)){
                                $employee->designation_id = 160;
                                $employee->designation_ranking = 999;
                            }else{
                                $employee->designation_id = $designation->id;
                                $employee->designation_ranking = $designation->ranking_id;
                            }

                        }
                        $employee->save();
                        if($d != null){
                            $employee->office_id = $d->id ;
                            $employee->save();
                            $job = EmployeeWasaJobExperience::where('employee_id', $employee->id)->where('basic_pay', $employee->current_basic_pay)->where('designation_id', $employee->designation_id)->orderBy('id', 'desc')->first();
//                            dd($job,$employee->designation_id);
                            if (!$job instanceof EmployeeWasaJobExperience) {

                                $job = new EmployeeWasaJobExperience();
                                $job->employee_id = $employee->id;
                                $job->order_date = '2019-08-01';
                                $job->joining_date = '2019-10-01';
                                $job->created_by = Auth::user()->id;
                            } else {
                                $job->updated_by = Auth::user()->id;
                            }
                            $job->pfno = $employee->pfno;
                            $job->designation_id = $employee->designation_id;
                            $job->scale_id = $employee->scale_id;
                            $job->scale_year = 2015;
                            $job->designation_status = $employee->designation_status;
                            $job->grade = $employee->grade;
                            $job->office_id = $employee->office_id;
                            $job->basic_pay = $employee->current_basic_pay;
                            $job->save();
                        }

                        $employeePayrollSettings = Payroll::where('employee_id', $employee->id)->first();

                        if (is_null($employeePayrollSettings)) {
                            $employeePayrollSettings = new Payroll();
                            $employeePayrollSettings->employee_id = $employee->id;
                            $employeePayrollSettings->pfno = $employee->pfno;
                        }
                        $employeePayrollSettings->designation = $employee->designation_id;
                        $employeePayrollSettings->designation_ranking = $employee->designation_ranking;
                        $employeePayrollSettings->office_id = $employee->office_id;
                        $employeePayrollSettings->grade = $employee->grade;
                        $employeePayrollSettings->scale_id = $employee->scale_id;
                        $employeePayrollSettings->bank_id = $employee->bank_name;
                        $employeePayrollSettings->branch_id = $employee->branch_name;
                        $employeePayrollSettings->basic_pay = (trim($cel->basicpay) > 0) ? trim($cel->basicpay) : 0;
                        $employeePayrollSettings->tech_pay = (trim($cel->technicalpay) > 0) ? trim($cel->technicalpay) : 0;
                        $employeePayrollSettings->spl_pay = (trim($cel->specialpay) > 0) ? trim($cel->specialpay) : 0;
                        $employeePayrollSettings->house_alw = (trim($cel->houseallowance) > 0) ? trim($cel->houseallowance) : 0;
                        $employeePayrollSettings->med_alw = (trim($cel->medicalallowance) > 0) ? trim($cel->medicalallowance): 0;
                        $employeePayrollSettings->f_bonus = (trim($cel->festivalbonus) > 0) ? trim($cel->festivalbonus): 0;
                        $employeePayrollSettings->conv_alw = (trim($cel->conveyance) > 0) ? trim($cel->conveyance): 0;
                        $employeePayrollSettings->wash_alw = (trim($cel->washallowance) > 0) ? trim($cel->washallowance) : 0;
                        $employeePayrollSettings->chrg_alw = (trim($cel->chargeallowance) > 0) ? trim($cel->chargeallowance) : 0;
                        $employeePayrollSettings->gas_alw = (trim($cel->gasallowance) > 0) ? trim($cel->gasallowance) : 0;
                        $employeePayrollSettings->ws_alw = (trim($cel->watersewerageallowance) > 0) ? trim($cel->watersewerageallowance) : 0;
                        $employeePayrollSettings->per_pay = (trim($cel->personalpay) > 0) ? trim($cel->personalpay) : 0;
                        $employeePayrollSettings->dearness = (trim($cel->dearnessallowance) > 0) ? trim($cel->dearnessallowance) : 0;
                        $employeePayrollSettings->tiffin_alw = (trim($cel->tiffinallowance) > 0) ? trim($cel->tiffinallowance) : 0;
                        $employeePayrollSettings->edu_alw = (trim($cel->educationallowance) > 0) ? trim($cel->educationallowance) : 0;
                        $employeePayrollSettings->pf_refund = (trim($cel->pfrefund) > 0) ? trim($cel->pfrefund) : 0;
                        $employeePayrollSettings->hb_refund = (trim($cel->hbrefund) > 0) ? trim($cel->hbrefund) : 0;
                        $employeePayrollSettings->vhl_refund = (trim($cel->vehiclerefund) > 0) ? trim($cel->vehiclerefund) : 0;
                        $employeePayrollSettings->salary_arr = (trim($cel->salaryarrear) > 0) ? trim($cel->salaryarrear): 0;
                        $employeePayrollSettings->hr_arr = (trim($cel->hrarrear) > 0) ? trim($cel->hrarrear): 0;
                        $employeePayrollSettings->vhl_alw = (trim($cel->deputationallowance) > 0) ? trim($cel->deputationallowance) : 0;
                        $employeePayrollSettings->other_alw = (trim($cel->otherallowance) > 0) ? trim($cel->otherallowance): 0;
                        $employeePayrollSettings->prv_fund = (trim($cel->providantfund) > 0) ? trim($cel->providantfund): 0;
                        $employeePayrollSettings->pf_loan =(trim($cel->pfloanadvance) > 0) ? trim($cel->pfloanadvance) : 0 ;
                        $employeePayrollSettings->pf_inttr =(trim($cel->pfinterest) > 0) ? trim($cel->pfinterest) : 0 ;
                        $employeePayrollSettings->hr_main =(trim($cel->hrmaintenancecharge) > 0) ? trim($cel->hrmaintenancecharge) : 0 ;
                        $employeePayrollSettings->hb_loan =(trim($cel->hbdeduction) > 0) ? trim($cel->hbdeduction) : 0 ;
                        $employeePayrollSettings->h_rent = (trim($cel->houserentdeduction) > 0) ? trim($cel->houserentdeduction) : 0;
                        $employeePayrollSettings->welfare = (trim($cel->welfare) > 0) ? trim($cel->welfare) : 0;
                        $employeePayrollSettings->trusty_fund = (trim($cel->trustyfund) > 0) ? trim($cel->trustyfund) : 0;
                        $employeePayrollSettings->ben_fund = (trim($cel->benuvulentfund) > 0) ? trim($cel->benuvulentfund) : 0;
                        $employeePayrollSettings->gr_insu = (trim($cel->groupinsurance) > 0) ? trim($cel->groupinsurance) : 0;
                        $employeePayrollSettings->elec_bill = (trim($cel->electricbill) > 0) ? trim($cel->electricbill) : 0;
                        $employeePayrollSettings->pc_inttr =  0;
                        $employeePayrollSettings->pc_loan = (trim( $cel->computerloan) > 0) ? trim( $cel->computerloan) : 0;
                        $employeePayrollSettings->ws_ded = (trim($cel->waterandseweragededuction) > 0) ? trim($cel->waterandseweragededuction) : 0;
                        $employeePayrollSettings->titas_gas = (trim($cel->titasgas) > 0) ? trim($cel->titasgas) : 0;
                        $employeePayrollSettings->water_gov = (trim($cel->watergov) > 0) ? trim($cel->watergov) : 0;
                        $employeePayrollSettings->transport = (trim($cel->transportcharge) > 0 ) ? trim($cel->transportcharge) : 0;
                        $employeePayrollSettings->pf_refund_ded = (trim($cel->pfrefunddeduction) > 0) ? trim($cel->pfrefunddeduction) : 0;
                        $employeePayrollSettings->vhcl_loan = (trim($cel->carloan) > 0) ? trim($cel->carloan) : 0;
                        $employeePayrollSettings->vhcl_inttr = (trim($cel->vehicleinterest) > 0) ? trim($cel->vehicleinterest) : 0;
                        $employeePayrollSettings->hb_inttr = (trim($cel->hbinterest) > 0) ? trim($cel->hbinterest) : 0;
                        $employeePayrollSettings->it_ded = (trim($cel->itdeduct) > 0) ? trim($cel->itdeduct) : 0;
                        $employeePayrollSettings->it_arrear_ded = (trim($cel->itarreardeduct) > 0) ? trim($cel->itarreardeduct) : 0;
                        $employeePayrollSettings->dps_fee = (trim($cel->dpsfee) > 0) ? trim($cel->dpsfee) : 0;
                        $employeePayrollSettings->union_sub = (trim($cel->unionsub) > 0) ? trim($cel->unionsub) : 0;
                        $employeePayrollSettings->deas_fee = (trim($cel->deasfee) > 0) ? trim($cel->deasfee) : 0;
                        $employeePayrollSettings->dhak_usf = (trim($cel->dhakusfee) > 0) ? trim($cel->dhakusfee) : 0;
                        $employeePayrollSettings->sal_ded = (trim( $cel->salarydeduction) > 0) ? trim( $cel->salarydeduction) : 0;
                        $employeePayrollSettings->other_ded = (trim( $cel->othersdeduction) > 0) ? trim( $cel->othersdeduction) : 0;
                        $employeePayrollSettings->day_sal = (trim( $cel->onedaysalarydeduction) > 0) ? trim( $cel->onedaysalarydeduction) : 0;
                        $employeePayrollSettings->rev_stamp = (trim( $cel->revenuestamp) > 0) ? trim( $cel->revenuestamp) : 0;
                        $employeePayrollSettings->updated_at = \Carbon\Carbon::now();
                        $employeePayrollSettings->save();

                    }
                }


            });
            DB::commit();
            echo '<br>Complete';
            dd("Done");
        } catch (\Exception $ex) {
            DB::rollback();
            dd($ex);
        }
    }
    public function payrollCheck() {

        set_time_limit(900);
        ini_set('max_execution_time', 1000);
        ini_set('memory_limit', '-1');
//        $address = public_path('doc/Payroll20190829.xls');
        $address = public_path('doc/september/Salarysheet_September2019.xlsx');
//        $address = public_path('doc/september/HRM_EMP_NAME_September.xlsx');
        try {
            DB::beginTransaction();
            $i= 0;
            $employeePayrollSettings = PayrollEmployee::where('month_id',3)->get();
//            dd($employeePayrollSettings);
            foreach ($employeePayrollSettings as $payrollSetting){
                $ep = Payroll::where('employee_id',$payrollSetting->employee_id)->first();
                if ($ep->office_id != $payrollSetting->office_id){
                    $i++;
                    $payrollSetting->office_id = $ep->office_id;
                    $payrollSetting->save();
                    echo "<br/>" . trim($payrollSetting->pfno) .'p employee -'.$ep->office_id.' payroll' .$payrollSetting->office_id;
                }{

                }
            }
//            echo '<br>'.$i;
//            Excel::load($address, function($reader) {
//                $results = $reader->get();
////                dd($results);
//$i= 0;
//                foreach ($results as $cel) {
//                    $d = Department::where('department_name', trim($cel->department_name))->where('department_group_id', 2)->first();
//                    if ($d != null){
//                        $i++;
//                    }
////                    $employee = Employee::where('pfno', trim($cel->pfno))->first();
////                    dd($cel);
////                    if (is_null($employee)) {
//////                        echo "<br/>" . trim($cel->pfno);
////                    }
////                    else {
////                            $employeePayrollSettings = Payroll::where('pfno', $employee->pfno)->first();
//////                            $d = Department::where('department_name', trim($cel->dept_id))->first();
////                            $d = Department::where('department_name', trim($cel->department_name))->where('department_group_id', 1)->first();
////                            if ($d != null && $employee->office_id != $d->id) {
////                                $i++;
//////                        dd($d->id , $employeePayrollSettings->office_id);
////
////                            echo "<br/>" . trim($cel->pfno) .' employee -'.$employee->office_id.' dp -'.$d->id .'g-'.$d->department_group_id.'payroll' .$employeePayrollSettings->office_id.' old id wasa -'.$cel->dept_id. ' old id ' .$d->old_id;
////                            }
////
////
////
////                    }
//                }
//                echo "<br/>total -" . $i;
//
//            });
            DB::commit();
            echo '<br>Complete';
            dd("Done");
        } catch (\Exception $ex) {
            DB::rollback();
            dd($ex);
        }
    }

    public function freedomFighterOff(){
        exit('ok');
        set_time_limit(900);
        ini_set('max_execution_time', 1000);
        ini_set('memory_limit', '-1');
        try {
            DB::beginTransaction();
//            $data = \Illuminate\Support\Facades\DB::select(DB::raw("SELECT e.id, e.pfno
//                , e.date_of_birth , e.freedom_fighter , e.expected_prl_date, e.expected_pension_date
//                FROM employees e
//                WHERE (e.status='PRL' or e.status='OSD' or e.status='Continue' or e.status='Suspended' or e.status='Lien')
//                AND e.date_of_birth !=''
//                AND e.deleted_at is null
//                "));
//            dd($data);
//            $data = Employee::select('id','pfno','date_of_birth' , 'freedom_fighter' , 'expected_prl_date','expected_pension_date')
//                ->whereIn('status',['PRL','OSD','Continue','Suspended','Lien'])
////                ->where('date_of_birth' ,'!=',null)
//                ->get();
            $data = Employee::whereIn('status',['PRL','OSD','Continue','Suspended','Lien'])
                ->where('date_of_birth' ,'!=',null)
                ->get();

            foreach ($data as $item){
                $prlAndPension = getPrlDate($item->date_of_birth, 'General');
                $item->expected_prl_date        = $prlAndPension['prl_year'];
                $item->expected_pension_date    = $prlAndPension['pension_year'];
                $item->freedom_fighter          = null;
                $item->save();
                $incomeTax = $this->incomeTax($item);
                $payroll    = Payroll::where('pfno',$item->pfno)->first();
                $emPay      = EmployeePayrollSetting::where('pfno',$item->pfno)->first();
                if($payroll){
                    $payroll->it_ded = $incomeTax;
                    $payroll->save();
                }
                if($emPay){
                    $emPay->it_ded = $incomeTax;
                    $emPay->save();
                }
            }
            DB::commit();
            dd("Done");
        } catch (\Exception $ex) {
            DB::rollback();
            dd($ex);
        }
    }

}
