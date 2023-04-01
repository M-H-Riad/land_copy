<?php

namespace App\Modules\Payroll\Models;

use App\EmployeeProfile\Model\Employee;
use App\Traits\AuditTrails;
use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class PayrollMonth extends Model
{
    use AuditTrails ,SoftDeletes;
    protected $guarded = [];

    public function getEligibleList($department_id ='')
    {
//        $data = Employee::leftJoin('left join employee_wasa_job_experiences as job','job.employee_id','employees.id')
//            ->where('job.id', DB::select(DB::raw('SELECT MAX(id)
//                  FROM employee_wasa_job_experiences
//                  WHERE employee_id=employees.id and office_id=28
//            ')))
//            ->where(function ($q){
//                $q->where('status','Continue');
//                $q->orWhere('status','PRL');
//            })
//            ->get(['id']);

        $department_attach = '';
        if($department_id >1 ){
//            $department_attach = "and office_id='$department_id'";   {$department_attach}
        }
        $data = DB::select(DB::raw("SELECT e.id, concat(IFNULL(e.first_name,''),' ', IFNULL(e.middle_name,''),' ', IFNULL(e.last_name,'')) as name
                ,e.bank_account_no bank_acc, e.pfno, e.incremented_amount inc_amnt,e.office_id
                , e.first_joining_date as joining_date, e.current_basic_pay as basic_pay, e.grade, e.designation_status as ds
                , d.title AS designation,dp.department_name department, dp.location loc, e.status
                , banks.bank_name, bank_branches.branch_name, e.bank_name bank_id, e.branch_name as branch_id
                , dg.group_name
                FROM employees e
                LEFT JOIN designations as d ON d.id=e.designation_id
                LEFT JOIN departments as dp ON dp.id=e.office_id
                LEFT JOIN department_group dg ON dp.department_group_id=dg.id
                LEFT JOIN banks ON banks.id=e.bank_name
                LEFT JOIN bank_branches ON bank_branches.id=e.branch_name
                WHERE (e.status='PRL' or e.status='Continue' or e.status='Suspended' )
                AND e.bank_account_no !='' AND e.pfno != '' AND e.grade!='' AND e.first_joining_date !=''
               -- AND e.current_basic_pay !='' 
                AND e.deleted_at is null
                ORDER BY e.designation_ranking, e.current_basic_pay DESC, e.grade ASC
                -- limit 0,100  or e.status='Lien'
                "));
//        -- order by job.designation_id desc, job.basic_pay desc, job.grade asc, d.ranking_id, job.joining_date asc

//dd($data);
        return $data;
    }

    public function summeryList($month_id, $group_id)
    {
        //   sum(depu_arr) 	as depu_arr,
        return $data = DB::select("
            select
                d.department_group_id as dg ,
                count(pe.employee_id) as employees, 
                sum(basic_pay) 	as basic_pay,
                sum(tech_pay) 	as tech_pay,
                sum(spl_pay) 	as spl_pay,
                sum(house_alw) 	as house_alw,
                sum(med_alw) 	as med_alw,
                sum(f_bonus) 	as f_bonus,
                sum(conv_alw) 	as conv_alw,
                sum(wash_alw) 	as wash_alw,
                sum(chrg_alw) 	as chrg_alw,
                sum(gas_alw) 	as gas_alw,
                sum(ws_alw) 	as ws_alw,
                sum(per_pay) 	as per_pay,
                sum(dearness) 	as dearness,
                sum(tiffin_alw) as tiffin_alw,
                sum(edu_alw) 	as edu_alw,
                sum(pf_refund) 	as pf_refund,
                sum(hb_refund) 	as hb_refund,
                sum(vhl_refund) as vhl_refund,
                sum(salary_arr) as salary_arr,
                sum(hr_arr) 	as hr_arr,
                
                sum(vhl_alw) 	as vhl_alw,
                sum(other_alw) 	as other_alw,
                sum(ROUND(gross_pay,2)) 	as gross_pay,
                sum(prv_fund) 	as prv_fund,
                sum(pf_loan) 	as pf_loan,
                sum(pf_inttr) 	as pf_inttr,
                sum(hr_main) 	as hr_main,
                sum(hb_loan) 	as hb_loan,
                sum(h_rent) 	as h_rent,
                sum(welfare) 	as welfare,
                sum(trusty_fund) 	as trusty_fund,
                sum(ben_fund) 	as ben_fund,
                sum(gr_insu) 	as gr_insu,
                sum(elec_bill) 	as elec_bill,
                sum(pc_inttr) 	as pc_inttr,
                sum(ws_ded) 	as ws_ded,
                sum(titas_gas) 	as titas_gas,
                sum(water_gov) 	as water_gov,
                sum(transport) 	as transport,
                sum(pf_refund_ded) 	as pf_refund_ded,
                sum(vhcl_loan) 	as vhcl_loan,
                sum(vhcl_inttr) 	as vhcl_inttr,
                sum(hb_inttr) 	as hb_inttr,
                sum(it_ded) 	as it_ded,
                sum(it_arrear_ded) 	as it_arrear_ded,
                sum(dps_fee) 	as dps_fee,
                sum(union_sub) 	as union_sub,
                sum(deas_fee) 	as deas_fee,
                sum(dhak_usf) 	as dhak_usf,
                sum(sal_ded) 	as sal_ded,
                sum(pc_loan) 	as pc_loan,
                sum(other_ded) 	as other_ded,
                sum(day_sal) 	as day_sal,
                sum(ROUND(total_ded,2)) 	as total_ded,
                sum(rev_stamp) 	as rev_stamp,
                sum(ROUND(net_payable,2)) 	as net_payable
            
            from payroll_employees pe
            left join employees e on pe.employee_id=e.id
            left join departments d on pe.office_id=d.id
            where pe.deleted_at is null 
            and month_id={$month_id}
            and d.department_group_id={$group_id}
        ");
    }
    public function totalSummeryList($month_id)
    {
        //   sum(depu_arr) 	as depu_arr,
        return $data = DB::select("
            select
            
                count(pe.employee_id) as employees, 
                sum(basic_pay) 	as basic_pay,
                sum(tech_pay) 	as tech_pay,
                sum(spl_pay) 	as spl_pay,
                sum(house_alw) 	as house_alw,
                sum(med_alw) 	as med_alw,
                sum(f_bonus) 	as f_bonus,
                sum(conv_alw) 	as conv_alw,
                sum(wash_alw) 	as wash_alw,
                sum(chrg_alw) 	as chrg_alw,
                sum(gas_alw) 	as gas_alw,
                sum(ws_alw) 	as ws_alw,
                sum(per_pay) 	as per_pay,
                sum(dearness) 	as dearness,
                sum(tiffin_alw) as tiffin_alw,
                sum(edu_alw) 	as edu_alw,
                sum(pf_refund) 	as pf_refund,
                sum(hb_refund) 	as hb_refund,
                sum(vhl_refund) as vhl_refund,
                sum(salary_arr) as salary_arr,
                sum(hr_arr) 	as hr_arr,
                
                sum(vhl_alw) 	as vhl_alw,
                sum(other_alw) 	as other_alw,
                sum(gross_pay) 	as gross_pay,
                sum(prv_fund) 	as prv_fund,
                sum(pf_loan) 	as pf_loan,
                sum(pf_inttr) 	as pf_inttr,
                sum(hr_main) 	as hr_main,
                sum(hb_loan) 	as hb_loan,
                sum(h_rent) 	as h_rent,
                sum(welfare) 	as welfare,
                sum(trusty_fund) 	as trusty_fund,
                sum(ben_fund) 	as ben_fund,
                sum(gr_insu) 	as gr_insu,
                sum(elec_bill) 	as elec_bill,
                sum(pc_inttr) 	as pc_inttr,
                sum(ws_ded) 	as ws_ded,
                sum(titas_gas) 	as titas_gas,
                sum(water_gov) 	as water_gov,
                sum(transport) 	as transport,
                sum(pf_refund_ded) 	as pf_refund_ded,
                sum(vhcl_loan) 	as vhcl_loan,
                sum(vhcl_inttr) 	as vhcl_inttr,
                sum(hb_inttr) 	as hb_inttr,
                sum(it_ded) 	as it_ded,
                sum(it_arrear_ded) 	as it_arrear_ded,
                sum(dps_fee) 	as dps_fee,
                sum(union_sub) 	as union_sub,
                sum(deas_fee) 	as deas_fee,
                sum(dhak_usf) 	as dhak_usf,
                sum(sal_ded) 	as sal_ded,
                sum(pc_loan) 	as pc_loan,
                sum(other_ded) 	as other_ded,
                sum(day_sal) 	as day_sal,
                sum(total_ded) 	as total_ded,
                sum(rev_stamp) 	as rev_stamp,
                sum(net_payable) 	as net_payable
            
            from payroll_employees pe
            left join employees e on pe.employee_id=e.id
            where pe.deleted_at is null 
            and month_id={$month_id}
        ");
    }

//Department Monthly Salary Report
    public function departmentReportSummery($month_id, $department_id)
    {
        //      sum(depu_arr) 	as depu_arr,
        return $data = DB::select("
            select
            
                count(pe.employee_id) as employees, 
                sum(basic_pay) 	as basic_pay,
                sum(tech_pay) 	as tech_pay,
                sum(spl_pay) 	as spl_pay,
                sum(house_alw) 	as house_alw,
                sum(med_alw) 	as med_alw,
                sum(f_bonus) 	as f_bonus,
                sum(conv_alw) 	as conv_alw,
                sum(wash_alw) 	as wash_alw,
                sum(chrg_alw) 	as chrg_alw,
                sum(gas_alw) 	as gas_alw,
                sum(ws_alw) 	as ws_alw,
                sum(per_pay) 	as per_pay,
                sum(dearness) 	as dearness,
                sum(tiffin_alw) 	as tiffin_alw,
                sum(edu_alw) 	as edu_alw,
                sum(pf_refund) 	as pf_refund,
                sum(hb_refund) 	as hb_refund,
                sum(vhl_refund) 	as vhl_refund,
                sum(salary_arr) 	as salary_arr,
                sum(hr_arr) 	as hr_arr,
              
                sum(vhl_alw) 	as vhl_alw,
                sum(other_alw) 	as other_alw,
                sum(gross_pay) 	as gross_pay,
                sum(prv_fund) 	as prv_fund,
                sum(pf_loan) 	as pf_loan,
                sum(pf_inttr) 	as pf_inttr,
                sum(hr_main) 	as hr_main,
                sum(hb_loan) 	as hb_loan,
                sum(h_rent) 	as h_rent,
                sum(welfare) 	as welfare,
                sum(trusty_fund) 	as trusty_fund,
                sum(ben_fund) 	as ben_fund,
                sum(gr_insu) 	as gr_insu,
                sum(elec_bill) 	as elec_bill,
                sum(pc_inttr) 	as pc_inttr,
                sum(ws_ded) 	as ws_ded,
                sum(titas_gas) 	as titas_gas,
                sum(water_gov) 	as water_gov,
                sum(transport) 	as transport,
                sum(pf_refund_ded) 	as pf_refund_ded,
                sum(vhcl_loan) 	as vhcl_loan,
                sum(vhcl_inttr) 	as vhcl_inttr,
                sum(hb_inttr) 	as hb_inttr,
                sum(it_ded) 	as it_ded,
                sum(it_arrear_ded) 	as it_arrear_ded,
                sum(dps_fee) 	as dps_fee,
                sum(union_sub) 	as union_sub,
                sum(deas_fee) 	as deas_fee,
                sum(dhak_usf) 	as dhak_usf,
                sum(sal_ded) 	as sal_ded,
                sum(pc_loan) 	as pc_loan,
                sum(other_ded) 	as other_ded,
                sum(day_sal) 	as day_sal,
                sum(total_ded) 	as total_ded,
                sum(rev_stamp) 	as rev_stamp,
                sum(net_payable) 	as net_payable
            
            from payroll_employees pe
            left join employees e on pe.employee_id=e.id
            left join departments d on pe.office_id=d.id
            where pe.deleted_at is null 
            and month_id={$month_id}
            and d.id={$department_id}
        ");
    }

    public function departmentSummeryList($month_id)
    {
        //   sum(depu_arr) 	as depu_arr,
        return $data = DB::select("
            select
                office_id,
                d.department_name,
                d.old_id,
                count(pe.employee_id) as employees, 
                sum(basic_pay) 	as basic_pay,
                sum(tech_pay) 	as tech_pay,
                sum(spl_pay) 	as spl_pay,
                sum(house_alw) 	as house_alw,
                sum(med_alw) 	as med_alw,
                sum(f_bonus) 	as f_bonus,
                sum(conv_alw) 	as conv_alw,
                sum(wash_alw) 	as wash_alw,
                sum(chrg_alw) 	as chrg_alw,
                sum(gas_alw) 	as gas_alw,
                sum(ws_alw) 	as ws_alw,
                sum(per_pay) 	as per_pay,
                sum(dearness) 	as dearness,
                sum(tiffin_alw) as tiffin_alw,
                sum(edu_alw) 	as edu_alw,
                sum(pf_refund) 	as pf_refund,
                sum(hb_refund) 	as hb_refund,
                sum(vhl_refund) as vhl_refund,
                sum(salary_arr) as salary_arr,
                sum(hr_arr) 	as hr_arr,
                
                sum(vhl_alw) 	as vhl_alw,
                sum(other_alw) 	as other_alw,
                sum(gross_pay) 	as gross_pay,
                sum(prv_fund) 	as prv_fund,
                sum(pf_loan) 	as pf_loan,
                sum(pf_inttr) 	as pf_inttr,
                sum(hr_main) 	as hr_main,
                sum(hb_loan) 	as hb_loan,
                sum(h_rent) 	as h_rent,
                sum(welfare) 	as welfare,
                sum(trusty_fund) 	as trusty_fund,
                sum(ben_fund) 	as ben_fund,
                sum(gr_insu) 	as gr_insu,
                sum(elec_bill) 	as elec_bill,
                sum(pc_inttr) 	as pc_inttr,
                sum(ws_ded) 	as ws_ded,
                sum(titas_gas) 	as titas_gas,
                sum(water_gov) 	as water_gov,
                sum(transport) 	as transport,
                sum(pf_refund_ded) 	as pf_refund_ded,
                sum(vhcl_loan) 	as vhcl_loan,
                sum(vhcl_inttr) 	as vhcl_inttr,
                sum(hb_inttr) 	as hb_inttr,
                sum(it_ded) 	as it_ded,
                sum(it_arrear_ded) 	as it_arrear_ded,
                sum(dps_fee) 	as dps_fee,
                sum(union_sub) 	as union_sub,
                sum(deas_fee) 	as deas_fee,
                sum(dhak_usf) 	as dhak_usf,
                sum(sal_ded) 	as sal_ded,
                sum(pc_loan) 	as pc_loan,
                sum(other_ded) 	as other_ded,
                sum(day_sal) 	as day_sal,
                sum(total_ded) 	as total_ded,
                sum(rev_stamp) 	as rev_stamp,
                sum(net_payable) 	as net_payable
            
            from payroll_employees pe
            left join departments d on pe.office_id=d.id
            where pe.deleted_at is null 
            and month_id={$month_id}  
            group by pe.office_id ORDER BY d.department_name ASC
        ");
    }
    public function payrollEmployee()
    {
        return $this->hasOne(PayrollEmployee::class,'month_id','id');
    }
    public function payrollGPFEmployee()
    {
        return $this->hasMany(PayrollEmployee::class,'month_id','id');
    }
}
/**
ALTER TABLE `payroll_heads`
CHANGE `order` `order` int(5) NULL AFTER `db_field`;

12345678
and d.department_group_id= 1
Mdarnob))7
**/
