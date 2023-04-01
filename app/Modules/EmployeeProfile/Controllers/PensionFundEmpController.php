<?php

namespace App\Modules\EmployeeProfile\Controllers;

use App\EmployeeProfile\Model\Employee;
use App\EmployeeProfile\Model\PensionType;
use App\EmployeeProfile\Model\PensionFundEmp;
use App\EmployeeProfile\Model\PensionBankAccount;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Validation\Rule;

class PensionFundEmpController extends Controller
{

    public function index()
    {
        return redirect('/home');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        if (!Auth::user()->can('manage_pension_fund_emp')) {
            \App\Library\AuditTrailLib::addTrail('Pension', Auth::user()->user_name, 'Store Fund information', 'Invalid Action');
            abort(403);
        }
        $this->validate($request, [
            "employee_id" => "required|integer",
//            "ppo_no" => "required|string|unique:pension_fund_emp,ppo_no",
            "ppo_no" => [
                "required",
                "string",
                Rule::unique('pension_fund_emp')->where(function ($query) {
                    return $query->where('deleted_at', '=', null);
                })
            ],
            "pension_type_id" => "required|integer|exists:pension_type,id",
            "pension_holder_name" => "required|string",
//            "mobile_no" => "required|string|max:11|min:11",
            "present_address" => "string",
            "permanent_address" => "string",
            "pension_holder_type" => "required|string|in:Self,Family",
//            "opening_net_pension" => "numeric",
            "current_net_pension" => "required|numeric",
            "medical_allowance" => "sometimes|numeric",
            "new_year_allowance" => "sometimes|numeric",
            "festival_allowance" => "sometimes|numeric"
        ]);

        if ($request->pension_type_id == 1 or $request->pension_type_id == 2) {
            $expire_date = date('Y') . '-12-31';
        } elseif ($request->pension_type_id == 3) {
            $expire_date = date('Y') . '-06-30';
        } else {
            $expire_date = null;
        }
        $employee = Employee::findOrFail($request->employee_id);
        $pension_fund = new PensionFundEmp();
        $pension_fund->employee_id = $employee->id;
        $pension_fund->ppo_no = $request->ppo_no;
        $pension_fund->pension_type_id = $request->pension_type_id;
        $pension_fund->pension_holder_name = $request->pension_holder_name;
        $pension_fund->mobile_no = $request->mobile_no;
        $pension_fund->present_address = $request->present_address;
        $pension_fund->permanent_address = $request->permanent_address;
        $pension_fund->pension_holder_type = $request->pension_holder_type;
        $pension_fund->opening_net_pension = $request->opening_net_pension;
        $pension_fund->current_net_pension = $request->current_net_pension;
        $pension_fund->medical_allowance = $request->medical_allowance;
        $pension_fund->new_year_allowance = $request->new_year_allowance;
        $pension_fund->festival_allowance = $request->festival_allowance;
        $pension_fund->previous_date = changeDateFormatToDb($request->previous_date);
        $pension_fund->expire_date = $expire_date;
        $pension_fund->created_by = Auth()->user()->id;
        try {
            DB::beginTransaction();
            $pension_fund->save();
            DB::commit();
            \App\Library\AuditTrailLib::addTrail('Pension', Auth::user()->user_name, 'Store Fund information | Request : ' . json_encode($request->all()), 'Success');
            return redirect()->route('employee-profile.show', [$request->employee_id, 'type=pension#pension_fund_emp'])->with('success', "Employee pension fund  information added successfully.");
        } catch (\Exception $ex) {
            DB::rollback();
            \App\Library\AuditTrailLib::addTrail('Pension', Auth::user()->user_name, 'Store Fund information | Request : ' . json_encode($request->all()) . ' | Message : ' . $ex->getMessage(), 'Error');
            return redirect()->back()->withErrors("Whoops!! Something went wrong. Please try again.");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @internal param \App\PensionBankAccount|PensionBankAccount $employeeChildren
     */
    public function update(Request $request)
    {
        if (!Auth::user()->can('manage_pension_fund_emp')) {
            \App\Library\AuditTrailLib::addTrail('Pension', Auth::user()->user_name, 'Update order information', 'Invalid Action');
            abort(403);
        }
        $this->validate($request, [
            "employee_id" => "required|integer",
//        "ppo_no" => "required|string|unique:pension_fund_emp,ppo_no,".$request->pension_fund_emp_id.",id,deleted_at,NULL",
            "ppo_no" => [
                "required",
                "string",
                Rule::unique('pension_fund_emp')->where(function ($query) {
                    return $query->where('deleted_at', '=', null);
                })->ignore($request->pension_fund_emp_id)
            ],
            "pension_type_id" => "required|integer|exists:pension_type,id",
            "pension_holder_name" => "required|string",
//          "mobile_no" => "string|max:11|min:11",
            "pension_holder_type" => "required|string|in:Self,Family",
//          "opening_net_pension" => "numeric",
            "current_net_pension" => "required|numeric",
            "medical_allowance" => "sometimes|numeric",
            "new_year_allowance" => "sometimes|numeric",
            "festival_allowance" => "sometimes|numeric",
        ]);
        $employee = Employee::findOrFail($request->employee_id);
        $pension_fund = PensionFundEmp::findOrFail($request->pension_fund_emp_id);
        $pension_fund->employee_id = $employee->id;
        $pension_fund->ppo_no = $request->ppo_no;
        $pension_fund->pension_type_id = $request->pension_type_id;
        $pension_fund->pension_holder_name = $request->pension_holder_name;
        $pension_fund->mobile_no = $request->mobile_no;
        $pension_fund->present_address = $request->present_address;
        $pension_fund->permanent_address = $request->permanent_address;
        $pension_fund->pension_holder_type = $request->pension_holder_type;
        $pension_fund->opening_net_pension = $request->opening_net_pension;
        $pension_fund->current_net_pension = $request->current_net_pension;
        $pension_fund->medical_allowance = $request->medical_allowance;
        $pension_fund->new_year_allowance = $request->new_year_allowance;
        $pension_fund->festival_allowance = $request->festival_allowance;
        $pension_fund->previous_date = changeDateFormatToDb($request->previous_date);
        $pension_fund->expire_date = changeDateFormatToDb($request->expire_date);
        $pension_fund->updated_by = Auth()->user()->id;
        try {
            DB::beginTransaction();
            $pension_fund->save();
            DB::commit();
            \App\Library\AuditTrailLib::addTrail('Pension', Auth::user()->user_name, 'Update Fund information | Request : ' . json_encode($request->all()), 'Success');
            return redirect()->route('employee-profile.show', [$request->employee_id, 'type=pension#pension_bank_account'])->with('success', "Employee Pension Fund information update successfully.");
        } catch (\Exception $ex) {
            DB::rollback();
            \App\Library\AuditTrailLib::addTrail('Pension', Auth::user()->user_name, 'Update Fund information | Request : ' . json_encode($request->all()) . ' | Message : ' . $ex->getMessage(), 'Error');
            return redirect()->back()->withErrors("Whoops!! Something went wrong. Please try again.");
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return \Illuminate\Http\Response
     * @internal param \App\PensionBankAccount|PensionBankAccount $employeeChildren
     */
    public function destroy($id)
    {
        if (!Auth::user()->can('delete_pension_fund')) {
            \App\Library\AuditTrailLib::addTrail('Pension', Auth::user()->user_name, 'Delete Fund information', 'Invalid Action');
            abort(403);
        }
        $data = PensionFundEmp::find($id);
        $data->delete();
        $data->deleted_by = Auth()->user()->id;
        $data->update();
        \App\Library\AuditTrailLib::addTrail('Pension', Auth::user()->user_name, 'Delete Fund information. id : ' . $id, 'Success');
        return redirect()->back()->with('message', 'Data Successfully Deleted');
    }
}
