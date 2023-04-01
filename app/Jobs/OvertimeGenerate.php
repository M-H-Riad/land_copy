<?php

namespace App\Jobs;

use App\Modules\Payroll\Controllers\OvertimeController;
use App\Modules\Payroll\Models\Overtime;
use App\Modules\Payroll\Models\OvertimeDepartment;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class OvertimeGenerate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $overtime_department_id;
    public $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($overtime_department_id, $data = null)
    {
        $this->overtime_department_id = $overtime_department_id;
        $this->data                   = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $overtime_department               = OvertimeDepartment::findOrFail($this->overtime_department_id);
        $overtime                          = Overtime::findOrFail($overtime_department->overtime_id);
        writeToLog("Step 1:".$overtime->title." ".$overtime_department->title.  " Overtime Generate On-Queue ",'info');
        $overtimeController                = new OvertimeController();
        if ($this->data != null){
            $overtimeController->overtimeGenerate($overtime_department,$this->data);
        }else {
//            $overtimeController->generateOvertime($overtime_department);
        }

        writeToLog(" Step 2:".$overtime->title." ".$overtime_department->title.  " Overtime Generate. Finished ",'info');
    }

    public function failed()
    {
        $overtime_department               = OvertimeDepartment::findOrFail($this->overtime_department_id);
        $overtime                          = Overtime::findOrFail($overtime_department->overtime_id);
        $overtime_department->is_generated = 0;
        $overtime_department->waiting_job  = 0;
        $overtime_department->queue_status = 'Failed';
        $overtime_department->save();
        writeToLog($overtime->title." ".$overtime_department->title.  " Overtime Generate failed!",'error');
    }
}
