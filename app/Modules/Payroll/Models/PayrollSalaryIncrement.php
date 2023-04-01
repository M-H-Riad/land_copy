<?php

namespace App\Modules\Payroll\Models;

use App\Traits\AuditTrails;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class PayrollSalaryIncrement extends Model
{
    use SoftDeletes ,AuditTrails;
    protected $table = "payroll_salary_increment";
    protected $dates = ['deleted_at'];

}
