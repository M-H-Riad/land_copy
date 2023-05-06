<?php

namespace App\Modules\User\Controllers;

use App\Department;
use App\Designation;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Modules\User\Models\Module;
use App\Modules\User\Models\Permission;
use App\Modules\User\Models\Role;
use App\User;
use Illuminate\Http\Request;
use Input;
use Redirect;
use Session;
use Validator;
use View;

class RoleController extends Controller
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

        $data['title'] = 'View Roles';
        $data['roles'] = Role::with('perms')->orderBy('display_name', 'asc')->get();

        // dd($data['roles']);

        return View::make('User::role.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $data['title'] = 'Create New Role';
        //$data['permissions'] = Permission::get();
        $data['modules'] = Module::where('status',1)->get();
        $data['roles'] = Role::pluck('display_name','id')->toArray();
        return View::make('User::role.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validation = Validator::make($request->all(),
            [
                'name' => 'required|unique:roles',
                'display_name' => 'required',
               // 'parent_id' => 'sometimes|integer|exists:roles,id'
            ]
        );

        if( $validation->fails() ) {
            return Redirect::back()->withInput()->withErrors($validation);
        }

        $role = new Role;
        $role->name = $request->input('name');
        $role->display_name = $request->input('display_name');

        if($request->has('parent_id')){
            $role->parent_id = $request->input('parent_id');
        }

        $role->save();

        $permission_ids = $request->input('permission_ids');
        if( count( $permission_ids ) ) {
            $role->perms()->attach( $permission_ids );
        }

        // // Flash::success('Role '.$role->name.' added successfully and selected (if any) permission(s) attached to that role.');
        Session::flash('success', 'Role '.$role->name.' added successfully and selected (if any) permission(s) attached to that role.');
        return Redirect('/role');
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

        $data['title'] = 'Update Role Details';
        $data['role'] = Role::with('perms')->where('roles.id', $id)->findOrFail($id);
        $data['roles'] = Role::pluck('display_name','id')->toArray();
        $data['modules'] = Module::where('status',1)->get();
        $currentPermissions = [];
        if( count( $data['role']->perms ) ) {
            foreach( $data['role']->perms as $currentPermission ) {
                array_push($currentPermissions, $currentPermission->id);
            }
        }
        $data['permissions'] = Permission::get();
        $data['currentPermissions'] = $currentPermissions;
        return View::make('User::role.edit', $data);
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
        $validation = Validator::make($request->all(),
            [
                'display_name' => 'required',
                //'parent_id' => 'sometimes|numeric|exists:roles,id'
            ]
        );

        if( $validation->fails() ) {
            return Redirect::back()->withInput()->withErrors($validation);
        }

        $role = Role::findOrFail($id);
        $role->display_name = $request->display_name;
        if($request->has('parent_id')){
            $role->parent_id = $request->input('parent_id');
        }
        $role->save();

        if($request->has('permission_ids')){
            $permission_ids = $request->input('permission_ids');
            if( count( $permission_ids ) ) {
                $role->perms()->detach();
                $role->perms()->attach( $permission_ids );
            } else {
                $role->perms()->detach();
            }
        }

        if($request->has('menu_ids')){
            MenuRole::where('role_id', '=', $id)->delete();

            $menu_ids = $request->input('menu_ids');
            foreach ($menu_ids as $menu_id) {
                $menu_role = new MenuRole;
                $menu_role->role_id = $id;
                $menu_role->menu_id = $menu_id;
                $menu_role->save();
            }
        }

        // Flash::success('Role '.$role->name.' updated successfully.');
        Session::flash('success', 'Role '.$role->display_name.' updated successfully.');
        // return Redirect('role');
        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function roleuser(Request $request)
    {
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
