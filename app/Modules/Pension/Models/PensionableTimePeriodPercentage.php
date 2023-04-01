<?php

namespace App\Modules\Pension\Models;

use Illuminate\Database\Eloquent\Model;

class PensionableTimePeriodPercentage extends Model {
    //
	protected $table = 'pensionable_time_period_percents';
	protected $guarded = ['id', 'created_at', 'updated_at'];
	public function year(){
		return $this->belongsTo('App\Modules\Pension\Models\PensionableTimePeriodYear','year_id','id');
	}
}
