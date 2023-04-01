<?php

namespace App\Modules\User\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    //
	protected $table = 'module';

	protected $guarded = ['id', 'created_at', 'updated_at'];

	public function permissions(){
		return $this->hasMany('App\Modules\User\Models\Permission','module_id','id');
	}
}
