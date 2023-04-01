<?php


namespace App\Modules\Payroll\Models;


use App\Traits\AuditTrails;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class OvertimeDepartment extends Model
{
    use SoftDeletes ,AuditTrails;
    protected $table = "overtime_departments";
    protected $dates = ['deleted_at'];

}