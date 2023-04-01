<?php

namespace App\Modules\Payroll\Models;

use App\EmployeeProfile\Model\Employee;
use App\Traits\AuditTrails;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BonusEmployee extends Model {

    use SoftDeletes, AuditTrails;
    protected $table = "bonus_employees";
    protected $dates = ['deleted_at'];
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

}
