<?php

namespace App\Modules\EmployeeProfile\Controllers;

use App\EmployeeProfile\Model\Employee;
use App\EmployeeProfile\Model\EmployeeMembership;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Auth;
class EmployeeMembershipController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Auth::user()->can('manage_membership')){
            abort(403);
        }
        //$membership_organization = get_membership_organization();
        $this->validate($request, [
            "employee_id" => "required|integer",
//            "membership_organization_id" => "required|array",
        ]);
        $employee = Employee::findOrFail($request->employee_id);
        $i = 0;
        $insert_data = [];
        EmployeeMembership::where('employee_id',$request->employee_id)->delete();
        foreach($request->membership_organization_id as $membership_organization_id){
            $insert_data[$i]['employee_id'] = $employee->id;
            $insert_data[$i]['membership_organization_id'] = $membership_organization_id;
            $insert_data[$i]['is_exist'] = 1;
            if($request->has('membership_no_'.$membership_organization_id)){
                $insert_data[$i]['membership_no'] = $request->input("membership_no_".$membership_organization_id);
            }
            else{
                $insert_data[$i]['membership_no'] = null;
            }
            $insert_data[$i]['membership_organization_id'] = $membership_organization_id;
            $i++;
        }
        if(!count($insert_data) > 0){
            return redirect()->back()->withInput()->with('msessage','Nothing to insert, please input data first.');
        }
        try{
            DB::beginTransaction();
            EmployeeMembership::insert($insert_data);
            DB::commit();
            return redirect()->route('employee-profile.show',[$request->employee_id,'#membership'])->with('success',"Employee Membership information saved successfully.");
        } catch (Exception $ex) {
            DB::rollback();
            \Log::error($ex);
            return redirect()->back()->withErrors("Whoops!! Something went wrong. Please try again.");
        }
    }


    /**
     * Remove the specified resource from storage.
     * @return \Illuminate\Http\Response
     * @internal param \App\EmployeeMembership $employeeMembership
     */
    public function destroy()
    {
        //
    }
}
