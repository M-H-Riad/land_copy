<?php

namespace App\EmployeeProfile\Model;

use App\Traits\AuditTrails;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeePayrollSetting extends Model
{
   use SoftDeletes, AuditTrails;
   protected $guarded = ['id'];

   public function relEmployee(){
       return $this->belongsTo(Employee::class, 'employee_id', 'id')->select('id','first_name','middle_name','last_name','email','mobile','status');
   }

}
