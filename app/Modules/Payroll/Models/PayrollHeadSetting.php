<?php

namespace App\Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;

class PayrollHeadSetting extends Model
{
    //
    protected $gurded = ['id','created_at','updated_at'];

	public function payroll_head(){
		return $this->belongsTo('App\Modules\Payroll\Models\PayrollHead','payroll_head_id','id');
	}
}
