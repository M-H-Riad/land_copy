<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Traits\SmsApi;
use Log;
class SendSmsQ implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels,SmsApi;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $mobile_no;
    protected $sms;
    public function __construct($mobile_no,$sms)
    {
        //
        $this->mobile_no = $mobile_no;
        $this->sms = $sms;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        try {
           // Log::error('Hello-'.$this->mobile_no.'-'.$this->sms);
            $this->sendCustomMessageBn($this->mobile_no, $this->sms);
            \DB::table('send_sms_no')->insert(['no' => $this->mobile_no,'date_time' => date('Y-m-d H:i:s')]);
        } catch(\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
