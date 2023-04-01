<?php


namespace App\Modules\Payroll\Traits;


use App\EmployeeProfile\Model\EmployeeChildren;
use App\EmployeeProfile\Model\EmployeeMembership;
use App\EmployeeProfile\Model\EmployeePayrollSetting;
use App\Modules\Payroll\Models\Payroll;
use App\Modules\Payroll\Models\PayrollHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait PayrollCreateOrUpdate
{
    public $employeeJob               = [];
    public $employee                  = [];
    public $payrollHistory            = [];
    public $employeePayrollSetting    = [];
    public $employeeMembership        = [];
    public $payrollSettings           = [];
    public $employee_payroll_settings = [];
    public $salaryIncrementBy         = 0;
    var $empJson                      = 0;
    var $h_rent                       = 0;
    public function payrollManage(){
        $payroll                      = Payroll::where('employee_id',$this->payrollHistory->employee_id)->first();
        $this->employeePayrollSetting = $this->employee_payroll_settings->where('employee_id',$this->payrollHistory->employee_id)->first();
        if (is_null($this->employeePayrollSetting) && $this->employee->pfno != null && $this->employee->bank_account_no != null && $this->employee->grade != null) {
            $employeePayrollSettings                = new EmployeePayrollSetting();
            $employeePayrollSettings->employee_id   = $this->payrollHistory->employee_id;
            $employeePayrollSettings->pfno          = $this->payrollHistory->pfno;
            $employeePayrollSettings->prv_fund_type = 0;
            $employeePayrollSettings->prv_fund      = 0.00;
            $employeePayrollSettings->updated_at    = \Carbon\Carbon::now();
            $employeePayrollSettings->save();
            $this->employeePayrollSetting           = $employeePayrollSettings;
        }
        if($this->employee->pfno != null && $this->employee->bank_account_no != null && $this->employee->grade != null){
            if(!$payroll instanceof Payroll){
                    $payroll                        = new Payroll();
                    $payroll->employee_id           = $this->employee->id;
                    $payroll->pfno                  = $this->employee->pfno;
                    $payroll->designation           = $this->employee->designation_id;
                    $payroll->designation_ranking   = $this->employee->designation_ranking;
                    $payroll->office_id             = $this->employee->office_id;
                    $payroll->grade                 = $this->employee->grade;
                    $payroll->scale_id              = $this->employee->scale_id;
                    $payroll->bank_id               = $this->employee->bank_id;
                    $payroll->branch_id             = $this->employee->branch_id;
                    $payroll->save();
                }

            DB::table('payrolls')->where('id', $payroll->id)->update($this->calculatePayroll());

            return true;
        }else{
            return false;
        }

    }
    public function calculatePayroll(){
       $incomeTax = $this->incomeTax($this->employee);
        $payroll = [
            'basic_pay'  => $this->payrollHistory->new_basic_pay,
            'tech_pay'   => $this->techPay(),
            'house_alw'  => $this->houseAllowance(),
            'f_bonus'    => 0,
            'med_alw'    => $this->medicalAllowance(),
            'conv_alw'   => $this->convAllowance(),
            'wash_alw'   => $this->washAllowance(),
            'chrg_alw'   => $this->chargeAllowance(),
            'gas_alw'    => $this->gasAllowance(),
            'ws_alw'     => $this->wsAllowance(),
            'tiffin_alw' => $this->tiffinAllowance(),
            'edu_alw'    => $this->eduAllowance(),
            'prv_fund'   => $this->prv_fund(),
            'h_rent'     => $this->employeePayrollSetting->h_rent == 1 ? $this->h_rent : 0,
            'welfare'    => $this->welfare(),
            'trusty_fund'=> 0,
            'ben_fund'   => 0,
            'gr_insu'    => $this->grInsurance(),
            'elec_bill'  => 0,
            'ws_ded'     => $this->wsDed(),
            'titas_gas'  => $this->titasGas(),
            'water_gov'  => 0,
            'hr_main'    => 0,
            'dps_fee'    => $this->membershipDeduction('dps_fee'),
            'union_sub'  => $this->membershipDeduction('union_sub'),
            'deas_fee'   => $this->membershipDeduction('deas_fee'),
            'dhak_usf'   => $this->membershipDeduction('dhak_usf'),
//            'it_ded'     => ($this->employeePayrollSetting->it_ded && $this->employeePayrollSetting->it_ded > 0) ? $this->employeePayrollSetting->it_ded : 0,
            'it_ded'     => $incomeTax,
            'day_sal'    => 0,
            'dearness'   => 0,
            'rev_stamp'  => $this->revenueStamp(),
            'updated_at' => Carbon::now(),
        ];
        DB::table('employee_payroll_settings')
            ->where('employee_id', $this->payrollHistory->employee_id)
            ->update(['it_ded' => $incomeTax,'updated_at'=> \Carbon\Carbon::now()]);

//        $this->employeePayrollSetting->it_ded = $this->incomeTax($this->employee);
//        $this->employeePayrollSetting->save();
        return $payroll;
    }
    public function payrollHistory(){
        $payrollHistory                      = PayrollHistory::where('employee_job_id',$this->employeeJob->id)->where('employee_id',$this->employee->id)->first();
        if(!$payrollHistory instanceof PayrollHistory){
            $payrollHistory                  = new PayrollHistory();
            $payrollHistory->type            = 'new-job-experience';
        }else{
            $payrollHistory                  = new PayrollHistory();
            $payrollHistory->type            = 'job-experience-update';
        }
        $payrollHistory->old_data            = $this->empJson;
        $payrollHistory->employee_id         = $this->employee->id;
        $payrollHistory->pfno                = $this->employee->pfno;
        $payrollHistory->employee_job_id     = $this->employeeJob->id;
        $payrollHistory->designation_ranking = $this->employee->designation_ranking;
        $payrollHistory->designation_id      = $this->employeeJob->designation_id;
        $payrollHistory->designation_status  = $this->employee->designation_status;
        $payrollHistory->office_id           = $this->employeeJob->office_id;
        $payrollHistory->scale_id            = $this->employeeJob->scale_id;
        $payrollHistory->grade               = $this->employeeJob->grade;
        $payrollHistory->last_basic_pay      = $this->employee->last_basic_pay;
        $payrollHistory->new_basic_pay       = $this->employee->current_basic_pay;
        $payrollHistory->status              = 'Pending';
        if($this->salaryIncrementBy > 0){
            $payrollHistory->created_by      = $this->salaryIncrementBy;
        }
        $payrollHistory->save();
     //   writeToLog('Payroll History add','info');
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
    //tech_pay
    private function techPay()
    {
        $return = 0;
        if($this->employeePayrollSetting){
            switch ($this->employeePayrollSetting->tech_pay_amount):
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
    //med_alw
    private function medicalAllowance()
    {
        $data = $this->payrollSettings->where('payroll_head_id',5)->first();
        if($data){
            return $data->rate;
        }
        return 0;
    }
    //conv_alw
    private function convAllowance()
    {
        if($this->employee->status == 'PRL'){
            return 0;
        }

        $data = $this->payrollSettings->where('payroll_head_id',8)->first();
        if($this->employee->grade >= $data->grade){
            return $data->rate;
        }
        return 0;
    }
    //chrg_alw
    private function chargeAllowance()
    {
        if($this->employee->status == 'PRL'){
            return 0;
        }

        if($this->employee->ds == 2 || $this->employee->ds == 3 || $this->employee->ds == 4 ){
            $data = $this->payrollSettings->where('payroll_head_id',10)->first();
            $netAllowance = ($this->payrollHistory->new_basic_pay + $this->employeePayrollSetting->per_pay) * $data->rate; // Example: 10% of Basic Pay

            return $netAllowance > $data->max ? $data->max : $netAllowance;
        }
        return 0;
    }
    //gas_alw
    private function gasAllowance()
    {
        if($this->employee->status == 'PRL'){
            return 0;
        }

        if ($this->employeePayrollSetting && $this->employeePayrollSetting->gas_alw == 1) {
            $data = $this->payrollSettings->where('payroll_head_id', 11)->first();
            if ($data) {
                return $data->rate;
            }
        }
        return 0;
    }
    //wash_alw
    private function washAllowance()
    {
         $data = $this->payrollSettings->where('payroll_head_id',9)->first();
         if($this->employee->grade >= $data->grade){
            return $data->rate;
         }
         return 0;
    }
    //ws_alw
    private function wsAllowance()
    {
        $data = $this->payrollSettings->where('payroll_head_id',12)->first();
        if($data){
            return $data->rate;
        }
        return 0;
    }
    //tiffin_alw
    private function tiffinAllowance()
    {
        if($this->employee->status == 'PRL'){
            return 0;
        }

        $data = $this->payrollSettings->where('payroll_head_id',15)->first();
        if($this->employee->grade >= $data->grade){
            return $data->rate;
        }
        return 0;
    }
    //edu_alw
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
    //prv_fund
    private function prv_fund()
    {
        if($this->employee->status == 'PRL'){
            return 0;
        }

        if($this->employeePayrollSetting){
            if($this->employeePayrollSetting->prv_fund_type == 1){

                $netAmount = ($this->payrollHistory->new_basic_pay + $this->employeePayrollSetting->per_pay) * $this->employeePayrollSetting->prv_fund / 100;
            }else{
                $netAmount = $this->employeePayrollSetting->prv_fund;
            }
        }else {
                $netAmount = ($this->payrollHistory->new_basic_pay + $this->employeePayrollSetting->per_pay) * 0.125; //12.5% of Basic Pay
        }
        return round($netAmount);
    }
    //welfare
    private function welfare()
    {
        if($this->employee->status == 'PRL'){
            return 0;
        }

        $data = $this->payrollSettings->where('payroll_head_id',287)->first();
        if($data){
            return $data->rate;
        }
        return 0;
    }
    //gr_insu
    private function grInsurance()
    {
        if($this->employee->status == 'PRL'){
            return 0;
        }
        $data = $this->payrollSettings->where('payroll_head_id', 289)
            ->where('grade', '<=', $this->employee->grade)
            ->where('grade_max', '>=', $this->employee->grade)->first();
        if($data){
            $gr =($this->payrollHistory->new_basic_pay + $this->employeePayrollSetting->per_pay) * $data->rate ;
            //as per wasa requirement group insurance is max 40 taka;
            return  $gr < $data->max ? $gr : $data->max;
        }
        return 0;
    }
    //trusty Fund
    private function trustyFund()
    {
        if($this->employee->status == 'PRL'){
            return 0;
        }

        if($this->employee->grade) {
            $data = $this->payrollSettings->where('payroll_head_id', 288)
                ->where('grade', '<=', $this->employee->grade)
                ->where('grade_max', '>=', $this->employee->grade)
                ->first();
            if ($data) {
                return $data->rate;
            }
        }
        return 0;
    }
    //ws_ded
    private function wsDed()
    {
        if($this->employeePayrollSetting && $this->employeePayrollSetting->ws_ded == 1) {

            $data = $this->payrollSettings->where('payroll_head_id', 292)->first();
            if ($data) {
                return $data->rate;
            }else{
                return 00000;
            }
        }
        return 0;
    }
    //titas_gas
    private function titasGas()
    {
        if($this->employeePayrollSetting && $this->employeePayrollSetting->titas_gas == 1) {

            $data = $this->payrollSettings->where('payroll_head_id', 293)->first();
            if ($data) {
                if($this->employeePayrollSetting->stove == 1){
                    return $data->min;
                }elseif($this->employeePayrollSetting->stove == 2){
                    return $data->max;
                }else {
//                    return $data->rate;
                    return 0;
                }
            }
        }
        return 0;
    }
    //house_alw && h_rent
    private function houseAllowance()
    {
        $pData = $this->payrollSettings->where('basic_pay','>=',$this->employee->current_basic_pay)->where('payroll_head_id',4)->where('ref_id',$this->employee->loc)->sortBy('basic_pay')->first();
        if($pData) {
            $netAllowance = $pData->rate * ($this->payrollHistory->new_basic_pay + $this->employeePayrollSetting->per_pay); //(monthly pay + personal pay) * rate
            $return = $netAllowance >= $pData->min ? $netAllowance : $pData->min;
        } else {
            $return = 0.00;// test data; 0 for production
        }
        if($this->employeePayrollSetting->h_rent == 1 && $this->employeePayrollSetting->h_rent_type == 2){
            $this->h_rent = ($this->payrollHistory->new_basic_pay + $this->employeePayrollSetting->per_pay) * 0.4;
        } else {
            $this->h_rent = $return;
        }

        return $return;
    }
    //dps_fee , union_sub , deas_fee, dhak_usf
    private function membershipDeduction($case)
    {
        switch ($case):
            case 'dps_fee':
                if($this->employee->status == 'PRL'){
                    return 0;
                }

                $data = $this->employeeMembership->where('membership_organization_id',6)->first();
                if($data)
                    return $data->fee;
                break;
            case 'union_sub':
                if($this->employee->status == 'PRL'){
                    return 0;
                }

                $data = $this->employeeMembership->where('membership_organization_id',9)->first();
                if($data)
                    return $data->fee;
                break;
            case 'deas_fee':
                if($this->employee->status == 'PRL'){
                    return 0;
                }

                $data = $this->employeeMembership->where('membership_organization_id',7)->first();
                if($data)
                    return $data->fee;
                break;
            case 'dhak_usf':
                if($this->employee->status == 'PRL'){
                    return 0;
                }

                $data = $this->employeeMembership->where('membership_organization_id',8)->first();
                if($data)
                    return $data->fee;
                break;
            default:
                return 0;
        endswitch;
    }
    //rev_stamp
    private function revenueStamp()
    {
        $data = $this->payrollSettings->where('payroll_head_id', 313)->first();
        if($data){
            return $data->rate;
        }
        return 0;
    }
}