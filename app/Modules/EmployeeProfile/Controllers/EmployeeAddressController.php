<?php

namespace App\Http\Controllers;

namespace App\Modules\EmployeeProfile\Controllers;

use App\EmployeeProfile\Model\Employee;
use App\EmployeeProfile\Model\EmployeeAddress;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Auth;
class EmployeeAddressController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Auth::user()->can('manage_present-address')){
            abort(403);
        }
        //
        //dd($request->all());
        $this->validate($request, [
            "employee_id" => "required|integer",
//            "division_id" => "required|integer|exists:divisions,id",
//            "district_id" => "required|integer|exists:districts,id",
//            "thana_id" => "required|integer|exists:thanas,id",
//            "post_office" => "required|string",
//            "village_road" => "required|string",
//            "post_code" => "required|string",
//            "mobile" => "required|string",
//            "address_type" => "required|string|in:Present,Permanent",
        ]);
        $employee = Employee::findOrFail($request->employee_id);
        $address = new EmployeeAddress();
        $address->employee_id = $employee->id;
        $address->division_id = $request->division_id;
        $address->district_id = $request->district_id;
        //ALTER TABLE `employees`
        //ADD `present_district_id` int NULL DEFAULT '0' AFTER `email`;
        $address->thana_id = $request->thana_id;
        $address->post_office = $request->post_office;
        $address->village_road = $request->village_road;
        $address->post_code = $request->post_code;
        $address->mobile = $request->mobile;
        $address->address_type = $request->address_type;

        if($request->address_type =='Present') {
            $employee->present_district_id = $request->district_id;
            $employee->save();
        }
        try{
            DB::beginTransaction();
            $address->save();
            DB::commit();
            return redirect()->route('employee-profile.show',[$request->employee_id,'#present-address'])->with('success',"Employee address information added successfully.");
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
     * @internal param \App\EmployeeAddress|EmployeeAddress $employeeAddress
     */
    public function update(Request $request)
    {
        if(!Auth::user()->can('manage_present-address')){
            abort(403);
        }
        $address = EmployeeAddress::findOrFail($request->address_id);
        $address->division_id = $request->division_id;
        $address->district_id = $request->district_id;
        $address->thana_id = $request->thana_id;
        $address->post_office = $request->post_office;
        $address->village_road = $request->village_road;
        $address->post_code = $request->post_code;
        $address->mobile = $request->mobile;
        $address->address_type = $request->address_type;

        if($request->address_type =='Present') {
            $employee = Employee::findOrFail($request->employee_id);
            $employee->present_district_id = $request->district_id;
            $employee->save();
        }
        try{
            DB::beginTransaction();
            $address->save();
            
            DB::commit();
            return redirect()->route('employee-profile.show',[$request->employee_id,'#present-address'])->with('success',"Employee address information updated successfully.");
        } catch (\Exception $ex) {
            DB::rollback();
            \Log::error($ex);
            return redirect()->back()->withErrors("Whoops!! Something went wrong. Please try again.");
        }
    }
//
//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param  \App\EmployeeAddress  $employeeAddress
//     * @return \Illuminate\Http\Response
//     */
//    public function destroy(EmployeeAddress $employeeAddress)
//    {
//        //
//    }
}
