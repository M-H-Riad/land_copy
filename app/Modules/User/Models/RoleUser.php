<?php

namespace App\Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoleUser extends Model
{
    protected $table = 'role_user';
    public $timestamps = false;
    protected $fillable = ['user_id', 'role_id'];

    /**
     * subordinateGroup return the sub-ordinate roles and users
     * which is combined with two different function
     * @return array of sub-ordinate roles associated with users
     */
    public function subordinateGroup(){

        $userRole = RoleUser::where('user_id', Auth::user()->id)->pluck('role_id');

        $roles = Role::whereIn('id',$userRole)->get();
        $data = ['Select One'];
        $data = $this->childRole($roles,$data);

        return $data;

    }


    public function username()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
        //return $this->hasOne('App\Modules\User\Models\RoleUser', 'user_id');
    }

    public function role()
    {
        return $this->hasOne('App\Modules\User\Models\Role', 'id', 'role_id');
    }

    /**
     * ChildRole is a recursive function
     * call make the array with current role also associate with the child role or related role based on parent id relation
     * @param $roles
     * @param $data
     * @return mixed
     */
    private function childRole($roles, $data)
    {
        foreach ($roles as $row) {
            $data[$row->display_name] = $this->roleUser($row);
            if (count($row->child) > 0) {
                $data = $this->childRole($row->child,$data);
            }
        }
        return $data;
    }

    /**
     *
     * roleUser get the role related users and make as a associated array for select box
     * @param $role
     * @return array of User
     */
    private function roleUser($role){
        $data = RoleUser::where('role_id',$role->id)
            ->leftJoin('users', [
                'role_user.user_id'     => 'users.id',
                'users.stakeholder_id'  => DB::raw(stakeholder_id())
            ])
            ->get([DB::raw("concat(users.name,' - ',users.email) as user"),'users.id']);

        $returnData = [];
        foreach ($data as $row){
            $returnData[$row->id] = $row->user;
        }
        return $returnData;
    }

}
