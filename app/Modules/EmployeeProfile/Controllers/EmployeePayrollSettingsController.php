<?php

namespace App\Modules\EmployeeProfile\Controllers;

use App\EmployeeProfile\Model\Employee;
use App\EmployeeProfile\Model\EmployeePayrollSetting;
use App\Http\Controllers\Controller;
use App\Modules\LoanManagement\Models\LoanInfo;
use App\Modules\Payroll\Models\Payroll;
use App\Modules\Payroll\Models\PayrollSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeePayrollSettingsController extends Controller {

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        try {
            if (!Auth::user()->can('manage_employee_payroll')) {
                abort(403);
            }
            $this->validate($request, [
                "employee_id" => "required|integer",
            ]);
            $employee = Employee::with('department')->findOrFail($request->employee_id);

            if ($request->prv_fund_type) {
                if ($request->prv_fund < 12.5) {
                    return redirect()->back()->withInput()->withErrors("Provident Fund should not less than 12.5%");
                } elseif ($request->prv_fund > 30) {
                    return redirect()->back()->withInput()->withErrors("Provident Fund should not greater than 30%");
                }
            }
            $data    = EmployeePayrollSetting::where('employee_id', $request->employee_id)->first();
            \App\Library\AuditTrailLib::addTrail('Payroll Settings Update', Auth::user()->user_name,
                'Before Update Payroll Settings :  ' . json_encode($data->toArray()),
                'Success',$request->fullUrl());
            $payroll = Payroll::where('employee_id', $request->employee_id)->first();
            \App\Library\AuditTrailLib::addTrail('Payroll Update', Auth::user()->user_name,
                'Before Update Payroll information :  ' . json_encode($payroll->toArray()),
                'Success',$request->fullUrl());

            if (!$data) {
                $data = new EmployeePayrollSetting();

            }
            if (!$payroll) {
                $payroll                       = new Payroll();
                $payroll->employee_id          = $request->employee_id;
                $payroll->pfno                 = $request->pfno;
                $payroll->designation          = $employee->designation_id;
                $payroll->designation_ranking  = $employee->designation_ranking;
                $payroll->office_id            = $employee->office_id;
                $payroll->grade                = $employee->grade;
                $payroll->scale_id             = $employee->scale_id;
                $payroll->bank_id              = $employee->bank_id;
                $payroll->branch_id            = $employee ->branch_id;
                $payroll->basic_pay            = $employee ->current_basic_pay;
            }

            $data->employee_id                 = $request->employee_id;
            $data->pfno                        = $request->pfno;
//tech_pay
            $data->tech_pay_amount             = $request->tech_pay_amount;
            $payroll->tech_pay                 = $employee->incremented_amount * $request->tech_pay_amount;
//spl_pay
            $data->spl_pay                     = $request->spl_pay;
            $data->spl_pay_end                 = $request->spl_pay ? changeDateFormatToDb($request->spl_pay_end): null;
            $data->spl_pay_amount              = $request->spl_pay ? $request->spl_pay_amount : null;

            $payroll->spl_pay                  = $request->spl_pay ? $request->spl_pay_amount : 0;
//personal_pay
            $data->personal_pay                = $request->personal_pay;
            $data->per_pay_end                 = $request->personal_pay ? changeDateFormatToDb($request->per_pay_end):null;
            $data->per_pay                     = $request->personal_pay ?  $request->per_pay : null;
            $payroll->per_pay                  = $request->personal_pay ?  $request->per_pay : 0;
//salary_arrears
            $data->salary_arrears              = $request->salary_arrears;
            $data->salary_arr_end              = $request->salary_arrears ? changeDateFormatToDb($request->salary_arr_end):null;
            $data->salary_arr                  = $request->salary_arrears ? $request->salary_arr : null;
            $payroll->salary_arr               = $request->salary_arrears ? $request->salary_arr : 0;
//pf_fund_refund
            $data->pf_fund_refund              = $request->pf_fund_refund;
            $data->pf_refund_end               = $request->pf_fund_refund ? changeDateFormatToDb($request->pf_refund_end):null;
            $data->pf_refund                   = $request->pf_fund_refund ? $request->pf_refund : null;
            $payroll->pf_refund                = $request->pf_fund_refund ? $request->pf_refund : 0;
//hb_lone_refund
            $data->hb_lone_refund              = $request->hb_lone_refund;
            $data->hb_refund_end               = $request->hb_lone_refund ? changeDateFormatToDb($request->hb_refund_end):null;
            $data->hb_refund                   = $request->hb_lone_refund ? $request->hb_refund:null;
            $payroll->hb_refund                = $request->hb_lone_refund ? $request->hb_refund : 0;
//vehicle_allowance
            $data->vehicle_allowance           = $request->vehicle_allowance;
            $data->vhl_alw_end                 = $request->vehicle_allowance ? changeDateFormatToDb($request->vhl_alw_end):null;
            $data->vhl_alw                     = $request->vehicle_allowance ? $request->vhl_alw:null;
            $payroll->vhl_alw                  = $request->vehicle_allowance ? $request->vhl_alw : 0;
//vehicle_refund
            $data->vehicle_refund              = $request->vehicle_refund;
            $data->vhl_refund_end              = $request->vehicle_refund ? changeDateFormatToDb($request->vhl_refund_end):null;
            $data->vhl_refund                  = $request->vehicle_refund ? $request->vhl_refund:null;
            $payroll->vhl_refund               = $request->vehicle_refund ? $request->vhl_refund : 0;
//house_rent_arr
            $data->house_rent_arr              = $request->house_rent_arr;
            $data->hr_arr_end                  = $request->house_rent_arr ? changeDateFormatToDb($request->hr_arr_end):null;
            $data->hr_arr                      = $request->house_rent_arr ? $request->hr_arr:null;
            $payroll->hr_arr                   = $request->house_rent_arr ? $request->hr_arr : 0;
//other_allowance
            $data->other_allowance             = $request->other_allowance;
            $data->other_alw_end               = $request->other_allowance ? changeDateFormatToDb($request->other_alw_end):null;
            $data->other_alw                   = $request->other_allowance ? $request->other_alw:null;
            $payroll->other_alw                = $request->other_allowance ? $request->other_alw : 0;
//gas_alw
            $data->gas_alw                     = $request->gas_alw;
            if($employee->status == 'PRL'){
                $payroll->gas_alw              = 0;
            }else {
                if ($request->gas_alw == 1) {
                    $psg = PayrollSettings::where('payroll_head_id', 11)->first();
                    if ($psg) {
                        $payroll->gas_alw       = $psg->rate;
                    }
                } else {
                    $payroll->gas_alw           = 0;
                }
            }
//prv_fund
            $data->prv_fund                     = $request->prv_fund;
            if($request->prv_fund){
                if($request->prv_fund_type == 1){
                    $netAmount                  = ($employee->current_basic_pay + ($request->personal_pay ? $request->personal_pay : 0)) * $request->prv_fund / 100;
                } else {
                    $netAmount                  = $request->prv_fund;
                }
            }else {
                $netAmount = ($employee->current_basic_pay + ($request->personal_pay ? $request->personal_pay : 0)) * 0.125; //12.5% of Basic Pay
            }
            if($employee->status == 'PRL'){
                $payroll->prv_fund              = 0;
            }else {
                $payroll->prv_fund              = round($netAmount);
            }

            $data->prv_fund_type                = $request->prv_fund_type;
//it_ded
            $data->it_ded                       = $request->it_ded;
            $payroll->it_ded                    = $request->it_ded;
//transport_ded
            $data->transport_ded                = $request->transport_ded;
            $data->transport_end                = $request->transport_ded ? changeDateFormatToDb($request->transport_end):null;
            $data->transport                    = $request->transport_ded ? $request->transport:null;
            $payroll->transport                 = $request->transport_ded ? $request->transport : 0;
//salary_ded
            $data->salary_ded                   = $request->salary_ded;
            $data->sal_ded_end                  = $request->salary_ded ? changeDateFormatToDb($request->sal_ded_end):null;
            $data->sal_ded                      = $request->salary_ded ? $request->sal_ded:null;
            $payroll->sal_ded                   = $request->salary_ded ? $request->sal_ded : 0;
//it_arr_ded
            $data->it_arr_ded                   = $request->it_arr_ded;
            $data->it_arrear_ded_end            = $request->it_arr_ded ? changeDateFormatToDb($request->it_arrear_ded_end):null;
            $data->it_arrear_ded                = $request->it_arr_ded ? $request->it_arrear_ded:null;
            $payroll->it_arrear_ded             = $request->it_arr_ded ? $request->it_arrear_ded : 0;
//other_deduction
            $data->other_deduction              = $request->other_deduction;
            $data->other_ded_end                = $request->other_deduction ? changeDateFormatToDb($request->other_ded_end):null;
            $data->other_ded                    = $request->other_deduction ? $request->other_ded:null;
            $payroll->other_ded                 = $request->other_deduction ? $request->other_ded : 0;
//hb_loan_ded
            $data->hb_loan_ded                  = $request->hb_loan_ded;
            $data->hb_loan_ded_end              = $request->hb_loan_ded ? changeDateFormatToDb($request->hb_loan_ded_end):null;
            $data->hb_loan                      = $request->hb_loan_ded ? $request->hb_loan:null;
            $payroll->hb_loan                   = $request->hb_loan_ded ? $request->hb_loan : 0;
//hb_interest_ded
            $data->hb_interest_ded              = $request->hb_interest_ded;
            $data->hb_inttr_ded_end             = $request->hb_interest_ded ? changeDateFormatToDb($request->hb_inttr_ded_end):null;
            $data->hb_inttr                     = $request->hb_interest_ded ? $request->hb_inttr:null;
            $payroll->hb_inttr                  = $request->hb_interest_ded ? $request->hb_inttr:null;
//pc_loan_ded
            $data->pc_loan_ded                  = $request->pc_loan_ded;
            $data->pc_loan_ded_end              = $request->pc_loan_ded ? changeDateFormatToDb($request->pc_loan_ded_end):null;
            $data->pc_loan                      = $request->pc_loan_ded ? $request->pc_loan:null;
            $payroll->pc_loan                   = $request->pc_loan_ded ? $request->pc_loan : 0;
//pc_interest_ded
            $data->pc_interest_ded              = $request->pc_interest_ded;
            $data->pc_inttr_ded_end             = $request->pc_interest_ded ? changeDateFormatToDb($request->pc_inttr_ded_end):null;
            $data->pc_inttr                     = $request->pc_interest_ded ? $request->pc_inttr:null;
            $payroll->pc_inttr                  = $request->pc_interest_ded ? $request->pc_inttr : 0;
//vhcl_loan_ded
            $data->vhcl_loan_ded                = $request->vhcl_loan_ded;
            $data->vhcl_loan_ded_end            = $request->vhcl_loan_ded ? changeDateFormatToDb($request->vhcl_loan_ded_end):null;
            $data->vhcl_loan                    = $request->vhcl_loan_ded ? $request->vhcl_loan:null;
            $payroll->vhcl_loan                 = $request->vhcl_loan_ded ? $request->vhcl_loan : 0;
//vhcl_interest_ded
            $data->vhcl_interest_ded            = $request->vhcl_interest_ded;
            $data->vhcl_inttr_ded_end           = $request->vhcl_interest_ded ? changeDateFormatToDb($request->vhcl_inttr_ded_end):null;
            $data->vhcl_inttr                   = $request->vhcl_interest_ded ? $request->vhcl_inttr:null;
            $payroll->vhcl_inttr                = $request->vhcl_interest_ded ? $request->vhcl_inttr : 0;
//pf_loan_ded
            $data->pf_loan_ded                  = $request->pf_loan_ded;
            $data->pf_loan_ded_end              = $request->pf_loan_ded ? changeDateFormatToDb($request->pf_loan_ded_end):null;
            $data->pf_loan                      = $request->pf_loan_ded ? $request->pf_loan:null;
            $payroll->pf_loan                   = $request->pf_loan_ded ? $request->pf_loan : 0;
//pf_interest_ded
            $data->pf_interest_ded              = $request->pf_interest_ded;
            $data->pf_inttr_ded_end             = $request->pf_interest_ded ? changeDateFormatToDb($request->pf_inttr_ded_end):null;
            $data->pf_inttr                     = $request->pf_interest_ded ? $request->pf_inttr:null;
            $payroll->pf_inttr                  = $request->pf_interest_ded ? $request->pf_inttr : 0;
//h_rent
            $data->h_rent                       = $request->h_rent;
            $data->h_rent_type                  = $request->h_rent ? $request->h_rent_type : 0;
            if($request->h_rent){
                $pData = PayrollSettings::where('basic_pay','>=',$employee->current_basic_pay)->where('payroll_head_id',4)->where('ref_id', $employee->department->location)->orderBy('basic_pay','asc')->first();
                if($pData) {
                    if($request->h_rent_type == 1) {
                        $netAllowance = $pData->rate * ($employee->current_basic_pay + ($request->personal_pay ? $request->personal_pay : 0)); //(current basic  pay + personal pay) * rate
                        $payroll->h_rent        = $netAllowance >= $pData->min ? $netAllowance : $pData->min;
                    } elseif ($request->h_rent_type == 2){
                        $payroll->h_rent        =  ($employee->current_basic_pay + ($request->personal_pay ? $request->personal_pay : 0)) * 0.4;
                    }
                }else {
                    $payroll->h_rent            = 0.00;
                }
            }else {
                $payroll->h_rent                = 0.00;
            }
//titas_gas
            $data->titas_gas                    = $request->titas_gas;
            $data->stove                        = $request->titas_gas ? $request->stove : 0;
            if( $request->titas_gas){
                $pst = PayrollSettings::where('payroll_head_id', 293)->first();
                if ($pst) {
                    if($request->stove == 1){
                        $payroll->titas_gas     = $pst->min;
                    } elseif($request->stove == 2){
                        $payroll->titas_gas     =  $pst->max;
                    }
                }
            } else {
                $payroll->titas_gas             = 0;
            }
            $payroll->save();
            $data->save();
            // House Building Loan
            if($payroll->hb_loan > 0 || $payroll->hb_inttr > 0){
                $ded = $payroll->hb_loan + $payroll->hb_inttr ;
                $this->_loanMonthlyDeduction(1,$payroll->employee_id,$ded);
            }
            // Provident Fund Loan
            if($payroll->pf_loan > 0 || $payroll->pf_inttr > 0){
                $ded = $payroll->pf_loan + $payroll->pf_inttr ;
                $this->_loanMonthlyDeduction(2,$payroll->employee_id,$ded);
            }
            // Car/Motorcycle Loan
            if($payroll->vhcl_loan > 0 || $payroll->vhcl_inttr > 0){
                $ded = $payroll->vhcl_loan + $payroll->vhcl_inttr ;
                $this->_loanMonthlyDeduction(3,$payroll->employee_id,$ded);
            }
            // Computer Loan
            if($payroll->pc_loan > 0 || $payroll->pf_inttr > 0){
                $ded = $payroll->pc_loan + $payroll->pf_inttr ;
                $this->_loanMonthlyDeduction(5,$payroll->employee_id,$ded);
            }

            \App\Library\AuditTrailLib::addTrail('Payroll Settings Update', Auth::user()->user_name,
                'After Update Payroll Settings :  ' . json_encode($data->toArray()),
                'Success',$request->fullUrl(),json_encode($request->all()));

            \App\Library\AuditTrailLib::addTrail('Payroll Update', Auth::user()->user_name,
                'After Update Payroll information :  ' . json_encode($payroll->toArray()),
                'Success',$request->fullUrl(),'Payroll update based on Payroll Settings ans Employee information');


            return redirect()->route('employee-profile.show', [$request->employee_id, '#emp-payroll-settings'])->with('success', "Employee Payroll Settings Saved Successfully.");
        } catch (\Exception $ex) {
            \Log::error($ex);
            return redirect()->back()->withInput()->withErrors("Whoops!! Something went wrong. {$ex->getMessage()}");
        }
    }

    public function _loanMonthlyDeduction($loan_category, $employee_id, $deduct_amount)
    {
        $loan = LoanInfo::where('loan_category_id',$loan_category)->where('employee_id', $employee_id)->where('parent_id', 0)->where('status','!=','Close')->first();
        if($loan){
            $loan->monthly_deduction        = $deduct_amount;
            $loan->monthly_deduction_type   = 0;
            $loan->save();
        }
    }

}
