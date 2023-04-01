<?php


namespace App\Modules\Payroll\Models;


use App\Traits\AuditTrails;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class IfterBillDepartment extends Model
{
    use SoftDeletes ,AuditTrails;
    protected $table = "ifter_bill_departments";
    protected $dates = ['deleted_at'];

}