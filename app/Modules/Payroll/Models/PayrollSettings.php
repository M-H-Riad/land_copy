<?php

namespace App\Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;

class PayrollSettings extends Model
{
    //
	protected $gurded = ['id','created_at','updated_at'];

	public function payroll_head(){
		return $this->belongsTo('App\Modules\Payroll\Models\PayrollHead','payroll_head_id','id');
	}

	public function gradeDetails(){
		return $this->belongsTo('App\EmployeeProfile\Model\Scale','grade','id');
	}
}
