<?php

namespace App\Jobs;

use App\Modules\Payroll\Controllers\NightAllowanceController;
use App\Modules\Payroll\Models\NightAllowance;
use App\Modules\Payroll\Models\NightAllowanceDepartment;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class NightAllowanceGenerate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $night_allowance_department_id;
    public $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($night_allowance_department_id, $data = null)
    {
        $this->night_allowance_department_id = $night_allowance_department_id;
        $this->data                          = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $night_allowance_department               = NightAllowanceDepartment::findOrFail($this->night_allowance_department_id);
        $nightAllowance                           = NightAllowance::findOrFail($night_allowance_department->night_allowance_id);
        writeToLog("Step 1:".$nightAllowance->title." Night Allowance Generate On-Queue ",'info');
        $nightAllowanceController                 = new NightAllowanceController();
        if ($this->data != null) {
            $nightAllowanceController->nightAllowanceGenerate($night_allowance_department,$this->data);
        } else {
//            $nightAllowanceController->generateNightAllowance($night_allowance_department);
        }

        writeToLog(" Step 2:".$nightAllowance->title." ".$night_allowance_department->title.  " Night Allowance Generate. Finished ",'info');
    }

    public function failed()
    {
        $night_allowance_department               = NightAllowanceDepartment::findOrFail($this->night_allowance_department_id);
        $nightAllowance                           = NightAllowance::findOrFail($night_allowance_department->night_allowance_id);
        $night_allowance_department->is_generated = 0;
        $night_allowance_department->waiting_job  = 0;
        $night_allowance_department->queue_status = 'Failed';
        $night_allowance_department->save();
        writeToLog($nightAllowance->title." ".$night_allowance_department->title.  " Night Allowance Generate failed!",'error');
    }
}
