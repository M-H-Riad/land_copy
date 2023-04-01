<?php

namespace App\Modules\Payroll\Models;

use App\EmployeeProfile\Model\Employee;
use App\Traits\AuditTrails;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class PayrollEmployee extends Model {

    use SoftDeletes, AuditTrails;

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function secondRow()
    {
        return $this->belongsTo(PayrollEmployee::class,'employee_id','employee_id');
    }
    public function employeeTotalGPF($month_id,$employee_id,$report)
    {
        return $data = DB::select("
            select 
                sum({$report}) as total
            from payroll_employees 
            where deleted_at is null 
            and month_id in  ({$month_id})
            and employee_id = {$employee_id}
        ");
    }
}
