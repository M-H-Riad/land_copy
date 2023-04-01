<?php

namespace App\Modules\Payroll\Models;

use App\EmployeeProfile\Model\Department;
use App\EmployeeProfile\Model\Designation;
use App\EmployeeProfile\Model\Employee;
use App\Traits\AuditTrails;
use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Payroll extends Model
{
    use AuditTrails;
    protected $guarded = [];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

}

