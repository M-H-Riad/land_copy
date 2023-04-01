<?php

namespace App\Modules\EmployeeProfile\Controllers;

use App\EmployeeProfile\Model\Employee;
use App\EmployeeProfile\Model\EmployeeTransfer;
use App\Http\Controllers\Controller;
use App\Modules\Payroll\Traits\PayrollCreateOrUpdate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\EmployeeProfile\Model\EmployeeWasaJobExperience;
use App\Modules\GeneralConfiguration\Models\PayScaleList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EmployeeWasaJobExperienceController extends Controller {
    use PayrollCreateOrUpdate;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        if (!Auth::user()->can('manage_job')) {
            \App\Library\AuditTrailLib::addTrail('Employee Job', Auth::user()->user_name, 'Create Job information - not permitted', 'Invalid Action');
            abort(403);
        }
        $this->validate($request, [
            'employee_id'        => 'required|integer|exists:employees,id',
            "office_order_no"    => "required",
            "office_order_date"  => "required",
            "joining_date"       => "required",
            "designation"        => "required|exists:designations,id",
            "office_zone"        => "required|exists:departments,id",
            "scale_year"         => "required|integer",
            "scale"              => "required|integer",
            "basic_pay"          => "required|numeric",
            "class"              => "required",
            "current_job"        => "required",
        ]);

        $employee = Employee::select('id','pfno','grade','current_basic_pay','incremented_amount','last_basic_pay','scale_id','office_id','designation_id','designation_ranking','designation_status','freedom_fighter','gender','current_joining_date')->findOrFail($request->employee_id);
        $this->empJson = json_encode($employee);
//        $incrementedAmount =  $this->__getIncrementedAmount($request,$employee);
        $incrementedAmount = $request->basic_pay - $employee->current_basic_pay  ;
        $data = [
            'employee_id'           => $request->employee_id,
            'pfno'                  => $employee->pfno,
            "office_order_no"       => $request->office_order_no,
            'order_date'            => changeDateFormatToDb($request->office_order_date),
            "joining_date"          => $joining_date = changeDateFormatToDb($request->joining_date),
            'designation_id'        => $request->designation,
            'designation_status'    => $request->designation_status,
            'class'                 => $request->class,
            "office_id"             => $request->office_zone,
            'scale_year'            => $request->scale_year,
            "scale_id"              => $request->scale,
            "grade"                 => $grade = PayScaleList::select('grade')->whereId($request->scale)->first()->grade,
            "basic_pay"             => $request->basic_pay,
            "current_job"           => $request->current_job,
            'created_by'            => auth()->user()->id
        ];

        $updateFlag = false;
        if (($employee->current_joining_date == null OR $employee->current_joining_date <= $joining_date)  && $request->current_job == 1 ) {
            $employee->current_joining_date = $joining_date;
            $updateFlag = true;
        } elseif ($request->current_job == 1 && $employee->current_joining_date >= $joining_date){
            return redirect()->back()->withErrors("New joining date is less than current joining date. Please change joining date");
        }
        if ($updateFlag) {
            $employee->designation_id            = $request->designation;
            $employee->designation_ranking       = getDesignationRanking($request->designation);
            $employee->designation_status        = $request->designation_status;
            $employee->designation_status_order  = getDesignationStatusOrder($request->designation_status);
            $employee->office_id                 = $request->office_zone;
            $employee->scale_id                  = $request->scale;
            $employee->grade                     = $grade;
            $employee->class                     = $request->class;
            $employee->last_basic_pay            = $employee->current_basic_pay;
            $employee->current_basic_pay         = $request->basic_pay;
            $employee->incremented_amount        = $incrementedAmount;
        }

        try {
            DB::beginTransaction();
            if($request->current_job == 1){
                EmployeeWasaJobExperience::where('employee_id',$request->employee_id)->update(['current_job'=> 0]);
                EmployeeTransfer::where('employee_id',$request->employee_id)->update(['current_transfer'=> 0]);
            }
            $job = EmployeeWasaJobExperience::create($data);

            $employee->save();
            if($job && $request->current_job == 1){
                $this->employee    = $employee;
                $this->employeeJob = $job;
                $this->payrollHistory();
            }

            \App\Library\AuditTrailLib::addTrail('Employee Job', Auth::user()->user_name, 'Create Job information - Requests :  ' . json_encode($request->all()), 'Success');
            DB::commit();
            return redirect()->route('employee-profile.show', [$request->employee_id, '#job'])->with('success', "JOB INFORMATION (WASA EXPERIENCE) DATA SUCCESSFULLY INSERTED");
        } catch (\Exception $ex) {
            DB::rollback();

            Log::info($ex->getMessage());
            return redirect()->back()->withErrors("Whoops!! Something went wrong. Please try again.");
        }
    }

    private function __getIncrementedAmount($request,$employee) {

      
        $grade = PayScaleList::findOrFail($request->scale);


        if ($employee->grade == $grade->grade) {
            $scaleDetails = PayScaleList::where('scale_year', $request->scale_year)->where('grade', $grade->grade)->orderBy('scale', 'ASC')->get();
            $newAmount = $scaleDetails->where('scale', '<', $request->basic_pay)->last();
            // dd($request->all());

            $inc = $request->basic_pay - $newAmount->scale;
            if ($inc > 0) {
                return $inc;
            } else {
                return null;
            }
        } elseif ($employee->grade > $request->grade) {
           
            $scaleDetails = PayScaleList::where('scale_year', $request->scale_year)->where('grade', $grade->grade)->orderBy('scale', 'ASC')->get();
            $newAmount = $scaleDetails->where('scale', '<', $request->basic_pay)->last();

            if (is_null($newAmount)) {
                $newAmount = $scaleDetails->firstWhere('scale', '>', $request->basic_pay);
                return $inc = $newAmount->scale - $request->basic_pay;
            } else {
             
                $inc = $request->basic_pay - $newAmount->scale;
                if ($inc > 0) {
                    return $inc;
                } else {
                    return null;
                }
            }
        }

        /* get scale details */

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @internal param \App\EmployeeJobExperience $employeeJobExperience
     */
    public function update(Request $request) {
        if (!Auth::user()->can('manage_job')) {
            \App\Library\AuditTrailLib::addTrail('Employee Job', Auth::user()->user_name, 'Update Job information - not permitted', 'Invalid Action');
            abort(403);
        }
        $this->validate($request, [
            'employee_id'        => 'required|integer|exists:employees,id',
            "office_order_no"    => "required",
            "office_order_date"  => "required",
            "joining_date"       => "required",
            "designation"        => "required|exists:designations,id",
            "office_zone"        => "required|exists:departments,id",
            "scale_year"         => "required|integer",
            "scale"              => "required|integer",
            "basic_pay"          => "required|numeric",
            "class"              => "required",
            "current_job"        => "required"
        ]);
        $employee      = Employee::select('id','pfno','grade','current_basic_pay','incremented_amount','last_basic_pay','scale_id','office_id','designation_id','designation_ranking','designation_status','freedom_fighter','gender','current_joining_date')->findOrFail($request->employee_id);


        $this->empJson = json_encode($employee);
        $data = [
            'employee_id'        => $request->employee_id,
            'pfno'               => $employee->pfno,
            "office_order_no"    => $request->office_order_no,
            'order_date'         => changeDateFormatToDb($request->office_order_date),
            "joining_date"       => $joining_date = changeDateFormatToDb($request->joining_date),
            'designation_id'     => $request->designation,
            'designation_status' => $request->designation_status,
            'class'              => $request->class,
            "office_id"          => $request->office_zone,
            'scale_year'         => $request->scale_year,
            "scale_id"           => $request->scale,
            "grade"              => $grade = PayScaleList::select('grade')->whereId($request->scale)->first()->grade,
            "basic_pay"          => $request->basic_pay,
            "current_job"        => $request->current_job,
        ];
        if (($employee->current_joining_date == null OR $employee->current_joining_date <= $joining_date)  && $request->current_job == 1  ) {
            $employee->current_joining_date = $joining_date;
            $employee->save();
        }

        try {
            DB::beginTransaction();

            $job     = EmployeeWasaJobExperience::where('id',$request->job_id)->first();
            if($request->current_job == 1){
                EmployeeWasaJobExperience::where('employee_id',$request->employee_id)->update(['current_job'=> 0]);
                $employee->designation_id            = $request->designation;
                $employee->designation_ranking       = getDesignationRanking($request->designation);
                $employee->designation_status        = $request->designation_status;
                $employee->designation_status_order  = getDesignationStatusOrder($request->designation_status);
                $employee->office_id                 = $request->office_zone;
                $employee->scale_id                  = $request->scale;
                $employee->grade                     = $grade;
                $employee->class                     = $request->class;
                $employee->last_basic_pay            = $employee->current_basic_pay;
                $employee->incremented_amount        = $request->basic_pay -$employee->current_basic_pay;
                $employee->current_basic_pay         = $request->basic_pay;
                $employee->save();
                $transfer = EmployeeTransfer::where('id',$job->transfer_id)->first();
                EmployeeTransfer::where('employee_id',$request->employee_id)->update(['current_transfer'=> 0]);
                if($transfer){
                    $transfer->current_transfer = 1;
                    $transfer->save();
                }
            }
            EmployeeWasaJobExperience::where('id', $request->job_id)->update($data);
            if($employee->current_basic_pay > 0 && $request->current_job == 1){
                $this->employee    = $employee;
                $this->employeeJob = $job;
                $this->payrollHistory();
            }
            \App\Library\AuditTrailLib::addTrail('Employee Job', Auth::user()->user_name, 'Update Job information - Requests :  ' . json_encode($request->all()), 'Success');
            DB::commit();
            return redirect()->route('employee-profile.show', [$request->employee_id, '#job'])->with('success', "JOB INFORMATION (WASA EXPERIENCE) DATA SUCCESSFULLY UPDATED");
        } catch (\Exception $ex) {
            Log::info($ex->getMessage());
            return redirect()->back()->withInput()->withErrors("Whoops!! Something went wrong. Please try again.");
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return \Illuminate\Http\Response
     * @internal param \App\EmployeeJobExperience $employeeJobExperience
     */
    public function destroy($id) {
        if (!Auth::user()->can('delete_job')) {
            abort(403);
        }
        $data    = EmployeeWasaJobExperience::find($id);
        $lastJob = EmployeeWasaJobExperience::where('employee_id',$data->employee_id)->where('current_job',1)->orderBy('id','desc')->first();

        if($lastJob->id == $data->id) {
            return redirect()->back()->with('error', 'Sorry can not deleted this information');
        }
        $data->delete();
        $data->deleted_by = Auth()->user()->id;
        $data->update();

        return redirect()->back()->with('success', 'Data Successfully Deleted');
    }

}
