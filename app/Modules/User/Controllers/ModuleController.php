<?php namespace App\Modules\User\Controllers;

use App\Modules\User\Models\Module;
use App\Modules\User\Models\Permission;
use App\Modules\User\Models\Role;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Session;

class ModuleController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['roles'] = Module::with('perms')->orderBy('id', 'asc')->get();
        return view('User::role.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['permissions'] = Permission::get();

        return view('User::role.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'          => 'required|unique:roles',
            'display_name'  => 'required'
        ]);

        $role               = new Role;
        $role->name         = $request->input('name');
        $role->display_name = $request->input('display_name');
        if(Auth::user()->stakeholder_id){
            $role->stakeholder_id = Auth::user()->stakeholder_id;
            $role->parent_id = $request->all('parent_id');
        }
        $role->save();

        $permission_ids = $request->input('permission_ids');
        if( count( $permission_ids ) ) {
            $role->perms()->attach( $permission_ids );
        }

        // // Flash::success('Role '.$role->name.' added successfully and selected (if any) permission(s) attached to that role.');
        Session::flash('message', 'Role '.$role->name.' added successfully and selected (if any) permission(s) attached to that role.');
        return redirect('/role');
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

        $data['title']      = 'Update Role Details';
        $data['role']       = Role::with('perms')->where('roles.id', $id)->first();
        
        $currentPermissions = [];
        if( count( $data['role']->perms ) ) {
            foreach( $data['role']->perms as $currentPermission ) {
                array_push($currentPermissions, $currentPermission->id);
            }
        }

        $data['permissions'] = Permission::get();
        $data['currentPermissions'] = $currentPermissions;

        return view('User::role.edit', $data);
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

        $this->validate($request, ['name' => 'required|alpha_num']);

        $role = Role::findOrFail($id);
        $role->name = $request->input('name');
        $role->save();

        $permission_ids = $request->input('permission_ids');
        if( count( $permission_ids ) ) {
            $role->perms()->detach();
            $role->perms()->attach( $permission_ids );
        } else {
            $role->perms()->detach();
        }

        // Flash::success('Role '.$role->name.' updated successfully.');
        Session::flash('message', 'Role '.$role->name.' updated successfully.');
        return redirect()->route('role.index');
    }

}
