<?php

namespace App\Modules\PensionApplication\Models;

use \App\EmployeeProfile\Model\Employee;
use \App\Modules\GeneralConfiguration\Models\PayScaleList;
use App\Modules\PensionApplication\Models\PensionCalTable1;
use App\Modules\PensionApplication\Models\PensionCalTable2;

class PensionDataFinder
{

    private $app;
    private $p4_last_basic_after_incr;
    private $p4_percent1;
    private $p4_leave_encashment_amount;
    private $factor;

    public function __construct(PensionApplicationPart1ka $app)
    {
        \Log::info("Construct ...");
        $this->app = $app;
        $this->process();
    }

    private function process()
    {
        \Log::info("Process ...");
        $this->getNextBaseSalaryOfSameGrade();
        $this->getPercent();
        $this->calculateMultiplicationFactor();
        $this->getLeaveEncashmentValue();
    }

    private function getNextBaseSalaryOfSameGrade()
    {
        $currentGrade = $this->app->employee->grade;
        $incrementAvail = $this->checkIncrementAvail();

        $scale = PayScaleList::find($this->app->employee->scale_id);

        // dd($scale->toArray());

        $scaleNext = "";
        if ($scale) {
            if ($incrementAvail) {
                $scaleNext = PayScaleList::where('scale_year', $scale->scale_year)
                    ->where('grade', $scale->grade)
                    ->where('serial', $scale->serial + 1)
                    ->first();
                // dd($scaleNext->toArray());

                if (!$scaleNext) {
                    $scaleNext = $scale;
                }
            } else {
                $scaleNext = $scale;
            }
        }

        if ($scaleNext) {
            $this->p4_last_basic_after_incr = [
                'status' => true,
                'message' => "Success",
                'value' => $scaleNext->scale
            ];
        } else {
            $this->p4_last_basic_after_incr = [
                'status' => false,
                'message' => "Employee scale not found!",
                'value' => $scaleNext
            ];
        }


        //  \Log::info("getNextBaseSalaryOfSameGrade: ".$this->p4_last_basic_after_incr);
    }

    private function checkIncrementAvail()
    {
        if ($this->app->retirement_cause == "Regular Basis" ||
            $this->app->retirement_cause == "Employees are 57 years old") {
            return true;
        }
        return false;
    }

    public function getp4_last_basic_after_incr()
    {
        return $this->p4_last_basic_after_incr;
    }


    private function getPercent()
    {
        $service_year = $this->app->total_countable_job_year;
        $retirement_date = $this->app->date_of_pension_availability;

        if (!is_null($service_year) && !is_null($retirement_date)) {
            $ppp = PensionCalTable2::where('service_length', ($service_year > 25 ? 25 : $service_year))
                ->where('start_date', '<=', $retirement_date)
                ->whereRaw(" (end_date >= '$retirement_date' OR end_date is NULL)")
                // ->where(function($q) use() {
                //     $q->where('end_date', '<=', $retirement_date)
                //       ->orWhere('end_date', NULL);
                // })
                ->first();
            if (!$ppp) {
                $this->p4_percent1 = [
                    'status' => false,
                    'message' => "Percent not found!",
                    'value' => null
                ];
            } else {
                $this->p4_percent1 = [
                    'status' => true,
                    'message' => "Success",
                    'value' => $ppp->percentage
                ];
            }
        } else {
            if (!$service_year) {
                $this->p4_percent1 = [
                    'status' => false,
                    'message' => 'Total service year not found! Please fill the previous steps.',
                    'value' => $service_year
                ];
            }
            if (!$retirement_date) {
                $this->p4_percent1 = [
                    'status' => false,
                    'message' => 'Retirement date not found!',
                    'value' => $retirement_date
                ];
            }
        }


    }

    public function getp4_percent1()
    {
        return $this->p4_percent1;
    }

    private function calculateMultiplicationFactor()
    {
        $service_year = $this->app->total_countable_job_year;
        $retirement_date = $this->app->date_of_pension_availability;

        if (!is_null($service_year) && !is_null($retirement_date)) {
            $pp = PensionCalTable1::where('start_date', '<=', $retirement_date)
                ->where(function ($q) use ($service_year, $retirement_date) {
                    $q->where('end_date', '>=', $retirement_date)->orWhere('end_date', NULL);
                })
                ->where('job_length_start', '<=', $service_year)->where('job_length_end', '>=', $service_year)
                ->orderBy('job_length_start')
                ->first();
            if ($pp) {
                $this->factor = [
                    'status' => true,
                    'message' => 'success',
                    'value' => $pp->amount
                ];
            } else {
                $this->factor = [
                    'status' => true,
                    'message' => 'success',
                    'value' => 1
                ];
            }
        } else {
            if (!$service_year) {
                $this->factor = [
                    'status' => false,
                    'message' => 'Total service year not found! Please fill the previous steps.',
                    'value' => $service_year
                ];
            }
            if (!$retirement_date) {
                $this->factor = [
                    'status' => false,
                    'message' => 'Retirement date not found!',
                    'value' => $retirement_date
                ];
            }
        }

        //  \Log::info("getMultiplicationAmount: ".$this->factor);
    }

    public function getMultiplicationFactor()
    {
        return $this->factor;
    }

    private function getLeaveEncashmentValue()
    {

        $retirement_date = strtotime($this->app->date_of_pension_availability);
        if (!$retirement_date) {
            $this->p4_leave_encashment_amount = [
                'status' => false,
                'message' => 'Retirement date not found!',
                'value' => $retirement_date
            ];
        }
        $time = strtotime('2015-07-01');

        $factor = 18;
        if ($retirement_date < $time) {
            $factor = 12;
        }

        if ((($this->app->p4_leave_encashment_years * 12) + $this->app->p4_leave_encashment_months) > $factor) {
            $factor = 12;
        } else {
            $factor = ($this->app->p4_leave_encashment_years * 12) + $this->app->p4_leave_encashment_months;
        }
        if ($this->app->last_basic) {
            $this->p4_leave_encashment_amount = [
                'status' => true,
                'message' => "Success",
                'value' => $factor * $this->app->last_basic
            ];
        } else {
            $this->p4_leave_encashment_amount = [
                'status' => false,
                'message' => "Last basic not found!",
                'value' => $this->app->last_basic
            ];
        }


        //  \Log::info("getLeaveEncashmentValue: ".$this->p4_leave_encashment_amount);
    }

    public function getp4_leave_encashment_amount()
    {
        return $this->p4_leave_encashment_amount;
    }
}
