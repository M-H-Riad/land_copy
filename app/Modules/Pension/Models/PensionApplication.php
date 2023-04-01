<?php

namespace App\Modules\Pension\Models;

use Illuminate\Database\Eloquent\Model;

class PensionApplication extends Model {
    //
	protected $table = 'pension_application';
	protected $guarded = ['id', 'created_at', 'updated_at'];

	public function employee(){
		return $this->belongsTo('App\EmployeeProfile\Model\Employee','emp_id','id');
	}
	public function time_period_percent(){
		return $this->belongsTo('App\Modules\Pension\Models\PensionableTimePeriodPercentage','time_period_percent_id','id');
	}
	public function gratuity(){
		return $this->belongsTo('App\Modules\Pension\Models\GratuityValue','gratuity_id','id');
	}
	public function bank(){
		return $this->belongsTo('App\Modules\BankBranch\Models\Bank','bank_id','id');
	}
	public function branch(){
		return $this->belongsTo('App\Modules\BankBranch\Models\Branch','branch_id','id');
	}
}
