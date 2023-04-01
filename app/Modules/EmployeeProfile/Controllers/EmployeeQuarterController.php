<?php

namespace App\Modules\EmployeeProfile\Controllers;

use App\EmployeeProfile\Model\Employee;
use App\EmployeeProfile\Model\EmployeeQuarter;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Auth;

class EmployeeQuarterController extends Controller {

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        if (!Auth::user()->can('manage_quarter')) {
            abort(403);
        }
        $this->validate($request, [
            "employee_id" => "required|integer",
//            "allotment_reference" => "required|string",
//            "reference_date" => "required|date",
//            "posting_date" => "required|date",
//            "location" => "required|string",
//            "road" => "required|string",
//            "building" => "required|string",
//            "flat" => "required|string",
//            "flat_type" => "required|string",
//            "size_sft" => "required|string",
        ]);
        $employee = Employee::findOrFail($request->employee_id);
        $quarter = new EmployeeQuarter();
        $quarter->employee_id = $employee->id;
        $quarter->allotment_reference = $request->allotment_reference;
        $quarter->reference_date = changeDateFormatToDb($request->reference_date);
        $quarter->posting_date = changeDateFormatToDb($request->posting_date);
        $quarter->location = $request->location;
        $quarter->road = $request->road;
        $quarter->flat = $request->flat;
        $quarter->building = $request->building;
        $quarter->flat_type = $request->flat_type;
        $quarter->size_sft = $request->size_sft;
        try {
            $quarter->save();
            return redirect()->route('employee-profile.show', [$request->employee_id, '#quarter'])->with('success', "Employee quarter information added successfully.");
        } catch (\Exception $ex) {
            \Log::error($ex);
            return redirect()->back()->withErrors("Whoops!! Something went wrong. Please try again.");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @internal param \App\EmployeeQuarter $employeeQuarter
     */
    public function update(Request $request) {
        if (!Auth::user()->can('manage_quarter')) {
            abort(403);
        }
        $this->validate($request, [
            "employee_id" => "required|integer",
//            "allotment_reference" => "required|string",
//            "reference_date" => "required|date",
//            "posting_date" => "required|date",
//            "location" => "required|string",
//            "road" => "required|string",
//            "building" => "required|string",
//            "flat" => "required|string",
//            "flat_type" => "required|string",
//            "size_sft" => "required|string",
        ]);
        $quarter = EmployeeQuarter::findOrFail($request->quarter_id);
        $quarter->allotment_reference = $request->allotment_reference;
        $quarter->reference_date = changeDateFormatToDb($request->reference_date);
        $quarter->posting_date = changeDateFormatToDb($request->posting_date);
        $quarter->location = $request->location;
        $quarter->road = $request->road;
        $quarter->flat = $request->flat;
        $quarter->building = $request->building;
        $quarter->flat_type = $request->flat_type;
        $quarter->size_sft = $request->size_sft;
        try {
            $quarter->save();
            return redirect()->route('employee-profile.show', [$request->employee_id, '#quarter'])->with('success', "Employee quarter information Updated successfully.");
        } catch (\Exception $ex) {
            \Log::error($ex);
            return redirect()->back()->withErrors("Whoops!! Something went wrong. Please try again.");
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return \Illuminate\Http\Response
     * @internal param \App\EmployeeQuarter $employeeQuarter
     */
    public function destroy($id) {
        if (!Auth::user()->can('delete_quarter')) {
            abort(403);
        }
        $data = EmployeeQuarter::find($id);
        $data->delete();
        $data->deleted_by = Auth()->user()->id;
        $data->update();

        return redirect()->back()->with('success', 'Data Successfully Deleted');
    }

}
