<?php

namespace App\Modules\User\Models;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
	protected $table = 'roles';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function department()
    {
        return $this->belongsTo('App\Department', 'description', 'id');
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function roleusers()
    {
        return $this->hasMany('App\RoleUser');
    }

    public function childRole(){
        return $this->hasMany('App\Role','parent_id','id');
    }

    public function menus()
    {
        return $this->hasMany('App\Modules\Menu\Models\MenuRole', 'role_id', 'id')->orderBy('id','asc');
    }
}
