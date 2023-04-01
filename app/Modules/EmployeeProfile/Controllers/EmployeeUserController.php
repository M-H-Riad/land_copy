<?php

namespace App\Modules\EmployeeProfile\Controllers;

use App\Http\Traits\SmsApi;
use App\Modules\User\Models\RoleUser;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\EmployeeProfile\Model\Employee;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EmployeeUserController extends Controller {

    use SmsApi;

    public function storeUser(Request $request) {
        if(!Auth::user()->can('manage_login_user')){
            abort(403);
        }
        try {

            $employee = Employee::findOrFail($request->employee_id);
            $password = str_random(6);
            $user = User::create([
                'name' => $employee->first_name . ' ' . $employee->middle_name . ' ' . $employee->last_name,
                'employee_id' => $employee->id,
                'user_name' => $employee->employee_id,
                'email' => $employee->email,
                'password' => bcrypt($password),
            ]);

            RoleUser::create([
                'user_id' => $user->id,
                'role_id' => 2,
            ]);

            $message = "Congratulation!! Your account has been created in WASA PIMS. \n User ID: {$employee->employee_id} \n Password: $password \n \n - WASA PIMS";

            $this->sendCustomMessage($employee->mobile, $message);

            if($employee->email) {
                Mail::raw($message, function ($m) use ($user) {
                    $m->to($user->email);
                    $m->subject('WASA PIMS-Credentials');
                });
            }


            return redirect()->route('employee-profile.show', $employee->id)->with('success', "Employee User Successfully Created. Please check SMS/Email for credentials.");
        } catch (\Exception $e) {

            \Log::error($e);
            \App\Library\AuditTrailLib::addTrail('Employee Profile', Auth::user()->user_name, 'Store User from profile ' .  json_encode($request->all()) . ' | Message : ' . $e->getMessage(), 'Error');
            return redirect()->back()->withErrors("Whoops!! Something went wrong. Please try again.");
        }
    }

    public function updateRole(Request $request)
    {
        if(!Auth::user()->can('manage_user_role')){
            abort(403);
        }
        $this->validate($request,[
            'user_name' => 'required|unique:users,user_name,' . $request->user_id
        ]);
        try {
            $user = User::findOrFail($request->user_id);
            $user->status = $request->status;
            if(!empty($request->user_name)) {
                $user->user_name = $request->user_name;
            }
            $user->save();

            RoleUser::where('user_id',$request->user_id)->update(['role_id'=>$request->role_id]);
            return redirect()->back()->with('success', "User Role has been changed!");
        } catch (\Exception $e) {

            \Log::error($e);
            \App\Library\AuditTrailLib::addTrail('Employee Profile', Auth::user()->user_name, 'Store User from profile ' .  json_encode($request->all()) . ' | Message : ' . $e->getMessage(), 'Error');
            return redirect()->back()->withErrors("Whoops!! Something went wrong. Please try again.");
        }
    }



}
