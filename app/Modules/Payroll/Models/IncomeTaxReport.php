<?php

namespace App\Modules\Payroll\Models;

use App\Modules\EmployeeProfile\Models\Bank;
use App\Modules\EmployeeProfile\Models\BankBranch;
use App\Traits\AuditTrails;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class IncomeTaxReport extends Model
{
    use SoftDeletes ,AuditTrails;
    protected $table = "income_tax_report";
    protected $dates = ['deleted_at'];
    public function relBank()
    {
        return $this->belongsTo(Bank::class, 'bank_id', 'id');
    }

    public function relBranch()
    {
        return $this->belongsTo(BankBranch::class, 'bank_branch_id', 'id');
    }
    // total monthly income tax sum
    public function monthlyTotalIncomeTax($month_id)
    {
        return $data = DB::select("
            select 
                sum(it_ded) as total_income_tax_ded , sum(it_arrear_ded) as total_income_tax_arrear_ded
            from payroll_employees 
            where deleted_at is null 
            and month_id = {$month_id}
        ");
    }
    // total monthly income tax sum
    public function employeeTotalIncomeTax($month_id,$employee_id)
    {
        return $data = DB::select("
            select 
                sum(it_ded) as income_tax_ded, sum(it_arrear_ded) as income_tax_arrear_ded
            from payroll_employees 
            where deleted_at is null 
            and month_id in  ({$month_id})
            and employee_id = {$employee_id}
        ");
    }

//// total monthly income tax sum
//    public function monthlyTotalIncomeTax($month_id)
//    {
//        return $data = DB::select("
//            select
//                ROUND(sum(it_ded)) as total
//            from payroll_employees
//            where deleted_at is null
//            and month_id = {$month_id}
//        ");
//    }
//    // total monthly income tax sum
//    public function employeeTotalIncomeTax($month_id,$employee_id)
//    {
//        return $data = DB::select("
//            select
//                ROUND(sum(it_ded)) as income_tax
//            from payroll_employees
//            where deleted_at is null
//            and month_id in  ({$month_id})
//            and employee_id = {$employee_id}
//        ");
//    }

}
