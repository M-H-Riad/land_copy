<?php

namespace App\Modules\Pension\Models;

use Illuminate\Database\Eloquent\Model;

class GratuityValue extends Model {
    //
	protected $table = 'gratuity_value';
	protected $guarded = ['id', 'created_at', 'updated_at'];
	public function year(){
		return $this->belongsTo('App\Modules\Pension\Models\GratuityYear','year_id','id');
	}
}
