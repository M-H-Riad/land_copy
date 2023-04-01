<?php
namespace App\Modules\Payroll\Traits;


use App\EmployeeProfile\Model\Employee;
use App\EmployeeProfile\Model\EmployeeChildren;
use App\EmployeeProfile\Model\EmployeeMembership;
use App\Modules\LoanManagement\Models\LoanInfo;
use App\Modules\LoanManagement\Models\LoanInterests;
use App\Modules\LoanManagement\Models\LoanLedger;
use App\Modules\LoanManagement\Models\LoanLedgerDraft;
use App\Modules\Payroll\Models\PayrollSettings;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

trait Calculation
{
    var $monthly_pay = 0;
    var $gross_pay = 0;
    var $total_deduction = 0;
    var $net_payable = 0;
    public $processData = [];
    public $employee = [];
    public $monthData = [];
    public $bonusData = [];
    public $employeeSettings = [];
    public $employeeAmount = [];
    public $employeeMembership = [];
    public $employeeHouseAllowance = 0;
    public  $endDate = '';

    /**
     *
     * Hold on!!!!!!! Why you are here?
     * It's a Magic Class. Do not touch anywhere (except knowing the whole payroll generation)
     *
     * @param $field
     * @param bool $isAllowance
     * @return float|int
     */

    private function calculate($field, $isAllowance = True)
    {
        if($this->employee->status == 'Suspended' || $this->employee->status == 'Lien'){
            $this->employee->basic_pay = 0;
            return 0;
        }
        $return = 0;
        switch ($field):
            case 'basic_pay':
                $return = $this->basicPay();
                break;
            case 'tech_pay':
                $return = $this->techPay();
                break;
            case 'spl_pay':
                $return = $this->splPay();
                break;
            case 'house_alw':
                $return = $this->houseAllowance();
                break;
            case 'med_alw':
                $return = $this->medicalAllowance();
                break;
            case 'f_bonus':
                $return = $this->bonus();
                break;
            case 'conv_alw':
                $return = $this->convAllowance();
                break;
            case 'wash_alw':
                $return = $this->washAllowance($field);
                break;
            case 'chrg_alw':
                $return = $this->chargeAllowance();
                break;
            case 'gas_alw':
                $return = $this->gasAllowance();
                break;
            case 'ws_alw':
                $return = $this->wsAllowance();
                break;
            case 'dearness':
                $return =  $this->monthly_pay;
                break;
            case 'tiffin_alw':
                $return = $this->tiffinAllowance();
                break;
            case 'edu_alw':
                $return = $this->eduAllowance();
                break;
            case 'per_pay':
                $return = $this->personalPay();
                break;
            case 'pf_refund':
               $return = $this->pfRefund();
                break;
            case 'hb_refund':
                $return = $this->hbRefund();
                break;
            case 'vhl_refund':
                $return = $this->vhlRefund();
                break;
            case 'vhl_alw':
                $return = $this->vhlAllowance();
                break;
            case 'hr_arr':
                $return = $this->hrArrears();
                break;
            case 'other_alw':
                $return = $this->otherAllowance();
                break;
//                $return = $this->getAllowance($field);
//                break;
            case 'salary_arr':
                $return = $this->salaryArrears();
                break;
            /**
             * case 'depu_arr':
             * $return = $this->getAllowance($field);
             * break; off
             */


            /**
             * Deduction
             */
            case 'prv_fund':
                $return = $this->prv_fund();
                break;
            case 'welfare':
                $return = $this->welfare();
                break;
            case 'rev_stamp':
                $return = $this->revenueStamp();
                break;
            case 'h_rent':
                $return = $this->employeeAmount && $this->employeeAmount->h_rent == 1 ? $this->houseAllowance() : 0;
                break;
            case 'ws_ded':
                $return = $this->wsDed();
                break;
            case 'titas_gas':
                $return = $this->titasGas();
                break;
            case 'hr_main':
                $return = 0.00; //   currently not used
                break;
            case 'elec_bill':
                $return = 0.00;  //  currently not used
                break;
            case 'water_gov':
                $return = 0.00; // currently not used
                break;

            case 'trusty_fund':
                $return = 0.00;
                // mr.arif off this on 16-09-19
//                $return = $this->trustyFund();
                break;
            case 'gr_insu':
                $return = $this->grInsurance();
                break;

                /*
                 * bypass system for few months
                 */
            case 'hb_loan':
                $return = $this->hbLoanDeduction();
                break;
            case 'pc_loan':
                $return = $this->pcLoanDeduction();
                break;
            case 'vhcl_loan':
                $return =  $this->vhclLoanDeduction();
                break;
            case 'pf_loan':
                $return = $this->pfLoanDeduction();
//                $return = $this->getLoanDeduction($field);
                break;
            case 'hb_inttr':
                $return = $this->hbInterestDed();
                break;
            case 'pc_inttr':
                $return = $this->pcInterestDed();
                break;
            case 'vhcl_inttr':
                $return = $this->vhclInterestDed();
                 break;
            case 'pf_inttr':
                $return = $this->pfInterestDed();
//                $return = $this->getLoanInterestDeduction($field);
                break;
                //bypass for few month only


            case 'transport':
                $return = $this->transportDed();
                break;
            case 'sal_ded':
                $return = $this->salaryDed();
                break;
            case 'other_ded':
                $return = $this->otherDed();
                break;
            case 'it_arrear_ded':
                $return = $this->itArrearsDed();
                break;
            case 'it_ded':
                $return = $this->itDeduction();
                break;
            case 'day_sal':
                $return = $this->oneDaySalary();
                break;

            case 'dps_fee':
                if($this->employee->status == 'PRL'){
                    return 0;
                }

                $data = $this->employeeMembership->where('membership_organization_id',6)->first();
                if($data)
                    $return = $data->fee;
                break;
            case 'union_sub':
                if($this->employee->status == 'PRL'){
                    return 0;
                }

                $data = $this->employeeMembership->where('membership_organization_id',9)->first();
                if($data)
                    $return = $data->fee;
                break;
            case 'deas_fee':
                if($this->employee->status == 'PRL'){
                    return 0;
                }

                $data = $this->employeeMembership->where('membership_organization_id',7)->first();
                if($data)
                    $return = $data->fee;
                break;
            case 'dhak_usf':
                if($this->employee->status == 'PRL'){
                    return 0;
                }

                $data = $this->employeeMembership->where('membership_organization_id',8)->first();
                if($data)
                    $return = $data->fee;
                break;

            //  loan deduction

            default:
                /*
                pf_adv	float [0]
                pf_inttr	float [0]
                hr_main	float [0]
                hb_loan	float [0]
                h_rent	float [0]
                welfare	float [0]
                trusty_fund	float [0]
                ben_fund	float [0]
                gr_insu	float [0]
                elec_bill	float [0]
                pc_inttr	float [0]
                ws_ded	float [0]
                titas_gas	float [0]
                water_gov	float [0]
                transport	float [0]
                pf_refund_ded	float [0]
                vhcl_inttr	float [0]
                hb_inttr	float [0]
                it_ded	float [0]
                dps_fee	float [0]
                union_sub	float [0]
                deas_fee	float [0]
                dhak_usf	float [0]
                sal_ded	float [0]
                pc_loan	float [0]
                other_ded	float [0]
                day_sal	float [0]
                total_ded	float [0]
                rev_stamp	float [0]
                net_payable	float [0]	 */
                $return = 0;
        endswitch;

//        $return = round($return,2);

        if($isAllowance){
            $this->gross_pay += $return;
        }else{
            $this->total_deduction += $return;
        }

//        $return = round($return,2);
        $return = round($return,2);
        return $return;
    }


    public function employeeQuery($employeeID, $requiredData)
    {
        switch ($requiredData):
            case 'children':
        //        $return = EmployeeChildren::where('employee_id',$employeeID)->where('date_of_birth','<=',\Carbon\Carbon::now()->subYears(5))->where('date_of_birth','>=',\Carbon\Carbon::now()->subYears(21))->count();
               // $return = EmployeeChildren::where('employee_id',$employeeID)->where('date_of_birth','>=',\Carbon\Carbon::now()->subYears(21))->count();
                $return = EmployeeChildren::where('employee_id',$employeeID)->where('edu_alw',1)->count();
                break;

            case 'membership':
                return $data = EmployeeMembership::leftJoin('membership_organizations as mo', 'membership_organization_id','mo.id')
                    ->where('employee_id',$employeeID)
                    ->where(function ($query){
                        $query->where('membership_organization_id',6);
                        $query->orWhere('membership_organization_id',7);
                        $query->orWhere('membership_organization_id',8);
                        $query->orWhere('membership_organization_id',9);
                    })
                    ->whereIn('membership_organization_id',[6,7,8,9])
                    ->get(['membership_organization_id','mo.fee']);
                break;

            default:
                $return = 0;
        endswitch;

        return $return;
    }

    private function basicPay()
    {
        if($this->employee->status=='Suspended' || $this->employee->status=='Lien'){
            $this->employee->basic_pay = 0;
            return 0;
        }
//        if($this->employee->joining_date > )
        $dt = Carbon::createFromFormat('Y-m-d', $this->monthData->year.'-'.$this->monthData->month.'-01');

        $joining_date = Carbon::createFromFormat('Y-m-d', $this->employee->joining_date);
        $this->monthData->endOfMonth = $dt->endOfMonth();
        if($joining_date >= $dt->firstOfMonth() && $joining_date <= $dt->endOfMonth()) {
            $working_days = $dt->endOfMonth()->diffInDays($joining_date); //total working day of salary month
        } elseif($joining_date >= $dt->endOfMonth()) {
            $working_days= 0; // Exception: advance entry or backlog salary generation
        } else {
            $working_days = $this->monthData->total_days;
        }

        return ($this->employee->basic_pay / $this->monthData->total_days ) * $working_days;
    }

    private function houseAllowance()
    {
//        $this->employee->basic_pay =  8975.00;
        $pData = $this->processData->where('basic_pay','>=',$this->employee->basic_pay)->where('payroll_head_id',4)->where('ref_id',$this->employee->loc)->sortBy('basic_pay')->first();
        if($pData) {
            $netAllowance = $pData->rate * ($this->monthly_pay + $this->getAllowance('per_pay')); //(monthly pay + personal pay) * rate
            $return = $netAllowance >= $pData->min ? $netAllowance : $pData->min;
        }else{
            $return = 0.00;// test data; 0 for production
        }
        $this->employeeHouseAllowance = $return;
        return $return;
    }

    private function techPay()
    {
        $return = 0;
        $data = $this->employeeSettings->where('employee_id',$this->employee->id)->first();
//        $data = $this->employeeSettings->where('employee_id',$this->employee->id)->where('tp_apply_month',"{$this->monthData->year}-{$this->monthData->month}")->first();
        if($data){
            switch ($data->tech_pay_amount):
                case 2:
                    $return = $this->employee->inc_amnt * 2;
                    break;
                case 1:
                    $return = $this->employee->inc_amnt * 1;
                    break;
                default:
                    $return = 0;
            endswitch;
        }
        return $return;
    }
    private function splPay()
    {
        $data = $this->employeeSettings->where('employee_id',$this->employee->id)->where('spl_pay',1)->first();
//        $data = $this->employeeSettings->where('employee_id',$this->employee->id)->first();
        if($data){
            return ($data->spl_pay_end >= $this->endDate) ? $data->spl_pay_amount : 0;
        }
        return 0;
    }
    private function personalPay()
    {
        $data = $this->employeeSettings->where('employee_id',$this->employee->id)->where('personal_pay',1)->first();
        if($data){
            return ($data->per_pay_end >= $this->endDate) ? $data->per_pay : 0;
        }
        return 0;
    }
    private function pfRefund()
    {
        $data = $this->employeeSettings->where('employee_id',$this->employee->id)->where('pf_fund_refund',1)->first();
        if ($data){
            return ($data->pf_refund_end  >= $this->endDate) ? $data->pf_refund : 0;
        }else{
            return 0;
        }
    }
    private function hbRefund()
    {
        $data = $this->employeeSettings->where('employee_id',$this->employee->id)->where('hb_lone_refund',1)->first();
        if ($data){
            return ($data->hb_refund_end >= $this->endDate) ? $data->hb_refund : 0;
        }else{
            return 0;
        }
    }
    private function vhlRefund()
    {
        $data = $this->employeeSettings->where('employee_id',$this->employee->id)->where('vehicle_refund',1)->first();
        if ($data){
            return ($data->vhl_refund_end >= $this->endDate) ? $data->vhl_refund : 0;
        }else{
            return 0;
        }
    }
    private function vhlAllowance()
    {
        if($this->employee->status == 'PRL'){
            return 0;
        }
        $data = $this->employeeSettings->where('employee_id',$this->employee->id)->where('vehicle_allowance',1)->first();
        if ($data){
            return  ($data->vhl_alw_end >= $this->endDate) ? $data->vhl_alw : 0;
        }else{
            return 0;
        }
    }
    private function salaryArrears()
    {
        $data = $this->employeeSettings->where('employee_id',$this->employee->id)->where('salary_arrears',1)->first();
        if ($data){
            return ($data->salary_arr_end >= $this->endDate) ? $data->salary_arr : 0;
        }else{
            return 0;
        }
    }
    private function hrArrears()
    {
        $data = $this->employeeSettings->where('employee_id',$this->employee->id)->where('house_rent_arr',1)->first();
        if ($data){
            return ($data->hr_arr_end >= $this->endDate) ? $data->hr_arr : 0;
        }else{
            return 0;
        }
    }
    private function otherAllowance()
    {
        $data = $this->employeeSettings->where('employee_id',$this->employee->id)->where('other_allowance',1)->first();
        if ($data){
            return ($data->other_alw_end >= $this->endDate) ? $data->other_alw : 0;
        }else{
            return 0;
        }
    }
    private function medicalAllowance()
    {
        $data = $this->processData->where('payroll_head_id',5)->first();
        if($data){
            return $data->rate;
        }
        return 0;
    }

    private function convAllowance()
    {
        if($this->employee->status == 'PRL'){
            return 0;
        }

        $data = $this->processData->where('payroll_head_id',8)->first();
        if($this->employee->grade >= $data->grade){
            return $data->rate;
        }
        return 0;
    }

    private function washAllowance($field='')
    {
        /**
         * AS per Delwar Sir's instruction the Washing Allowance will be benefited as WASA-June-18 Salary Report
         * Grade (12-20) policy will be eliminated.
         * Last update: 5 August 2018
         * DB Field:
            ALTER TABLE `employee_payroll_settings`
            ADD `wash_alw` decimal(10,0) NULL AFTER `sp_apply_month`;
         */
        /*
            $data = $this->processData->where('payroll_head_id',9)->first();
            if($this->employee->grade >= $data->grade){
                return $data->rate;
            }
            return 0;
        */

        return isset($this->employeeAmount->$field)? $this->employeeAmount->$field : 0;
    }

    private function wsAllowance()
    {
        $data = $this->processData->where('payroll_head_id',12)->first();
        if($data){
            return $data->rate;
        }
        return 0;
    }

    private function eduAllowance()
    {
        $data = $this->employeeQuery($this->employee->id,'children');
        if($data == 1 ){
            return 500;
        }elseif($data > 1){
            return 1000;
        }else {
            return 0;
        }
    }

    private function tiffinAllowance()
    {
        if($this->employee->status == 'PRL'){
            return 0;
        }

        $data = $this->processData->where('payroll_head_id',15)->first();
        if($this->employee->grade >= $data->grade){
            return $data->rate;
        }
        return 0;
    }

    private function chargeAllowance()
    {
        if($this->employee->status == 'PRL'){
            return 0;
        }

        if($this->employee->ds == 2 || $this->employee->ds == 3 || $this->employee->ds == 4 ){
            $data = $this->processData->where('payroll_head_id',10)->first();
//            $netAllowance = $this->monthly_pay * $data->rate; // Example: 10% of Basic Pay
            $netAllowance = ($this->monthly_pay + $this->getAllowance('per_pay')) * $data->rate; // Example: 10% of Basic Pay

            return $netAllowance > $data->max ? $data->max : $netAllowance;
        }
        return 0;
    }


    private function getAllowance($field)
    {
        switch ($field):
            case 'vhl_alw':
                if($this->employee->status == 'PRL'){
                    return 0;
                }
                break;
        endswitch;

        return isset($this->employeeAmount->$field)? $this->employeeAmount->$field : 0;
    }

    private function gasAllowance()
    {
        if($this->employee->status == 'PRL'){
            return 0;
        }

        if ($this->employeeAmount && $this->employeeAmount->gas_alw == 1) {
            $data = $this->processData->where('payroll_head_id', 11)->first();
            if ($data) {
                return $data->rate;
            }
        }
        return 0;
    }


    private function bonus()
    {
        return ($this->employee->basic_pay * $this->bonusData->percentage )/100;
    }

    private function prv_fund()
    {
        if($this->employee->status == 'PRL'){
            return 0;
        }

        if($this->employeeAmount){
            if($this->employeeAmount->prv_fund_type == 1){
//                $netAmount = $this->monthly_pay * $this->employeeAmount->prv_fund / 100;
                $netAmount = ($this->monthly_pay + $this->getAllowance('per_pay')) * $this->employeeAmount->prv_fund / 100;
            }else{
                $netAmount = $this->employeeAmount->prv_fund;
            }
        }else {
//            $netAmount = $this->monthly_pay * 0.125; //12.5% of Basic Pay
            $netAmount = ($this->monthly_pay + $this->getAllowance('per_pay')) * 0.125; //12.5% of Basic Pay
        }
        return round($netAmount);
    }

    private function welfare()
    {
        if($this->employee->status == 'PRL'){
            return 0;
        }

        $data = $this->processData->where('payroll_head_id',287)->first();
        if($data){
            return $data->rate;
        }
        return 0;
    }

    private function trustyFund()
    {
        if($this->employee->status == 'PRL'){
            return 0;
        }

        if($this->employee->grade) {
            $data = $this->processData->where('payroll_head_id', 288)
                ->where('grade', '<=', $this->employee->grade)
                ->where('grade_max', '>=', $this->employee->grade)
                ->first();
            if ($data) {
                return $data->rate;
            }
        }
        return 0;
    }


    private function houseRent()
    {
        return $this->employeeAmount && $this->employeeAmount->h_rent == 1 ? $this->houseAllowance() : 0;
    }
    private function hbLoanDeduction()
    {
        $data = $this->employeeSettings->where('employee_id',$this->employee->id)->where( 'hb_loan_ded' ,1)->first();
        if ($data){
            return ('hb_loan_ded_end' >= $this->endDate) ? $data->hb_loan : 0;
        }else{
            return 0;
        }

    }
    private function pcLoanDeduction()
    {
        $data = $this->employeeSettings->where('employee_id',$this->employee->id)->where( 'pc_loan_ded' ,1)->first();
        if ($data){
            return ('pc_loan_ded_end' >= $this->endDate) ? $data->pc_loan : 0;
        }else{
            return 0;
        }

    }    private function vhclLoanDeduction()
    {
        $data = $this->employeeSettings->where('employee_id',$this->employee->id)->where( 'vhcl_loan_ded' ,1)->first();
        if ($data){
            return ('vhcl_loan_ded_end' >= $this->endDate) ? $data->vhcl_loan : 0;
        }else{
            return 0;
        }

    }    private function pfLoanDeduction()
    {
        $data = $this->employeeSettings->where('employee_id',$this->employee->id)->where( 'pf_loan_ded' ,1)->first();
        if ($data){
            return ('pf_loan_ded_end' >= $this->endDate) ? $data->pf_loan : 0;
        }else{
            return 0;
        }

    }


    private function getLoanDeduction($field)
    {
        $data = $this->employeeSettings->where('employee_id',$this->employee->id)->where( $field.'_ded' ,1)->first();
        if ($data){
            return ($data->$field.'_ded_end' >= $this->endDate) ? $data->$field : 0;
        }else{
            return 0;
        }

    }
    private function getLoanInterestDeduction($field)
    {
        $data = $this->employeeSettings->where('employee_id',$this->employee->id);
            if($field == 'hb_inttr'){
                $data = $data->where('hb_interest_ded',1);
            }elseif ($field =='pc_inttr'){
                $data = $data->where('pc_interest_ded',1);
            }elseif ($field =='vhcl_inttr'){
                $data = $data->where('vhcl_interest_ded',1);
            }elseif ($field =='pf_inttr'){
                $data = $data->where('pf_interest_ded',1);
            }
        $data = $data->first();
        if ($data){
            return ($data->$field.'_ded_end' >= $this->endDate) ? $data->$field : 0;
        }else{
            return 0;
        }

    }

    private function hbInterestDed()
    {
        $data = $this->employeeSettings->where('employee_id',$this->employee->id)->where('hb_interest_ded' ,1)->first();
        if ($data){
            return ($data->hb_inttr_ded_end >= $this->endDate)  ? $data->hb_inttr : 0;
        }else{
            return 0;
        }

    }

    private function pcInterestDed()
    {
        $data = $this->employeeSettings->where('employee_id',$this->employee->id)->where('pc_interest_ded' ,1)->first();
        if ($data){
            return ($data->pc_inttr_ded_end >= $this->endDate)  ? $data->pc_inttr : 0;
        }else{
            return 0;
        }

    }
    private function vhclInterestDed()
    {
        $data = $this->employeeSettings->where('employee_id',$this->employee->id)->where('vhcl_interest_ded' ,1)->first();
        if ($data){
            return ($data->vhcl_inttr_ded_end >= $this->endDate)  ? $data->vhcl_inttr : 0;
        }else{
            return 0;
        }

    }
    private function pfInterestDed()
    {
        $data = $this->employeeSettings->where('employee_id',$this->employee->id)->where('pf_interest_ded' ,1)->first();
        if ($data){
            return ($data->pf_inttr_ded_end >= $this->endDate)  ? $data->pf_inttr : 0;
        }else{
            return 0;
        }

    }
    private function transportDed()
    {
        $data = $this->employeeSettings->where('employee_id',$this->employee->id)->where('transport_ded' ,1)->first();
        if ($data){
            return ($data->transport_end >= $this->endDate)  ? $data->transport : 0;
        }else{
            return 0;
        }

    }
    private function salaryDed()
    {
        $data = $this->employeeSettings->where('employee_id',$this->employee->id)->where('salary_ded' ,1)->first();
        if ($data){
            return ($data->sal_ded_end >= $this->endDate)  ? $data->sal_ded : 0;
        }else{
            return 0;
        }

    }
    private function otherDed()
    {
        $data = $this->employeeSettings->where('employee_id',$this->employee->id)->where('other_deduction' ,1)->first();
        if ($data){
            return ($data->other_ded_end >= $this->endDate)  ? $data->other_ded : 0;
        }else{
            return 0;
        }

    }
    private function itArrearsDed()
    {
        $data = $this->employeeSettings->where('employee_id',$this->employee->id)->where('it_arr_ded' ,1)->first();
        if ($data){
            return ($data->it_arrear_ded_end >= $this->endDate)  ? $data->it_arrear_ded : 0;
        }else{
            return 0;
        }

    }
    private function itDeduction()
    {
        return isset($this->employeeAmount->it_ded)? $this->employeeAmount->it_ded : 0;
//        return isset($this->employeeAmount->it_ded)? round($this->employeeAmount->it_ded) : 0;
    }
    private function getDeduction($field)
    {

        return isset($this->employeeAmount->$field)? $this->employeeAmount->$field : 0;
    }


    private function grInsurance()
    {
        if($this->employee->status == 'PRL'){
            return 0;
        }
        $data = $this->processData->where('payroll_head_id', 289)
            ->where('grade', '<=', $this->employee->grade)
            ->where('grade_max', '>=', $this->employee->grade)->first();
        if($data){
            $gr =($this->monthly_pay + $this->getAllowance('per_pay')) * $data->rate ;
            //as per wasa requirement group insurance is max 40 taka;
            return  $gr < $data->max ? $gr : $data->max;
        }
        return 0;
    }

    private function oneDaySalary()
    {
        return ($this->employee->basic_pay / $this->monthData->total_days ) * 1 ; //single salary
    }

    private function revenueStamp()
    {
        $data = $this->processData->where('payroll_head_id', 313)->first();
        if($data){
            return $data->rate;
        }
        return 0;
    }

    private function wsDed()
    {

        if($this->employeeAmount && $this->employeeAmount->ws_ded == 1) {

            $data = $this->processData->where('payroll_head_id', 292)->first();
            if ($data) {
                return $data->rate;
            }else{
                return 00000;
            }
        }
        return 0;
    }

    private function titasGas()
    {
        if($this->employeeAmount && $this->employeeAmount->titas_gas == 1) {

            $data = $this->processData->where('payroll_head_id', 293)->first();
            if ($data) {
                if($this->employeeAmount->stove == 1){
                    return $data->min;
                }elseif($this->employeeAmount->stove == 2){
                    return $data->max;
                }else {
//                    return $data->rate;
                }
            }
        }
        return 0;
    }

    private function hbLoan($loan_category)
    {
        $loan = LoanInfo::where('loan_category_id',$loan_category)->where('employee_id', $this->employee->id)->where('parent_id', 0)->where('status','!=','Close')->first();
        if($loan){
            if($loan->loan_category_id == 1 && $loan->monthly_deduction_type == 1){
                    $deduct_amount = $this->employeeHouseAllowance/100 * $loan->monthly_deduction;
            }else{
                $deduct_amount = $loan->monthly_deduction;
            }

            $ledger = $this->_balanceReduce($loan, $deduct_amount);
            return ['loan_amount' => $ledger->principal_realization, 'interest_amount' => $ledger->interest_realization];
        }

        return ['loan_amount' => 0, 'interest_amount' => 0];
    }


    /*
     * Auto-generated, do not edit. All changes will be undone. :p
     */
    private function _balanceReduce($loan, $deduct_amount)
    {
        LoanLedgerDraft::where(['employee_id'=>$loan->employee_id, 'loan_id'=>$loan->id])->delete();
        $ledger = New LoanLedgerDraft();
        $ledger->employee_id = $loan->employee_id;
        $ledger->loan_id = $loan->id;
        $ledger->payroll_id = $this->monthData->id;
        $ledger->pay_date = $this->monthData->endOfMonth; //Carbon::now();//last date of that month
        $ledger->interest_rate = getLoanInterest($loan->loan_category_id);
        $ledger->loan_category_id = $loan->loan_category_id;

        $last_ledger = $loan->ledgers->last();
//            $interestAmount = 10000;//LoanInterests::calculateInterestAmount($last_ledger->principal_balance, $ledger->interest_rate, $last_ledger->pay_date, $ledger->pay_date);
        $interestAmount = LoanInterests::calculateInterestAmount($last_ledger->principal_balance, $ledger->interest_rate, $last_ledger->pay_date, $ledger->pay_date);
        $ledger->interest_charge = $interestAmount;


        if($last_ledger && $last_ledger->total_balance > $deduct_amount) {

            if($last_ledger->principal_balance >= $deduct_amount)
            {
                $ledger->principal_realization = $deduct_amount;
                $ledger->principal_balance = $last_ledger->principal_balance - $deduct_amount;
                $ledger->interest_realization = 0;
                $ledger->interest_balance = $last_ledger->interest_balance + $ledger->interest_charge;
            }
            elseif($last_ledger->principal_balance < $deduct_amount)
            {
                $ledger->principal_realization = $last_ledger->principal_balance;
                $ledger->principal_balance = 0;

                $remaining_amount = $deduct_amount - $last_ledger->principal_balance;

                if($last_ledger->interest_balance >= $remaining_amount){
                    $ledger->interest_realization = $remaining_amount;
                    $ledger->interest_balance = $last_ledger->interest_balance - $remaining_amount + $ledger->interest_charge;
                }else{
                    $ledger->interest_realization = $last_ledger->interest_balance;
                    $ledger->interest_balance = 0;
                }

            }

            $ledger->total_balance = $ledger->interest_balance + $ledger->principal_balance;

            $ledger->save();

            $this->total_deduction += $deduct_amount;
//            return ['hb_loan' => $deduct_amount, 'hb_inttr' => 0];

            return $ledger;

        } else if($last_ledger && $last_ledger->total_balance != 0 && $last_ledger->total_balance <= $deduct_amount){
//                $deduct_amount;
            if($last_ledger->principal_balance <= $deduct_amount) {
                $ledger->principal_realization = $last_ledger->principal_balance;
                $ledger->principal_balance = 0;

                $ledger->interest_realization = $ledger->interest_charge + $last_ledger->interest_balance;
                $ledger->interest_balance = 0;

//                    $remaining_amount = $deduct_amount - $last_ledger->principal_balance;
//                    if($last_ledger->interest_balance >= $remaining_amount){
//                        $ledger->interest_realization = $remaining_amount;
//                        $ledger->interest_balance = $last_ledger->interest_balance - $remaining_amount;
//                    }else{
//                        $ledger->interest_realization = $last_ledger->interest_balance;
//                        $ledger->interest_balance = 0;
//                    }
                //case for 50000/6000
            }
            if($ledger->total_balance == 0){
                $loan->status = 'Closed';
                $loan->save();
            }

            $ledger->save();

            $this->total_deduction += ($ledger->principal_realization + $ledger->interest_realization);
            return $ledger;
        }
        return (object) ['principal_realization' => 0, 'interest_realization' => 0];
    }



}