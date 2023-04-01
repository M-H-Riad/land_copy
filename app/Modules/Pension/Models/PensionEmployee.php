<?php

namespace App\Modules\Pension\Models;

use Illuminate\Database\Eloquent\Model;

class PensionEmployee extends Model {
    //
	protected $table = 'pension_employee';
	protected $guarded = ['id', 'created_at', 'updated_at'];
}
