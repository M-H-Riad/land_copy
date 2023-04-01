<?php

namespace App\Modules\EmployeeProfile\Controllers;

use App\EmployeeProfile\Model\Employee;
use App\EmployeeProfile\Model\PensionBankAccount;
use App\EmployeeProfile\Model\PensionJob;
use App\Modules\EmployeeProfile\Models\PensionRelative;
use App\Modules\Pension\Models\PensionEmployee;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\EmployeeProfile\Model\PensionFundEmp;

class PensionEmployeeController extends EmployeeProfileController {

    public function createEmployee(Request $request) {
        if (!Auth::user()->can('manage_pension_employee')) {
           \App\Library\AuditTrailLib::addTrail('Pension',Auth::user()->user_name,'Create employee - not permitted','Invalid Action');
           abort(403);
       }

       $data['serach'] = false;
       if ($request->has('national_id_s') || $request->has('pfno_s')) {
        if (!is_null($request->national_id_s)) {
            $employee = Employee::select('id')->where('nid', $request->national_id_s)->first();
        } elseif (!is_null($request->pfno_s)) {
            $employee = Employee::select('id')->where('pfno', $request->pfno_s)->first();
        } elseif(!is_null($request->ppo_no_s)) {
            $employee = PensionFundEmp::select('employee_id as id')->where('ppo_no',$request->ppo_no_s)->first();
        }

        if ($employee) {
            \App\Library\AuditTrailLib::addTrail('Pension',Auth::user()->user_name,'Create employee - employee information found. Requests :  '.json_encode($request->all()),'Success');
            return redirect('employee-profile/' . $employee->id . '/edit');
        }
        else{
            \App\Library\AuditTrailLib::addTrail('Pension',Auth::user()->user_name,'Create employee - need to create new.','Success');
        }

        $data['serach'] = true;
    }


    $data['title'] = "Create Pension Employee";
    $data['designation'] = get_designation();
    $data['office_zone'] = get_office_zone();
    $data['scale'] = get_scale_new();
    $data['bank'] = get_bank_list();
    $data['designationStatus'] = getDesignationStatus();
    $data['religion'] = get_religion_array();

    return view('EmployeeProfile::create-pension-employee', $data);
}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeEmployee(Request $request) {
        if (!Auth::user()->can('manage_pension_employee')) {
            \App\Library\AuditTrailLib::addTrail('Pension',Auth::user()->user_name,'Create employee Submit - not permitted.','Invalid Action');
            abort(403);
        }


        $this->validate($request, [
            "employee_first_name" => "required|string",
            "national_id" => "required|numeric|unique:employees,nid",
            "date_of_birth" => "required|date_format:d/m/Y"
//            "employee_id" => "required|integer",
//            "children_name" => "required|string",
//            "sex" => "required|string",
//            "children_date_of_birth" => "required|date",
//            "profession" => "required|string",
        ]);
        $data = array(
            "employee_id" => $this->__makeEmployeeId($request),
            "first_name" => $request->employee_first_name,
            "middle_name" => $request->employee_middle_name,
            "last_name" => $request->employee_last_name,
            "date_of_birth" => changeDateFormatToDb($request->date_of_birth),
            "nid" => $request->national_id,
            "religion" => $request->religion,
            "status" => 'New',
        );

        try {
            DB::beginTransaction();
            $employee = Employee::create($data);

            /*
             * History Table for Employee Main table
             */
            $pension_employee = PensionEmployee::create(['employee_table_id' => $employee->id, 'created_by' => Auth::user()->id] + $data);

            $data = [
                'employee_id' => $employee->id,
                "office_order_no" => $request->office_order_no,
                'order_date' => changeDateFormatToDb($request->office_order_date),
                "retirement_date" => changeDateFormatToDb($request->retirement_date),
                'designation_id' => $request->designation,
                'designation_status' => $request->designation_status,
                "office_id" => $request->office_zone,
                "scale_id" => $request->scale,
                "basic_pay" => preg_replace('/[^0-9.]/', '', $request->basic_pay),
                'created_by' => auth()->user()->id
            ];

            PensionJob::create($data);

            if ($request->name) {
                $data = new PensionRelative();
                $data->employee_id = $employee->id;
                $data->name = $request->name;
                $data->relation = $request->relation;
                $data->phone_no = $request->phone_no;
                $data->save();
            }
            if ($request->name2) {
                $data = new PensionRelative();
                $data->employee_id = $employee->id;
                $data->name = $request->name2;
                $data->relation = $request->relation2;
                $data->phone_no = $request->phone_no2;
                $data->save();
            }

            if ($request->bank_id) {
                $pension_bank_account = new PensionBankAccount();
                $pension_bank_account->employee_id = $employee->id;
                $pension_bank_account->bank_id = $request->bank_id;
                $pension_bank_account->branch_id = $request->branch_id;
                $pension_bank_account->account_no = $request->account_no;
                $pension_bank_account->account_no_old = $request->account_no_old;
                $pension_bank_account->account_holder_name = $request->account_holder_name;
                $pension_bank_account->type = $request->type;
                $pension_bank_account->save();
            }

            DB::commit();
            \App\Library\AuditTrailLib::addTrail('Pension',Auth::user()->user_name,'Create employee Submit - employee created successfully.','Success');
            return redirect()->route('employee-profile.show', [$employee->id],'type=pension')->with('success', "Employee information added successfully.");
        } catch (\Exception $ex) {
            DB::rollback();
            \Log::error($ex);
            \App\Library\AuditTrailLib::addTrail('Pension',Auth::user()->user_name,'Create employee Submit - Request : '.json_encode($request->all()).' |  Message - '.$ex->getMessage(),'Error');
            return redirect()->back()->withErrors("Whoops!! Something went wrong. Please try again.");
        }
    }

}
