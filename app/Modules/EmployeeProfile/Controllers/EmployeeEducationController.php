<?php

namespace App\Modules\EmployeeProfile\Controllers;

use App\EmployeeProfile\Model\Employee;
use App\EmployeeProfile\Model\EmployeeEducation;
use App\EmployeeProfile\Model\Qualification;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Auth;

class EmployeeEducationController extends Controller {

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        if (!Auth::user()->can('manage_academic')) {
            abort(403);
        }
        $this->validate($request, [
            "employee_id" => "required|integer",
//            "qualification_id" => "required|integer|exists:qualifications,id",
//            "discipline" => "required|string",
//            "board" => "required|string",
//            "institute" => "required|string",
//            "major" => "required|string",
//            "passing_year" => "required|string",
//            "grade" => "required|string"
        ]);

        $board = (is_null($request->board)) ? $request->versity : $request->board;

        $employee = Employee::findOrFail($request->employee_id);
        $qualification = new EmployeeEducation();
        $qualification->employee_id = $employee->id;
        $qualification->qualification_id = $request->qualification_id;
        $qualification->discipline = $request->discipline;
        $qualification->board = $board;
        $qualification->institute = $request->institute;
        $qualification->major = $request->major;
        $qualification->passing_year = $request->passing_year;
        $qualification->grade = $request->grade;
        try {
            DB::beginTransaction();
            $qualification->save();
            DB::commit();
            return redirect()->route('employee-profile.show', [$request->employee_id, '#academic'])->with('success', "Employee education information added successfully.");
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
     * @internal param \App\EmployeeEducation $employeeEducation
     */
    public function update(Request $request) {
        if (!Auth::user()->can('manage_academic')) {
            abort(403);
        }
        $this->validate($request, [
            "employee_id" => "required|integer",
//            "qualification_id" => "required|integer|exists:qualifications,id",
//            "discipline" => "required|string",
//            "board" => "required|string",
//            "institute" => "required|string",
//            "major" => "required|string",
//            "passing_year" => "required|string",
//            "grade" => "required|string"
        ]);
        $board = (is_null($request->board)) ? $request->versity : $request->board;
        $qualification = EmployeeEducation::findOrFail($request->education_id);
        $qualification->qualification_id = $request->qualification_id;
        $qualification->discipline = $request->discipline;
        $qualification->board = $board;
        $qualification->institute = $request->institute;
        $qualification->major = $request->major;
        $qualification->passing_year = $request->passing_year;
        $qualification->grade = $request->grade;
        try {
            DB::beginTransaction();
            $qualification->save();
            DB::commit();
            return redirect()->route('employee-profile.show', [$request->employee_id, '#academic'])->with('success', "Employee education information added successfully.");
        } catch (\Exception $ex) {
            DB::rollback();
            \Log::error($ex);
            return redirect()->back()->withErrors("Whoops!! Something went wrong. Please try again.");
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return \Illuminate\Http\Response
     * @internal param \App\EmployeeChildren|EmployeeChildren $employeeChildren
     */
    public function destroy($id) {
        if (!Auth::user()->can('delete_academic')) {
            abort(403);
        }
        $data = EmployeeEducation::find($id);
        $data->delete();
        $data->deleted_by = Auth()->user()->id;
        $data->update();

        return redirect()->back()->with('success', 'Data Successfully Deleted');
    }

}
