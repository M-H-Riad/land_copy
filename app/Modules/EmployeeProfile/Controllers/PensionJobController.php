<?php

namespace App\Modules\EmployeeProfile\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\EmployeeProfile\Model\PensionJob;
use App\Modules\GeneralConfiguration\Models\PayScaleList;
use DB;
use Log;
use Auth;

class PensionJobController extends Controller {

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        if (!Auth::user()->can('manage_pension_job')) {
            \App\Library\AuditTrailLib::addTrail('Pension',Auth::user()->user_name,'Store order information','Invalid Action');
            abort(403);
        }
        $this->validate($request, [
            'employee_id' => 'required|integer|exists:employees,id',
//            "office_order_no" => "required|string",
//            "office_order_date" => "required|date",
//            "retirement_date" => "required|date",
//            "designation" => "required|exists:designations,id",
//            "office_zone" => "required|exists:offices,id",
            "scale_year" => "sometimes|nullable|integer",
            "scale" => "sometimes|nullable|integer",
            "basic_pay" => "sometimes|nullable|numeric"
        ]);

        $data = [
            'employee_id' => $request->employee_id,
            "office_order_no" => $request->office_order_no,
            'order_date' => changeDateFormatToDb($request->office_order_date),
            "retirement_date" => changeDateFormatToDb($request->retirement_date),
            'designation_id' => $request->designation,
            'designation_status' => $request->designation_status,
            "office_id" => $request->office_zone,
            'scale_year' => $request->scale_year,
            "scale_id" => $request->scale,
            "grade"=> $request->scale ? PayScaleList::select('grade')->whereId($request->scale)->first()->grade : null,
            "basic_pay" => $request->basic_pay,
            'created_by' => auth()->user()->id
        ];

        try {
            DB::beginTransaction();
            PensionJob::create($data);
            DB::commit();
            \App\Library\AuditTrailLib::addTrail('Pension',Auth::user()->user_name,'Store order information | Request : '.json_encode($request->all()),'Success');
            return redirect()->route('employee-profile.show', [$request->employee_id, 'type=pension#job'])->with('success', "JOB INFORMATION DATA SUCCESSFULLY INSERTED");
        } catch (\Exception $ex) {
            DB::rollback();
            \App\Library\AuditTrailLib::addTrail('Pension',Auth::user()->user_name,'Store order information | Request : '.json_encode($request->all()).' | Message : '.$ex->getMessage(),'Error');
            return redirect()->back()->withErrors("Whoops!! Something went wrong. Please try again.");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @internal param \App\EmployeeJobExperience $employeeJobExperience
     */
    public function update(Request $request) {
        if (!Auth::user()->can('manage_pension_job')) {
            \App\Library\AuditTrailLib::addTrail('Pension',Auth::user()->user_name,'Update order information','Invalid Action');
            abort(403);
        }
        $this->validate($request, [
            'employee_id' => 'required|integer|exists:employees,id',
//            "office_order_no" => "required|string",
//            "office_order_date" => "required|date",
//            "retirement_date" => "required|date",
//            "designation" => "required|exists:designations,id",
//            "office_zone" => "required|exists:offices,id",
//            "scale" => "required|exists:scales,id",
//            "basic_pay" => "required|integer"
            "scale_year" => "sometimes|nullable|integer",
            "scale" => "sometimes|nullable|integer",
            "basic_pay" => "sometimes|nullable|numeric"
        ]);

        $data = [
            'employee_id' => $request->employee_id,
            "office_order_no" => $request->office_order_no,
            'order_date' => changeDateFormatToDb($request->office_order_date),
            "retirement_date" => changeDateFormatToDb($request->retirement_date),
            'designation_id' => $request->designation,
            'designation_status' => $request->designation_status,
            "office_id" => $request->office_zone,
            'scale_year' => $request->scale_year,
            "grade"=> $request->scale ? PayScaleList::select('grade')->whereId($request->scale)->first()->grade : null,
            "scale_id" => $request->scale,
            "basic_pay" => $request->basic_pay,
            'updated_by' => auth()->user()->id
        ];

        try {
            PensionJob::where('id', $request->job_id)->update($data);
            \App\Library\AuditTrailLib::addTrail('Pension',Auth::user()->user_name,'Update order information | Request : '.json_encode($request->all()),'Success');
            return redirect()->route('employee-profile.show', [$request->employee_id, 'type=pension#job'])->with('success', "JOB INFORMATION DATA SUCCESSFULLY UPDATED");
        } catch (\Exception $ex) {
            \App\Library\AuditTrailLib::addTrail('Pension',Auth::user()->user_name,'Update order information | Request : '.json_encode($request->all()).' | Message : '.$ex->getMessage(),'Error');
            return redirect()->back()->withErrors("Whoops!! Something went wrong. Please try again.");
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return \Illuminate\Http\Response
     * @internal param \App\EmployeeJobExperience $employeeJobExperience
     */
    public function destroy($id) {
        if (!Auth::user()->can('delete_pension_job')) {
            \App\Library\AuditTrailLib::addTrail('Pension',Auth::user()->user_name,'Delete order information','Invalid Action');
            abort(403);
        }
        $data = PensionJob::find($id);
        $data->delete();
        $data->deleted_by = Auth()->user()->id;
        $data->update();
        \App\Library\AuditTrailLib::addTrail('Pension',Auth::user()->user_name,'Delete order information. id : '.$id,'Success');
        return redirect()->back()->with('message','Data Successfully Deleted');
    }

}
