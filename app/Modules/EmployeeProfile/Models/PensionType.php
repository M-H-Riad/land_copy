<?php

namespace App\EmployeeProfile\Model;

use Illuminate\Database\Eloquent\Model;

class PensionType extends Model
{
	protected $guarded = ['id','created_at','updated_at'];
	protected $table = 'pension_type';
}
