<?php

namespace App\Modules\Payroll\Models;

use App\Traits\AuditTrails;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Bonus extends Model
{
    use SoftDeletes ,AuditTrails;
    protected $table = "bonus";
    protected $dates = ['deleted_at'];

    public function getEligibleList($religion)
    {

        $religion_attach = '';
        if($religion !='All' ){
            if($religion == 'Hinduism'){
                $religion_attach = "and (e.religion='$religion' or e.religion='Hindu') ";
            }else if($religion == 'Buddha'){
                $religion_attach = "and (e.religion='$religion' or e.religion='Buddhist') ";
            }else{
                $religion_attach = "and e.religion='$religion'";
            }
        }
        $data = DB::select(DB::raw("SELECT e.id, concat(IFNULL(e.first_name,''),' ', IFNULL(e.middle_name,''),' ', IFNULL(e.last_name,'')) as name
                ,e.bank_account_no bank_acc, e.pfno, e.incremented_amount inc_amnt,e.office_id
                , e.first_joining_date as joining_date, e.current_basic_pay as basic_pay, e.grade, e.designation_status as ds
                , d.title AS designation,dp.department_name department, dp.location loc, e.status, e.religion
                , banks.bank_name, bank_branches.branch_name, e.bank_name bank_id, e.branch_name as branch_id
                , dg.group_name
                FROM employees e
                LEFT JOIN designations as d ON d.id=e.designation_id
                LEFT JOIN departments as dp ON dp.id=e.office_id
                LEFT JOIN department_group dg ON dp.department_group_id=dg.id
                LEFT JOIN banks ON banks.id=e.bank_name
                LEFT JOIN bank_branches ON bank_branches.id=e.branch_name
                WHERE (e.status='PRL' or e.status='Continue' or e.status='Suspended')
                AND e.bank_account_no !='' AND e.pfno != '' AND e.grade!='' AND e.first_joining_date !=''
               -- AND e.current_basic_pay !='' 
               {$religion_attach}
                AND e.deleted_at is null
                ORDER BY e.designation_ranking, e.current_basic_pay DESC, e.grade ASC
                -- limit 0,10
                "));

        return $data;
    }
    public function summeryList($bonus_id, $group_id)
    {
        return $data = DB::select("
            select
            
                count(fb.employee_id) as employees, 
                sum(bonus) 	as festival_bonus,
                sum(rev_stamp) 	as rev_stamp,
                sum(net_payable) 	as net_payable
            
            from bonus_employees fb
            left join employees e on fb.employee_id=e.id
            left join departments d on e.office_id=d.id
            where fb.deleted_at is null 
            and bonus_id={$bonus_id}
            and d.department_group_id={$group_id}
        ");
    }
    public function totalSummeryList($bonus_id)
    {
        return $data = DB::select("
            select
            
                count(fb.employee_id) as employees, 
                sum(bonus) 	as festival_bonus,
                sum(rev_stamp) 	as rev_stamp,
                sum(net_payable) 	as net_payable
            
            from bonus_employees fb
            left join employees e on fb.employee_id=e.id
            where fb.deleted_at is null 
            and bonus_id={$bonus_id}
        ");
    }
    public function departmentSummeryList($bonus_id)
    {

        return $data = DB::select("
            select
                fb.office_id,
                d.department_name,
                d.old_id,
                count(fb.employee_id) as employees, 
                sum(bonus) 	as festival_bonus,
                sum(rev_stamp) 	as rev_stamp,
                sum(net_payable) 	as net_payable
            
            from bonus_employees fb
            left join employees e on fb.employee_id=e.id
            left join departments d on e.office_id=d.id
            where fb.deleted_at is null 
            and bonus_id={$bonus_id}
            group by fb.office_id ORDER BY d.department_name ASC
        ");
    }
    public function bonusEmployee()
    {
        return $this->hasOne(BonusEmployee::class,'bonus_id','id');
    }
}
