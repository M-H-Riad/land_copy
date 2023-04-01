<?php


namespace App\Modules\Payroll\Traits;


use App\EmployeeProfile\Model\Department;

trait IncomeTaxTrait
{
    public $totalIncome    = 0;
    public $taxFreeAmount  = 0;
    public $rebateAmount   = 0;
    public $taxableAmount  = 0;
    public $totalTax       = 0;
    public $monthlyTax     = 0;
    public $taxSettings    = [];

    public function incomeTax($employee)
    {
        $this->taxSettings      = $taxSettings = $employee->gender == "Male" ? config('incometax.male') : config('incometax.female');
        $this->taxFreeAmount    = $this->getTexFreeAmount($employee);
        $this->totalIncome      = $this->getTotalYearlyIncome($employee);

        if ($this->totalIncome > $this->taxFreeAmount) {
            $this->totalTax     = $this->calculateYearlyTax($taxSettings);
            $this->rebateAmount = $this->getRebateAmount();
            $this->monthlyTax   = $this->calculateMonthlyTax($employee);
            return $this->monthlyTax;
        } else {
            return  0;
        }
    }

    /**
     * @param $employee
     * @return int
     */
    public function getTexFreeAmount($employee)
    {
        $start =  300000;

        if ($employee->freedom_fighter == 'Yes') {
            $start = $this->taxSettings['minStartAmountForFreedomFighter'];
        } elseif ($employee->disabled == 'Yes') {
            $start = $this->taxSettings['minStartAmountForDisabled'];
        } elseif ($employee->gender == 'Male') {
            if ($employee->disabled_child == 'Yes') {

                $start = $this->taxSettings['minStartAmountForDisabledChild'];
            } else {
                $start = $this->taxSettings['minStartAmount'];
            }
        } elseif ($employee->gender == 'Female') {
            if ($employee->disabled_child == 'Yes') {
                $start = $this->taxSettings['minStartAmountForDisabledChild'];
            } else {
                $start = $this->taxSettings['minStartAmount'];
            }
        }
        return $start;
    }

    /**
     * @param $employee
     * @return float|int
     */
    public function getTotalYearlyIncome($employee)
    {
        return $employee->current_basic_pay * 14;

    }

    /**
     * @param  $taxSettings
     * @return float|int
     */
    public function calculateYearlyTax($taxSettings)
    {
            $remainingTaxableAmount  = $this->taxableAmount = $this->totalIncome - $this->taxFreeAmount;
            $tax = 0;
            foreach ($taxSettings['slave'] as $value) {
               if($value['amount'] == 'last'){
                   if ($remainingTaxableAmount >= 1) {
                       $tax += ($remainingTaxableAmount * $value['percentage']) / 100;
                       break;
                   }
               } else {
                   if ($remainingTaxableAmount >= $value['amount']) {
                       $remainingTaxableAmount -= $value['amount'];
                       $tax += $value['tax'];
                   } else {
                       $tax += ($remainingTaxableAmount * $value['percentage']) / 100;
                       break;
                   }
               }

            }
            return $tax;
    }

    /**
     * @return float|int
     */
    public function getRebateAmount()
    {
        return ((($this->totalIncome * 25) / 100) * 15) / 100;

    }

    /**
     * @param $employee
     * @return int
     */
    public function calculateMonthlyTax($employee)
    {
        $department  = Department:: where('id',$employee->office_id)->first();
        $minimumTotalTax = $department->location == 2 ? 4000 : 5000;

        if ($this->totalTax <= $this->rebateAmount) {
            $monthlyTax = round($minimumTotalTax / 12);
        } else {
            if($this->totalTax - $this->rebateAmount < $minimumTotalTax ){
                $monthlyTax = round($minimumTotalTax / 12);
            }else{
                $monthlyTax = round(($this->totalTax - $this->rebateAmount) / 12);
            }
        }

        return $monthlyTax;
    }

}