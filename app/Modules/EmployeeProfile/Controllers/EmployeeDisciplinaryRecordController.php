<?php

namespace App\Modules\EmployeeProfile\Controllers;

use App\EmployeeProfile\Model\Employee;
use App\EmployeeProfile\Model\EmployeeDesciplinaryRecord;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Auth;
class EmployeeDisciplinaryRecordController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Auth::user()->can('manage_disciplinary_records')){
            abort(403);
        }
        $this->validate($request, [
            "employee_id" => "required|integer",
            "ref_no" => "required",
            "ref_date" => "required",
            "case_no" => "required",
            "allegation" => "required|string",
        ]);
        $employee = Employee::findOrFail($request->employee_id);
        $suspension = new EmployeeDesciplinaryRecord();
        $suspension->employee_id = $employee->id;
        $suspension->ref_no = $request->ref_no;
        $suspension->ref_date = changeDateFormatToDb($request->ref_date);
        $suspension->case_no = $request->case_no;
        $suspension->allegation = $request->allegation;
        $suspension->created_by = Auth()->user()->id;
//        $suspension->case_date = changeDateFormatToDb($request->case_date);
//        $suspension->punishment = $request->punishment;
        
        
        try{
            DB::beginTransaction();
            $suspension->save();
            DB::commit();
            return redirect()->route('employee-profile.show',[$employee->id,'#suspension'])->with('success',"Employee desciplinary record information added successfully.");
        } catch (Exception $ex) {
            DB::rollback();
            \Log::error($ex);
            return redirect()->back()->withErrors("Whoops!! Something went wrong. Please try again.");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @internal param \App\EmployeeSuspension $employeeSuspension
     */
    public function update(Request $request)
    {
        if(!Auth::user()->can('manage_disciplinary_records')){
            abort(403);
        }
       $this->validate($request, [
            "ref_no" => "required",
            "ref_date" => "required",
            "case_no" => "required",
            "allegation" => "required|string",
         
        ]);
        $suspension = EmployeeDesciplinaryRecord::findOrFail($request->suspension_id);
        $suspension->ref_no = $request->ref_no;
        $suspension->ref_date = changeDateFormatToDb($request->ref_date);
        $suspension->case_no = $request->case_no;
        $suspension->allegation = $request->allegation;
        $suspension->result_ref_no = $request->result_ref_no;
        $suspension->result_ref_date = changeDateFormatToDb($request->result_ref_date);
        $suspension->result = $request->result;
        $suspension->updated_by = Auth()->user()->id;
        try{
            DB::beginTransaction();
            $suspension->save();
            DB::commit();
            return redirect()->route('employee-profile.show',[$request->employee_id,'#suspension'])->with('success',"Employee desciplinary record information updated successfully.");
        } catch (Exception $ex) {
            DB::rollback();
            \Log::error($ex);
            return redirect()->back()->withErrors("Whoops!! Something went wrong. Please try again.");
        }
    }

//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param  \App\EmployeeSuspension  $employeeSuspension
//     * @return \Illuminate\Http\Response
//     */
//    public function destroy(EmployeeSuspension $employeeSuspension)
//    {
//        //
//    }
    
        public function destroy($id) {
        if (!Auth::user()->can('delete_disciplinary_records')) {
            abort(403);
        }
        $data = EmployeeDesciplinaryRecord::find($id);
        $data->delete();
        $data->deleted_by = Auth()->user()->id;
        $data->update();

        return redirect()->back()->with('success', 'Data Successfully Deleted');
    }
}
