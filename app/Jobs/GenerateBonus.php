<?php

namespace App\Jobs;

use App\Modules\Payroll\Controllers\BonusController;
use App\Modules\Payroll\Models\Bonus;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GenerateBonus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $bonus_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($bonus_id)
    {
        $this->bonus_id = $bonus_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $bonusData  = Bonus::findOrFail($this->bonus_id);
        writeToLog("Step 1:".$bonusData->title." Festival Bonus Generate On-Queue ",'info');
        $bonus      = new BonusController();
        $bonus->generateBonus($this->bonus_id);
        writeToLog(" Step 4:".$bonusData->title." Festival Bonus Generate. Finished ",'info');
    }

    public function failed()
    {
        $bonusData               = Bonus::findOrFail($this->bonus_id);
        $bonusData->is_generated = 0;
        $bonusData->waiting_job  = 0;
        $bonusData->queue_status = 'Failed';
        $bonusData->save();
        writeToLog($bonusData->title." Festival Bonus Generate failed!",'error');
    }
}
