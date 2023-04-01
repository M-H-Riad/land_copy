<?php

namespace App\Modules\EmployeeProfile\Controllers;

use App\EmployeeProfile\Model\Employee;
use App\EmployeeProfile\Model\EmployeeTraining;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Auth;
class EmployeeTrainingController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Auth::user()->can('manage_training')){
            abort(403);
        }
        $this->validate($request, [
            "employee_id" => "required|integer",
            "course_title" => "required|string",
//            "place" => "required|string",
//            "country" => "required",
//            "finance_by" => "required|string",
//            "amount" => "required|string",
//            "year" => "required|string",
//            "duration" => "required|string"
        ]);
        $employee = Employee::findOrFail($request->employee_id);
        $training = new EmployeeTraining();
        $training->employee_id = $employee->id;
        $training->training_type = $request->training_type;
        $training->course_title = $request->course_title;
        $training->place = $request->place;
        $training->country = $request->country;
        $training->institution = $request->institution;
        $training->finance_by = $request->finance_by;
        $training->amount = $request->amount;
        $training->year = $request->year;
        $training->duration = $request->duration;
        try{
            if($training->save()) {
                return redirect()->route('employee-profile.show', [$request->employee_id,'#training'])->with('success', "Employee training information added successfully.");
            }else{
                return redirect()->back()->withErrors("Whoops!! Something went wrong. Please try again.");
            }
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
     * @internal param \App\EmployeeTraining $employeeTraining
     */
    public function update(Request $request)
    {
        if(!Auth::user()->can('manage_training')){
            abort(403);
        }
        $this->validate($request, [
            "employee_id" => "required|integer",
            "course_title" => "required|string",
//            "place" => "required|string",
//            "country" => "required",
//            "finance_by" => "required|string",
//            "amount" => "required|string",
//            "year" => "required|string",
//            "duration" => "required|string"
        ]);
        $training = EmployeeTraining::findOrFail($request->training_id);
        $training->training_type = $request->training_type;
        $training->course_title = $request->course_title;
        $training->place = $request->place;
        $training->country = $request->country;
        $training->institution = $request->institution;
        $training->finance_by = $request->finance_by;
        $training->amount = $request->amount;
        $training->year = $request->year;
        $training->duration = $request->duration;
        try{
            if($training->save()) {
                return redirect()->route('employee-profile.show', [$request->employee_id,'#training'])->with('success', "Employee training information added successfully.");
            }else{
                return redirect()->back()->withErrors("Whoops!! Something went wrong. Please try again.");
            }
        } catch (\Exception $ex) {
            \Log::error($ex);
            return redirect()->back()->withErrors("Whoops!! Something went wrong. Please try again.");
        }
    }
//
//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param  \App\EmployeeTraining  $employeeTraining
//     * @return \Illuminate\Http\Response
//     */
//    public function destroy(EmployeeTraining $employeeTraining)
//    {
//        //
//    }
    
    
    /**
     * Remove the specified resource from storage.
     * @return \Illuminate\Http\Response
     * @internal param ServiceExperience $serviceExperience
     */
    public function destroy($id) {
        if (!Auth::user()->can('delete_training')) {
            abort(403);
        }
        $data = EmployeeTraining::find($id);
        $data->delete();
        $data->deleted_by = Auth()->user()->id;
        $data->update();

        return redirect()->back()->with('success', 'Data Successfully Deleted');
    }

}
