<?php

namespace App\Modules\EmployeeProfile\Controllers;

use App\EmployeeProfile\Model\Employee;
use App\EmployeeProfile\Model\PensionBankAccount;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Auth;

class PensionBankAccountController extends Controller {

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //dd($request->all());
        if (!Auth::user()->can('manage_pension_bank_account')) {
            \App\Library\AuditTrailLib::addTrail('Pension',Auth::user()->user_name,'Store Bank information','Invalid Action');
            abort(403);
        }
        $this->validate($request, [
            "employee_id" => "required|integer",
//            "pension_bank_account_name" => "required|string",
//            "sex" => "required|string",
//            "pension_bank_account_date_of_birth" => "required|date",
//            "profession" => "required|string",
        ]);
        $employee = Employee::findOrFail($request->employee_id);
        $pension_bank_account = new PensionBankAccount();
        $pension_bank_account->employee_id = $employee->id;
        $pension_bank_account->bank_id = $request->bank_id;
        $pension_bank_account->branch_id = $request->branch_id;
        $pension_bank_account->account_no = $request->account_no;
        $pension_bank_account->account_no_old = $request->account_no_old;
        $pension_bank_account->account_holder_name = $request->account_holder_name;
        $pension_bank_account->created_by = Auth()->user()->id;
        try {
            DB::beginTransaction();
            $pension_bank_account->save();
            DB::commit();
            \App\Library\AuditTrailLib::addTrail('Pension',Auth::user()->user_name,'Store Bank information | Request : '.json_encode($request->all()),'Success');
            return redirect()->route('employee-profile.show', [$request->employee_id, 'type=pension#pension_bank_account'])->with('success', "Employee pension Bank account information added successfully.");
        } catch (\Exception $ex) {
            DB::rollback();
            \App\Library\AuditTrailLib::addTrail('Pension',Auth::user()->user_name,'Store Bank information | Request : '.json_encode($request->all()).' | Message : '.$ex->getMessage(),'Error');
            return redirect()->back()->withErrors("Whoops!! Something went wrong. Please try again.");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @internal param \App\PensionBankAccount|PensionBankAccount $employeeChildren
     */
    public function update(Request $request) {
        if (!Auth::user()->can('manage_pension_bank_account')) {
            \App\Library\AuditTrailLib::addTrail('Pension',Auth::user()->user_name,'Update Bank information','Invalid Action');
            abort(403);
        }
        $this->validate($request, [
            "employee_id" => "required|integer",
//            "pension_bank_account_id" => "required|integer",
//            "pension_bank_account_name" => "required|string",
//            "sex" => "required|string",
//            "pension_bank_account_date_of_birth" => "required|date",
//            "profession" => "required|string",
        ]);
        $employee = Employee::findOrFail($request->employee_id);
        $pension_bank_account = PensionBankAccount::findOrFail($request->pension_bank_account_id);
        $pension_bank_account->employee_id = $employee->id;
        $pension_bank_account->bank_id = $request->bank_id;
        $pension_bank_account->branch_id = $request->branch_id;
        $pension_bank_account->account_no = $request->account_no;
        $pension_bank_account->account_no_old = $request->account_no_old;
        $pension_bank_account->account_holder_name = $request->account_holder_name;
        $pension_bank_account->update_by = Auth()->user()->id;
        try {
            DB::beginTransaction();
            $pension_bank_account->save();
            DB::commit();
            \App\Library\AuditTrailLib::addTrail('Pension',Auth::user()->user_name,'Update Bank information | Request : '.json_encode($request->all()),'Success');
            return redirect()->route('employee-profile.show', [$request->employee_id, 'type=pension#pension_bank_account'])->with('success', "Employee Pension bank account information update successfully.");
        } catch (\Exception $ex) {
            DB::rollback();
            \App\Library\AuditTrailLib::addTrail('Pension',Auth::user()->user_name,'Update Bank information | Request : '.json_encode($request->all()).' | Message : '.$ex->getMessage(),'Error');
            return redirect()->back()->withErrors("Whoops!! Something went wrong. Please try again.");
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return \Illuminate\Http\Response
     * @internal param \App\PensionBankAccount|PensionBankAccount $employeeChildren
     */
    public function destroy($id) {
        if (!Auth::user()->can('delete_pension_bank_account')) {
            \App\Library\AuditTrailLib::addTrail('Pension',Auth::user()->user_name,'Delete Bank information','Invalid Action');
            abort(403);
        }
        $data = PensionBankAccount::find($id);
        $data->delete();
        $data->deleted_by = Auth()->user()->id;
        $data->update();
        \App\Library\AuditTrailLib::addTrail('Pension',Auth::user()->user_name,'Delete Bank information. id : '.$id,'Success');
        return redirect()->back()->with('message', 'Data Successfully Deleted');
    }

}
