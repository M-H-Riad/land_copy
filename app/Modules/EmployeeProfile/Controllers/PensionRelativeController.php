<?php

namespace App\Modules\EmployeeProfile\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\EmployeeProfile\Models\PensionRelative;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
class PensionRelativeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Auth::user()->can('manage_pension_relatives')){
           \App\Library\AuditTrailLib::addTrail('Pension',Auth::user()->user_name,'Store relative information','Invalid Action');
           abort(403);
       }
       $this->validate($request, [
        "employee_id" => "required|integer",
//            "children_name" => "required|string",
//            "sex" => "required|string",
//            "children_date_of_birth" => "required|date",
//            "profession" => "required|string",
    ]);
       $data = new PensionRelative();
       $data->employee_id = $request->employee_id;
       $data->name = $request->name;
       $data->relation = $request->relation;
       $data->phone_no = $request->phone_no;
       $data->created_by = Auth()->user()->id;
       try{
        DB::beginTransaction();
        $data->save();
        DB::commit();
        \App\Library\AuditTrailLib::addTrail('Pension',Auth::user()->user_name,'Store relative information | Request : '.json_encode($request->all()),'Success');
        return redirect()->route('employee-profile.show',[$request->employee_id,'type=pension#pension-relative'])->with('success',"Employee Relatives information added successfully.");
    } catch (\Exception $ex) {
        DB::rollback();
        \App\Library\AuditTrailLib::addTrail('Pension',Auth::user()->user_name,'Store relative information | Request : '.json_encode($request->all()).' | Message : '.$ex->getMessage(),'Error');
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
        if(!Auth::user()->can('manage_pension_relatives')){
            \App\Library\AuditTrailLib::addTrail('Pension',Auth::user()->user_name,'Update relative information','Invalid Action');
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
        $data = PensionRelative::findOrFail($request->relative_id);
        $data->name = $request->name;
        $data->relation = $request->relation;
        $data->phone_no = $request->phone_no;
        $data->updated_by = Auth()->user()->id;
        try{
            $data->save();
            \App\Library\AuditTrailLib::addTrail('Pension',Auth::user()->user_name,'Update relative information | Request : '.json_encode($request->all()),'Success');
            return redirect()->route('employee-profile.show',[$request->employee_id,'type=pension#pension-relative'])->with('success',"Employee Relatives information update successfully.");
        } catch (\Exception $ex) {
            \App\Library\AuditTrailLib::addTrail('Pension',Auth::user()->user_name,'Update relative information | Request : '.json_encode($request->all()).' | Message : '.$ex->getMessage(),'Error');
            return redirect()->back()->withErrors("Whoops!! Something went wrong. Please try again.");
        }
    }

    public function destroy($id) {
       if (!Auth::user()->can('delete_pension_relatives')) {
        \App\Library\AuditTrailLib::addTrail('Pension',Auth::user()->user_name,'Delete relative information','Invalid Action');
        abort(403);
    }
    $data = PensionRelative::find($id);
    $data->delete();
    $data->deleted_by = Auth()->user()->id;
    $data->update();
    \App\Library\AuditTrailLib::addTrail('Pension',Auth::user()->user_name,'Delete relative information. id : '.$id,'Success');
    return redirect()->back()->with('message', 'Data Successfully Deleted');
}
}
