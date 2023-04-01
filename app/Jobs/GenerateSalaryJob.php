<?php

namespace App\Jobs;

use App\Modules\Payroll\Controllers\PayrollController;
use App\Modules\Payroll\Models\PayrollMonth;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class GenerateSalaryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $requestData;
    public $month_id;

    /**
     * Create a new job instance.
     *
     * @param $month_id
     */
    public function __construct($month_id)
    {
        $this->month_id = $month_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        //Log::info("  Step 1: Salary Generate On-Queue ");
        writeToLog("Step 1: Salary Generate On-Queue ",'info');
        $payroll = new PayrollController();
        $payroll->generateHeads($this->month_id);

     //   Log::info("  Step 4: Salary Gen. Finished ");
        writeToLog(" Step 4: Salary Gen. Finished ",'info');
    }

    public function failed()
    {
        $monthData               = PayrollMonth::findOrFail($this->month_id);
        $monthData->is_generated = 0;
        $monthData->waiting_job  = 0;
        $monthData->queue_status = 'Failed';
        $monthData->save();

        //Log::error('Salary Generate failed!');
        writeToLog(" Salary Generate failed!",'error');
    }
}
