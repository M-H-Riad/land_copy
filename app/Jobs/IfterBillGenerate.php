<?php

namespace App\Jobs;

use App\Modules\Payroll\Controllers\IfterBillController;
use App\Modules\Payroll\Models\IfterBill;
use App\Modules\Payroll\Models\IfterBillDepartment;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class IfterBillGenerate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $ifter_bill_department_id;
    public $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($ifter_bill_department_id,$data)
    {
        $this->ifter_bill_department_id = $ifter_bill_department_id;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $ifterBillDepartment           = IfterBillDepartment::findOrFail($this->ifter_bill_department_id);
        $ifterBill                     = IfterBill::findOrFail($ifterBillDepartment->ifter_bill_id);
        writeToLog("Step 1:".$ifterBill->title." Ifter Bill Generate On-Queue ",'info');
        $ifterBillController           = new IfterBillController();
        if($this->data != null){
            $ifterBillController->ifterBillGenerate($ifterBillDepartment,$this->data);
        }else {
//            $ifterBillController->generateIfterBill($ifterBillDepartment);
        }
        writeToLog(" Step 2:".$ifterBill->title.' '.$ifterBillDepartment->title ." Ifter Bill Generate. Finished ",'info');
    }

    public function failed()
    {
        $ifterBillDepartment               = IfterBillDepartment::findOrFail($this->ifter_bill_department_id);
        $ifterBill                         = IfterBill::findOrFail($ifterBillDepartment->ifter_bill_id);
        $ifterBillDepartment->is_generated = 0;
        $ifterBillDepartment->waiting_job  = 0;
        $ifterBillDepartment->queue_status = 'Failed';
        $ifterBillDepartment->save();
        writeToLog($ifterBill->title.' '.$ifterBillDepartment->title ." Ifter Bill Generate failed!",'error');
    }
}
