<?php

namespace App\Modules\EmployeeProfile\Controllers;

use App\EmployeeProfile\Model\Employee;
use App\EmployeeProfile\Model\EmployeeChildren;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Auth;
class EmployeeChildrenController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Auth::user()->can('manage_children')){
            abort(403);
        }
        $this->validate($request, [
            "employee_id" => "required|integer",
//            "children_name" => "required|string",
//            "sex" => "required|string",
//            "children_date_of_birth" => "required|date",
//            "profession" => "required|string",
        ]);
//        $employee = Employee::findOrFail($request->employee_id);
        
        $children = new EmployeeChildren();
        $children->employee_id = $request->employee_id;
        $children->children_name = $request->children_name;
        $children->sex = $request->sex;
        $children->date_of_birth = changeDateFormatToDb($request->children_date_of_birth);
        $children->profession = $request->profession;
        $children->edu_alw = $request->edu_alw;
        $children->created_by = Auth()->user()->id;
        try{
            DB::beginTransaction();
            $children->save();
            DB::commit();
            return redirect()->route('employee-profile.show',[$request->employee_id,'#children'])->with('success',"Employee children information added successfully.");
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
     * @internal param \App\EmployeeChildren|EmployeeChildren $employeeChildren
     */
    public function update(Request $request)
    {
        if(!Auth::user()->can('manage_children')){
            abort(403);
        }
        $this->validate($request, [
            "employee_id" => "required|integer",
//            "children_id" => "required|integer",
//            "children_name" => "required|string",
//            "sex" => "required|string",
//            "children_date_of_birth" => "required|date",
//            "profession" => "required|string",
        ]);
        $children = EmployeeChildren::findOrFail($request->children_id);
        $children->children_name = $request->children_name;
        $children->sex = $request->sex;
        $children->date_of_birth = changeDateFormatToDb($request->children_date_of_birth);
        $children->profession = $request->profession;
        $children->edu_alw = $request->edu_alw;
        try{
            DB::beginTransaction();
            $children->save();
            DB::commit();
            return redirect()->route('employee-profile.show',[$request->employee_id,'#children'])->with('success',"Employee children information update successfully.");
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
    public function destroy($id)
    {
        if (!Auth::user()->can('delete_children')) {
            abort(403);
        }
        $data = EmployeeChildren::find($id);
        $data->delete();
        $data->deleted_by = Auth()->user()->id;
        $data->update();
        
        return redirect()->back()->with('success','Data Successfully Deleted');
    }
}
