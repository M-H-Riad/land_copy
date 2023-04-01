<?php

namespace App\Modules\User\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Modules\User\Models\Module;
use App\Modules\User\Models\Permission;
use App\Modules\User\Models\Role;
use Illuminate\Http\Request;
use Input;
use Redirect;
use Session;
use Validator;
use View;

class PermissionController extends Controller
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
    public function index( Request $request )
    {

     $req     = $request->all();
     $query   = Permission::where('name', '!=', null);

     ( $request->has('name') )          ? $query->where('name', 'like', trim($request->name)."%")                   : null;
     ( $request->has('display_name') )  ? $query->where('display_name', 'like', trim($request->display_name)."%")   : null;

     $data['title']       = 'View Permissions';
     $data['req']         = $req;
     $data['permissions'] = $query->get();

     return View::make('User::permission.index', $data);
 }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $data['title'] = 'Create New Permission';
        $data['roles'] = Role::pluck('display_name', 'id')->toArray();

        return View::make('User::permission.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'display_name' => 'required'
        ]);

        if( $validation->fails() ) {
            return Redirect::back()->withInput()->withErrors($validation);
        }

        // dd($request->all());

        $permission = new Permission;
        $permission->name = $request->get('name');
        $permission->display_name = $request->get('display_name');
        $permission->save();

        $role_ids = $request->get('role_id');
        foreach( $role_ids as $rid ) {
            $role = Role::findOrFail($rid);
            $role->perms()->attach([$permission->id]);
        }

        // Flash::success('Permission '.$permission->name.' added successfully.');
        Session::flash('message', 'Permission '.$permission->name.' added successfully.');
        return Redirect('permission');
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

        $data['title'] = 'Update Permission Info';
        $data['roles'] = Role::pluck('name', 'id');
        $data['permission'] = Permission::findOrFail($id);
        $data['modules'] = Module::where('status',1)->pluck('title','id')->toArray();
        // $data['prevSelectedRoles'] = [];

        // foreach( $permission->roles as $role ) {
        //  array_push($data['prevSelectedRoles'], $role->id);
        // }

        return View::make('User::permission.edit', $data);
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
                'module_id' => 'required|numeric|exists:module,id',
            ]
        );

        if( $validation->fails() ) {
            return Redirect::back()->withInput()->withErrors($validation);
        }

        $permission = Permission::findOrFail($id);
        $permission->display_name = $request->get('display_name');
        $permission->module_id = $request->module_id;
        $permission->save();

        // $role_ids = $request->get('role_id');
        // $permission->roles()->detach();
        // foreach( $role_ids as $rid ) {
        //  $role = Role::findOrFail($rid);
        //  $role->perms()->sync([$permission->id]);
        // }

        // Flash::success('Permission '.$permission->name.' updated successfully.');
        Session::flash('message', 'Permission '.$permission->display_name.' updated successfully.');
        return Redirect('permission');
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
}
