<?php namespace App\Modules\User\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Modules\User\Models\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use DB;
use App\Mail\UserRegistration;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Modules\User\Models\Department;

class DepartmentController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
    public function index(Request $request)
    {
        $query      = Department::query();
        ($request->department_name ? $query->where('department_name', 'like', '%' . $request->department_name . '%') : null);
        // ($request->filled('status') ? $query->where('status', $request->status) : null);
        $departments  = $query->orderBy('department_name', 'ASC')->paginate(10);

        return view('User::department.index', compact('departments'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'department_name'     => 'required|unique:departments,department_name',
        ]);

        $data = [
            'department_name'     => $request->department_name,
            'status'    => 1
        ];

        // $log_info['user_id']     = Auth::user()->id;
        // $log_info['module_name'] = 'deep-tubewell';
        // $log_info['menu_name']   = 'source-type';
        // $log_info['operation']   =  1;
        // $log_info['deep_tubewell_source_type_title']=$request->title;
        // $log_info['deep_tubewell_source_type_status']=1;


        $id=Department::create($data)->id;
        //$log_info['deep_tubewell_source_type_id']=$id;
        //LogDetailsStore($log_info);

        return redirect()->back()->with('success', 'Department added successfully');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'department_name'=> 'required|unique:departments,department_name,' . $id,
            'status'    => 'required|boolean',
        ]);

        $data = [
            'department_name'     => $request->department_name,
            'status'    => $request->status
        ];

        // $log_info['user_id']     = Auth::user()->id;
        // $log_info['module_name'] = 'deep-tubewell';
        // $log_info['menu_name']   = 'source-type';
        // $log_info['operation']   =  2;
        // $log_info['deep_tubewell_source_type_title']=$request->title;
        // $log_info['deep_tubewell_source_type_status']=$request->status;
        // $log_info['deep_tubewell_source_type_id']=$id;
         
        Department::where('id', $id)->update($data);
        // LogDetailsStore($log_info);
        return redirect()->back()->with('success', 'Department updated successfully');
    }

    public function destroy($id)
    {
        if(isset($id)){
            // if( DeepTubewell::where('land_source_id', $id)->exists()){
            //     return redirect()->back()->withErrors("Permission denied! This data is used as another reference.");
            // }
            // $deep_tubewell=Designation::find($id);
            // $log_info['user_id']     = Auth::user()->id;
            // $log_info['module_name'] = 'deep-tubewell';
            // $log_info['menu_name']   = 'source-type';
            // $log_info['operation']   =  3;
            // $log_info['deep_tubewell_source_type_title']=$deep_tubewell->title;
            // $log_info['deep_tubewell_source_type_status']=$deep_tubewell->status;
            // $log_info['deep_tubewell_source_type_id']=$id;
            // LogDetailsStore($log_info);
                
            Department::find($id)->delete();
            return redirect()->back()->with('success', "Department Source successfully deleted");
        } else {
            return redirect()->back()->withErrors("No Data Found");
        }
    }
}
