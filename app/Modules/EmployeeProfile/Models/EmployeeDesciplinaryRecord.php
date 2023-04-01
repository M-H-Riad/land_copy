<?php

namespace App\EmployeeProfile\Model;

use Illuminate\Database\Eloquent\Model;

class EmployeeDesciplinaryRecord extends Model
{
   protected $guarded = ['id'];
   protected $table = 'disciplinary_records';
}
