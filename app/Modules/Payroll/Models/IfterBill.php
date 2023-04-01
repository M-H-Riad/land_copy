<?php


namespace App\Modules\Payroll\Models;


use App\Traits\AuditTrails;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class IfterBill extends Model
{
    use SoftDeletes ,AuditTrails;
    protected $table = "ifter_bill";
    protected $dates = ['deleted_at'];
    public function ifterBillEmployee()
    {
        return $this->hasOne(IfterBillEmployee::class,'ifter_bill_id','id');
    }
}