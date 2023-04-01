<?php

namespace App\Modules\Pension\Models;

use Illuminate\Database\Eloquent\Model;

class GratuityYear extends Model {
    //
	protected $table = 'gratuity_years';
	protected $guarded = ['id', 'created_at', 'updated_at'];

	public function get_value(){
		return $this->hasOne('App\Modules\Pension\Models\GratuityValue','year_id','id');
	}
}
