<?php


namespace App\Modules\Payroll\Models;


use App\EmployeeProfile\Model\Designation;
use App\Traits\AuditTrails;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IfterBillEmployee extends Model
{
    use SoftDeletes ,AuditTrails;
    protected $table = "ifter_bill_employees";
    protected $dates = ['deleted_at'];
    public function designation()
    {
        return $this->belongsTo(Designation::class,'designation_id','id');
    }

}