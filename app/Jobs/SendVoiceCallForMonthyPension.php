<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Log;
use DB;
class SendVoiceCallForMonthyPension implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $mobile_no;

    public function __construct($mobile_no)
    {
        //
        $this->mobile_no = $mobile_no;
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
            //$reciver_no = $this->mobile_no;
            $reciver_no = $this->mobile_no;
            if(strlen($reciver_no) == 11){
                $reciver_no = "88".$reciver_no;
                $url = 'http://sms.sslwireless.com/ivrapi/wasaivr.php?msisdn='.$reciver_no.'&fileid=201805106789-wasa&csmsid=1234567890&sid=WASA&userid=wasa&password=wasa123';
                $ch = curl_init();
                curl_setopt($ch,CURLOPT_URL,$url);
                curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            //  curl_setopt($ch,CURLOPT_HEADER, false);
                $output=curl_exec($ch);

                if(!curl_error($ch))
                {
                    $response = explode('<status>',$output);
                    $response = explode('</status>',$response[1]);
                    \DB::table('send_voice_call')->insert(['no' => $reciver_no,'date_time' => date('Y-m-d H:i:s'),'response' => $response[0]]);
                }
               else{
                    Log::error('curl error:' . curl_error($ch));
               }
                curl_close($ch);
            }
        } catch(\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
