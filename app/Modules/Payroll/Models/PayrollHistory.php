<?php

namespace App\Modules\Payroll\Models;

use App\EmployeeProfile\Model\Bank;
use App\EmployeeProfile\Model\BankBranch;
use App\Traits\AuditTrails;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class PayrollHistory extends Model
{
    use SoftDeletes ,AuditTrails;
    protected $table = "payroll_history";
    protected $dates = ['deleted_at'];

    public function getEmployee($id){
        $data = DB::select(DB::raw("SELECT e.id, concat(IFNULL(e.first_name,''),' ', IFNULL(e.middle_name,''),' ', IFNULL(e.last_name,'')) as name
                ,e.bank_account_no , e.pfno, e.incremented_amount inc_amnt,e.office_id ,e.gender,e.designation_status as ds
                , e.first_joining_date as joining_date, e.current_basic_pay , e.grade, e.designation_id, e.designation_ranking
                , d.title AS designation,dp.department_name department, dp.location loc, e.status, e.scale_id
                , banks.bank_name, bank_branches.branch_name, e.bank_name bank_id, e.branch_name as branch_id
                , dg.group_name, e.freedom_fighter, e.disabled, e.disabled_child
                FROM employees e
                LEFT JOIN designations as d ON d.id=e.designation_id
                LEFT JOIN departments as dp ON dp.id=e.office_id
                LEFT JOIN department_group dg ON dp.department_group_id=dg.id
                LEFT JOIN banks ON banks.id=e.bank_name
                LEFT JOIN bank_branches ON bank_branches.id=e.branch_name
                WHERE e.id = {$id}
                AND e.deleted_at is null
                "));

        return $data;
    }
}
