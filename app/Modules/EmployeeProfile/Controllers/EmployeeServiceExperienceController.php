<?php

namespace App\Modules\EmployeeProfile\Controllers;

use App\Http\Controllers\Controller;
use App\ServiceExperience;
use Illuminate\Http\Request;
use App\EmployeeProfile\Model\EmployeeServiceExperience;
use App\Modules\GeneralConfiguration\Models\PayScaleList;
use Auth;

class EmployeeServiceExperienceController extends Controller {

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        if (!Auth::user()->can('manage_experience')) {
            abort(403);
        }
        $this->validate($request, [
            'employee_id' => 'required|integer|exists:employees,id',
//            "organization" => "required|string",
//            "designation" => "required|string",
//            "from_date" => "required|date",
//            "to_date" => "required|date",
//            "pay_scale" => "required|exists:scales,id",
//            "grade" => "required",
//            "proper_channel" => "required|boolean"
//            "scale_year" => "required|integer",
//            "pay_scale" => "required|integer",
        ]);

        $data = [
            'employee_id' => $request->employee_id,
            "organization" => $request->organization,
            "designation" => $request->designation,
            "from_date" => changeDateFormatToDb($request->from_date),
            "to_date" => changeDateFormatToDb($request->to_date),
            "scale_year" => $request->scale_year,
            "scale_id" => $request->pay_scale,
            "grade" => PayScaleList::select('grade')->whereId($request->pay_scale)->first()->grade,
            "channel" => $request->proper_channel
        ];


        try {
            EmployeeServiceExperience::create($data);
            return redirect()->route('employee-profile.show', [$request->employee_id, '#experience'])->with('success', "PAST PUBLIC SECTOR EXPERIENCE OUTSIDE DHAKA WASA - DATA SUCCESSFULLY INSERTED");
        } catch (\Exception $ex) {
            \Log::info($ex->getMessage());
            return redirect()->back()->withErrors("Whoops!! Something went wrong. Please try again.");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @internal param ServiceExperience $serviceExperience
     */
    public function update(Request $request) {
        if (!Auth::user()->can('manage_experience')) {
            abort(403);
        }
        $this->validate($request, [
            'employee_id' => 'required|integer|exists:employees,id',
//            "organization" => "required|string",
//            "designation" => "required|string",
//            "from_date" => "required|date",
//            "to_date" => "required|date",
//            "pay_scale" => "required|exists:scales,id",
//            "grade" => "required",
//            "proper_channel" => "required|boolean"
//           "scale_year" => "required|integer",
//            "pay_scale" => "required|integer",
        ]);

        $data = [
            "organization" => $request->organization,
            "designation" => $request->designation,
            "from_date" => changeDateFormatToDb($request->from_date),
            "to_date" => changeDateFormatToDb($request->to_date),
            "scale_year" => $request->scale_year,
            "scale_id" => $request->pay_scale,
            "grade" => PayScaleList::select('grade')->whereId($request->pay_scale)->first()->grade,
            "channel" => $request->proper_channel
        ];


        try {
            EmployeeServiceExperience::where('id', $request->experience_id)->update($data);
            return redirect()->route('employee-profile.show', [$request->employee_id, '#experience'])->with('success', "PAST PUBLIC SECTOR EXPERIENCE OUTSIDE DHAKA WASA - DATA SUCCESSFULLY INSERTED");
        } catch (\Exception $ex) {
            \Log::info($ex->getMessage());
            return redirect()->back()->withErrors("Whoops!! Something went wrong. Please try again.");
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return \Illuminate\Http\Response
     * @internal param ServiceExperience $serviceExperience
     */
    public function destroy($id) {
        if (!Auth::user()->can('delete_experience')) {
            abort(403);
        }
        $data = EmployeeServiceExperience::find($id);
        $data->delete();
        $data->deleted_by = Auth()->user()->id;
        $data->update();

        return redirect()->back()->with('success', 'Data Successfully Deleted');
    }

}
