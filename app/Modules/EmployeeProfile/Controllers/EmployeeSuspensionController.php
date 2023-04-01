<?php

namespace App\Modules\EmployeeProfile\Controllers;

use App\EmployeeProfile\Model\Employee;
use App\EmployeeProfile\Model\EmployeeSuspension;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Auth;
class EmployeeSuspensionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Auth::user()->can('manage_suspension')){
            abort(403);
        }
        $this->validate($request, [
            "employee_id" => "required|integer",
//            "office_order_no" => "required|string",
//            "type" => "required|string",
//            "order_date" => "required|date",
//            "clause" => "required|string",
        ]);
        $employee = Employee::findOrFail($request->employee_id);
        $suspension = new EmployeeSuspension();
        $suspension->employee_id = $employee->id;
        $suspension->office_order_no = $request->office_order_no;
        $suspension->type = $request->type;
        $suspension->order_date = changeDateFormatToDb($request->order_date);
        $suspension->clause = $request->clause;
        try{
            DB::beginTransaction();
            $suspension->save();
            DB::commit();
            return redirect()->route('employee-profile.show',[$employee->id,'#suspension'])->with('success',"Employee suspension information added successfully.");
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
        if(!Auth::user()->can('manage_suspension')){
            abort(403);
        }
        $this->validate($request, [
            "employee_id" => "required|integer",
//            "office_order_no" => "required|string",
//            "type" => "required|string",
//            "order_date" => "required|date",
//            "clause" => "required|string",
        ]);
        $suspension = EmployeeSuspension::findOrFail($request->suspension_id);;
        $suspension->office_order_no = $request->office_order_no;
        $suspension->type = $request->type;
        $suspension->order_date = changeDateFormatToDb($request->order_date);
        $suspension->clause = $request->clause;
        try{
            DB::beginTransaction();
            $suspension->save();
            DB::commit();
            return redirect()->route('employee-profile.show',[$request->employee_id,'#suspension'])->with('success',"Employee suspension information updated successfully.");
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
}
