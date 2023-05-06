<?php

namespace App\Modules\User\Controllers;

use App\Department;
use App\Designation;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Modules\User\Models\Module;
use App\Modules\User\Models\Permission;
use App\Modules\User\Models\RoleUser;
use App\Modules\User\Models\Role;
use App\User;
use Illuminate\Http\Request;
use Input;
use Redirect;
use Session;
use Validator;
use View;
use Illuminate\Support\Facades\DB;

class RoleUserController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $data['title'] = 'View Role Users';
        //$data['roles'] = RoleUser::with('perms')->orderBy('display_name', 'asc')->get();
        $data['role_user'] = RoleUser::with('username','role')->orderBy('user_id', 'asc')->get();

        // dd($data['roles']);

        return View::make('User::role_user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //echo "45345"; die;

        $data['title'] = 'Create New Role User';
        //$data['permissions'] = Permission::get();
        //$data['modules'] = Module::where('status',1)->get();
        $data['roles'] = Role::pluck('display_name','id')->toArray();
        $data['users'] = User::pluck('name','id')->toArray();
        dd($data['roles']);
        return View::make('User::role_user.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //echo "aaaa"; die;

        $validation = Validator::make($request->all(),
            [
                'user_id' => 'required|unique:role_user',
                'role_id' => 'required',
               // 'parent_id' => 'sometimes|integer|exists:roles,id'
            ]
        );

        if( $validation->fails() ) {
            return Redirect::back()->withInput()->withErrors($validation);
        }

        $role_user = new RoleUser;
        $role_user->role_id = $request->input('role_id');
        $role_user->user_id = $request->input('user_id');

        $role_user->save();


        // // Flash::success('Role '.$role->name.' added successfully and selected (if any) permission(s) attached to that role.');
        Session::flash('success', 'Role User '.$role_user->user_id.' added successfully and selected (if any) permission(s) attached to that role.');
        return Redirect('role-user');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //echo "edit";die;

        //$data['title'] = 'Update Role User Information';
        $roleuser = RoleUser::where('user_id', $id)->get();
        $roles = Role::pluck('display_name','id');
        $users = User::pluck('name','id');

        //print_r($roleuser[0]->role_id);die;

        return view('User::role_user.edit', compact('roleuser', 'roles', 'users'));
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $role_user = DB::table('role_user')->where('user_id', $id)->update(array('role_id' =>$request->input('role_id')));

        //DB::enableQueryLog();
        //$user = DB::table('role_user')->where('user_id',$id)->toSql();
        //dd($user);



        // Flash::success('Role '.$role->name.' updated successfully.');
        Session::flash('success', 'Role User updated successfully.');
        // return Redirect('role');
        //return Redirect::back();
        return Redirect('role-user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        echo "destroy";die;
        //
    }

    public function roleuser(Request $request)
    {
        echo "roleuser";die;
        // dd('Ok');
        $query = User::where('status', 'Active');

        if($request->has('name')){
            $query->where('name', 'LIKE', '%'.$request->name.'%');
        }

        if($request->has('emp_id')){
            $query->where('emp_id', 'LIKE', '%'.$request->emp_id.'%');
        }

        if($request->has('user_role_id')){
            $query->where('role_id', $request->user_role_id);
        }

        if($request->has('department_id')){
            $query->where('department_id', $request->department_id);
        }

        if($request->has('designation_id')){
            $query->where('designation_id', $request->designation_id);
        }

        $users = $query->orderBy('name', 'asc')->paginate(10);

        $roles = Role::lists('display_name', 'id')->toArray();
        $departments = Department::where('status', 'Active')->lists('dept_name', 'id')->toArray();
        $designations = Designation::where('status', 'Active')->lists('designation_name', 'id')->toArray();
        return view('metronic.users.role.roleuser', compact('users', 'roles', 'departments', 'designations'));
    }

    public function roleuser_update(Request $request, $id)
    {
        echo "role_user_update";die;
        //dd($request->all());
        $validation = Validator::make($request->all(), ['role_id' => 'required|array']);

        if( $validation->fails() ) {
            return Redirect::back()->withInput()->withErrors($validation);
        }

        $user = User::findOrFail($id);
        //$user->role_id = $request->role_id;
        //$user->save();

        $user->roles()->sync($request->role_id);

        Session::flash('success', 'Role updated successfully.');
        return Redirect::back();
    }
}
