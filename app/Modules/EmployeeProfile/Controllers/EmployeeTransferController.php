<?php

namespace App\Modules\EmployeeProfile\Controllers;

use App\EmployeeProfile\Model\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\EmployeeProfile\Model\EmployeeTransfer;
use App\EmployeeProfile\Model\EmployeeWasaJobExperience;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
class EmployeeTransferController extends Controller {

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        if(!Auth::user()->can('manage_transfer')){
            \App\Library\AuditTrailLib::addTrail('Employee Transfer', Auth::user()->user_name, 'Create Transfer information - not permitted', 'Invalid Action');
            abort(403);
        }

        $this->validate($request, [
            "employee_id"               => "required|integer|exists:employees,id",
            "office_order_no"           => "required|string",
            "date"                      => "required",
            "current_transfer"          => "required",
            "transfer_with_promotion"   => "required|boolean",
            "designation"               => "required|exists:designations,id",
            "old_division_id"           => "required|exists:departments,id",
            "division"                  => "required|exists:departments,id"
        ]);

        try{
            $employee = Employee::findOrFail($request->employee_id);
            $data = [
                "employee_id"                 => $request->employee_id,
                "office_order_no"             => $request->office_order_no,
                "order_date"                  => $joining_date = changeDateFormatToDb($request->date),
                "is_promotion"                => $request->transfer_with_promotion,
                "designation_id"              => $request->designation,
                "old_division_id"             => $request->old_division_id,
                "division_id"                 => $request->division,
                "current_transfer"            => $request->current_transfer,
            ];

            if(($employee->current_joining_date == null OR $employee->current_joining_date <= $joining_date) && $request->current_transfer == 1 ) {
                $employee->current_joining_date = $joining_date;
                $employee->designation_id       = $request->designation;
                $employee->designation_ranking  = getDesignationRanking($request->designation);
                $employee->office_id            = $request->division;
            }

            DB::beginTransaction();

            if($request->current_transfer == 1){
                EmployeeTransfer::where('employee_id',$request->employee_id)->update(['current_transfer'=> 0]);
            }
            $transfer = EmployeeTransfer::create($data);
            if($transfer) {
                $employee->save();
                \App\Library\AuditTrailLib::addTrail('Employee Transfer', Auth::user()->user_name, 'Create Transfer information - Requests :  ' . json_encode($request->all()), 'Success');

                if($request->transfer_with_promotion)
                {
                    $jobID = $this->__jobExperience($request, $employee, $transfer);
                    DB::commit();
                    return redirect()->route('employee-profile.show', [$request->employee_id,'#job-modal'.$jobID]);
                } else {

                    if($request->current_transfer == 0 && $request->transfer_with_promotion == 0){
                        $jobID = $this->__jobExperience($request, $employee, $transfer);
                        DB::commit();
                        return redirect()->route('employee-profile.show', [$request->employee_id,'#job-modal'.$jobID]);
                    } else {
                        $lastJob = EmployeeWasaJobExperience::where('employee_id',$employee->id)->where('current_job',1)->first();
                        if(!$lastJob){
                            return redirect()->back()->withErrors("No current job set for this employee, please update a job as current job
                        in JOB & PROMOTION INFORMATION section and then transfer this employee.");
                        }
                        $data = [
                            'employee_id'         => $employee->id,
                            "office_order_no"     => $request->office_order_no,
                            'order_date'          => changeDateFormatToDb($request->date),
                            "joining_date"        => changeDateFormatToDb($request->date),
                            'designation_id'      => $request->designation,
                            "office_id"           => $request->division,
                            "designation_status"  => $lastJob->designation_status,
                            "scale_year"          => $lastJob->scale_year,
                            "scale_id"            => $lastJob->scale_id,
                            "grade"               => $lastJob->grade,
                            "class"               => $lastJob->class,
                            "basic_pay"           => $lastJob->basic_pay,
                            "transfer_id"         => $transfer->id,
                            "current_job"         => 1,
                            'created_by'          => auth()->user()->id
                        ];
                        $lastJob->current_job = 0;
                        $lastJob->save();
                        EmployeeWasaJobExperience::create($data);
                    }
                }
                DB::commit();
                $alert = "TRANSFER RECORDS - Data successfully inserted.";
                return redirect()->route('employee-profile.show', [$request->employee_id,'#transfer'])->with('success', $alert);
            }else{
                return redirect()->back()->withErrors("Whoops!! Something went wrong. Please try again.");
            }

        } catch (\Exception $ex) {
            DB::rollback();
            Log::error($ex);
            return redirect()->back()->withInput()->withErrors("Whoops!! Something went wrong. Please try again.");
        }
    }

    private function __jobExperience($request, $employee,$transfer) {
        $data = [
            'employee_id'         => $employee->id,
            "office_order_no"     => $request->office_order_no,
            'order_date'          => changeDateFormatToDb($request->date),
            'designation_id'      => $request->designation,
            "office_id"           => $request->division,
            "basic_pay"           => 0,
            "transfer_id"         => $transfer->id,
            "current_job"         => $request->current_transfer,
            'created_by'          => auth()->user()->id
        ];
        try {
            DB::beginTransaction();
            $job = EmployeeWasaJobExperience::create($data);
            DB::commit();
            return $job->id;

        } catch (\Exception $ex) {
            DB::rollback();
            Log::info($ex->getMessage());
            return false;
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @internal param \App\EmployeeTransfer $employeeTransfer
     */
    public function update(Request $request) {
        if(!Auth::user()->can('manage_transfer')){
            \App\Library\AuditTrailLib::addTrail('Employee Transfer', Auth::user()->user_name, 'Update Transfer information - not permitted', 'Invalid Action');
            abort(403);
        }
        $this->validate($request, [
            "employee_id"             => "required|integer|exists:employees,id",
            "office_order_no"         => "required|string",
            "date"                    => "required",
//            "transfer_with_promotion" => "required|boolean",
            "designation"             => "required|exists:designations,id",
            "old_division_id"         => "required|exists:departments,id",
            "division"                => "required|exists:departments,id",
            "current_transfer"        => "required",
        ]);

        try{
            $data                   = EmployeeTransfer::findOrFail($request->transfer_id);
            $empJobExp              = EmployeeWasaJobExperience::where('transfer_id',$data->id)->first();
            $empJobExpFind          = true;
            if(!$empJobExp){
                $empJobExp          = EmployeeWasaJobExperience::where(['employee_id'=> $data->employee_id ,'office_order_no' => $data->office_order_no,'order_date' => $data->order_date,])->first();
                if(!$empJobExp){
                    $empJobExpFind  = false;
                }
            }

            if($request->current_transfer == 1){
                EmployeeTransfer::where('employee_id',$request->employee_id)->update(['current_transfer'=> 0]);
            }

            $data->office_order_no  = $request->office_order_no;
            $data->order_date       = changeDateFormatToDb($request->date);
//            $data->is_promotion     = $request->transfer_with_promotion;
            $data->designation_id   = $request->designation;
            $data->old_division_id  = $request->old_division_id;
            $data->division_id      = $request->division;
            $data->current_transfer = $request->current_transfer;

            DB::beginTransaction();
            if($data->save()) {
                if($empJobExpFind){
                    $empJobExp->office_order_no  = $request->office_order_no;
                    $empJobExp->order_date       = changeDateFormatToDb($request->date);
                    $empJobExp->joining_date     = changeDateFormatToDb($request->date);
                    $empJobExp->designation_id   = $request->designation;
                    $empJobExp->office_id        = $request->division;
                    $empJobExp->save();
                    $lastJob = EmployeeWasaJobExperience::where('employee_id',$data->employee_id)->where('current_job',1)->first();
                    if( $lastJob->id == $empJobExp->id ){
                        $employee = Employee::findOrFail($data->employee_id);
                        $employee->current_joining_date = $empJobExp->joining_date;
                        $employee->designation_id       = $request->designation;
                        $employee->designation_ranking  = getDesignationRanking($request->designation);
                        $employee->office_id            = $request->division;
                        $employee->save();
                        DB::commit();
                        return redirect()->route('employee-profile.show', [$request->employee_id,'#job-modal'.$empJobExp->id]);
                    }
                }
                \App\Library\AuditTrailLib::addTrail('Employee Transfer', Auth::user()->user_name, 'Update Transfer information - Requests :  ' . json_encode($request->all()), 'Success');

                DB::commit();
                $alert = "TRANSFER RECORDS - Data successfully Updated.";
                return redirect()->route('employee-profile.show', [$request->employee_id,'#transfer'])->with('success', $alert);
            }else{
                return redirect()->back()->withErrors("Whoops!! Something went wrong. Please try again.");
            }
        } catch (\Exception $ex) {
            DB::rollback();
            Log::error($ex->getMessage());
            return redirect()->back()->withErrors("Whoops!! Something went wrong. Please try again.");
        }
    }

//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param  \App\EmployeeTransfer  $employeeTransfer
//     * @return \Illuminate\Http\Response
//     */
//    public function destroy(EmployeeTransfer $employeeTransfer) {
//        //
//    }

    public function destroy($id) {
        if (!Auth::user()->can('delete_transfer')) {
            abort(403);
        }
        $data = EmployeeTransfer::find($id);
        $data->delete();
        $data->deleted_by = Auth()->user()->id;
        $data->update();

        return redirect()->back()->with('success', 'Data Successfully Deleted');
    }
}
