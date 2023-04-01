<?php

namespace App\Modules\GeneralConfiguration\Models;

use Illuminate\Database\Eloquent\Model;

class PayScaleList extends Model
{
	protected $guarded = ['id','created_at','updated_at'];
	protected $table = 'pay_scale_list';
}
