<?php


namespace App\Modules\Payroll\Models;


use App\Traits\AuditTrails;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Overtime extends Model
{
    use SoftDeletes ,AuditTrails;
    protected $table = "overtime";
    protected $dates = ['deleted_at'];

    public function overTimeEmployee()
    {
        return $this->hasOne(OvertimeEmployee::class,'overtime_id','id');
    }
    public function overTimeDepartment()
    {
        return $this->hasOne(OvertimeDepartment::class,'overtime_id','id');
    }
}