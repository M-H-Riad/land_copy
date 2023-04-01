<?php

namespace App\Modules\Pension\Models;

use Illuminate\Database\Eloquent\Model;

class PensionableTimePeriodYear extends Model {
    //
	protected $table = 'pensionable_time_period_years';
	protected $guarded = ['id', 'created_at', 'updated_at'];

	public function get_percentage(){
		return $this->hasOne('App\Modules\Pension\Models\PensionableTimePeriodPercentage','year_id','id');
	}
}
