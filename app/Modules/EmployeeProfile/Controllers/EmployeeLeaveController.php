<?php

namespace App\Modules\EmployeeProfile\Controllers;

use App\EmployeeProfile\Model\EmployeeLeave;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EmployeeLeaveController extends Controller {

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        if (!Auth::user()->can('manage_leave')) {
            abort(403);
        }
        $this->validate($request, [
            'employee_id' => 'required|integer|exists:employees,id',
            "from_date" => "required",
            "to_date" => "required",
            "ref_no" => "required",
            "type_id" => "required|integer"
        ]);

        $data = [
            'employee_id' => $request->employee_id,
            "type_id" => $request->type_id,
            "ref_no" => $request->ref_no,
            'ref_date' => changeDateFormatToDb($request->ref_date),
            "from_date" => changeDateFormatToDb($request->from_date),
            "to_date" => changeDateFormatToDb($request->to_date),
            'details' => $request->details,
            'approval' => $request->approval,
        ];

        try {
            EmployeeLeave::create($data);
            return redirect()->route('employee-profile.show', [$request->employee_id, '#leave'])->with('success', "Leave Information Inserted successfully.");
        } catch (\Exception $ex) {
            Log::info($ex->getMessage());
            return redirect()->back()->withInput()->withErrors("Whoops!! Something went wrong. Please try again.");
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
        if (!Auth::user()->can('manage_leave')) {
            abort(403);
        }
        $this->validate($request, [
            'leave_id' => 'required|integer',
            'employee_id' => 'required|integer|exists:employees,id',
            "from_date" => "required",
            "to_date" => "required",
            "ref_no" => "required",
            "type_id" => "required|integer"
        ]);

        $data = [
            "type_id" => $request->type_id,
            "ref_no" => $request->ref_no,
            'ref_date' => changeDateFormatToDb($request->ref_date),
            "from_date" => changeDateFormatToDb($request->from_date),
            "to_date" => changeDateFormatToDb($request->to_date),
            'details' => $request->details,
            'approval' => $request->approval,
        ];

        try {
            EmployeeLeave::where('id', $request->leave_id)->update($data);
            return redirect()->route('employee-profile.show', [$request->employee_id, '#leave'])->with('success', "Leave Information updated successfully!");
        } catch (\Exception $ex) {
            Log::info($ex->getMessage());
            return redirect()->back()->withErrors("Whoops!! Something went wrong. Please try again.");
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param $id
     * @return \Illuminate\Http\Response
     * @internal param \App\EmployeeJobExperience $employeeJobExperience
     */
    public function destroy($id) {
        if (!Auth::user()->can('delete_job')) {
            abort(403);
        }
        $data = EmployeeLeave::find($id);
        $data->delete();
        $data->deleted_by = Auth()->user()->id;
        $data->update();

        return redirect()->back()->with('success', 'Data Successfully Deleted');
    }

}
