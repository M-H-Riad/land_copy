<?php


namespace App\Modules\Payroll\Models;


use App\Traits\AuditTrails;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class NightAllowance extends Model
{
    use SoftDeletes ,AuditTrails;
    protected $table = "night_allowance";
    protected $dates = ['deleted_at'];
    public function nightAllowanceEmployee()
    {
        return $this->hasOne(NightAllowanceEmployee::class,'night_allowance_id','id');
    }
}