<?php
/**
 * Created by PhpStorm.
 * User: Mahmudul Alam
 * Date: 9/18/2016
 * Time: 1:53 PM
 */

namespace App\Traits;


use Illuminate\Support\Facades\Log;

trait SmsApi
{
    /**
     * Send OTP SMS to user mobile no.
     *
     * @param $msisdn
     * @param $OTP
     * @param $additionalMessage
     */
    public function sendOTP($msisdn, $OTP, $additionalMessage = "")
    {
//        $otpMessage = $additionalMessage.'Your OTP is: '.$OTP;
//
//        $curl = curl_init();
//        curl_setopt_array(
//            $curl,
//            array(
//                CURLOPT_RETURNTRANSFER => 1,
//                CURLOPT_URL => 'http://sms.sslwireless.com/pushapi/dynamic/server.php?user='.env('SMS_USER').'&pass='.env('SMS_PASSWORD').'&sid='.env('SMS_STAKEHOLDER').'&sms='.urlencode($otpMessage).'&msisdn='.$msisdn.'&csmsid=123456789',
//                CURLOPT_USERAGENT => 'Sample cURL Request' )
//        );
//
//        $resp = curl_exec($curl);
//        curl_close($curl);
//        Log::info($resp);
    }

    /**
     * Send custom SMS to user mobile no.
     *
     * @param $msisdn
     * @param $sms
     */
    public function sendCustomMessage($msisdn, $sms)
    {

        //$sms=strtoupper(bin2hex(iconv('UTF-8', 'UCS-2BE', $sms)));
        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => 'http://sms.sslwireless.com/pushapi/dynamic/server.php?user='.config('app.sms_user').'&pass='.config('app.sms_password').'&sid='.config('app.sms_sid').'&sms='.urlencode($sms).'&msisdn='.$msisdn.'&csmsid=123456789',
                CURLOPT_USERAGENT => 'Sample cURL Request'
                )
            );

        $resp = curl_exec($curl);
        curl_close($curl);
        Log::info($resp);
    }
    public function sendCustomMessageBn($msisdn, $sms)
    {

        $sms=strtoupper(bin2hex(iconv('UTF-8', 'UCS-2BE', $sms)));
        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => 'http://sms.sslwireless.com/pushapi/dynamic/server.php?user='.config('app.sms_user_bn').'&pass='.config('app.sms_password_bn').'&sid='.config('app.sms_sid_bn').'&sms='.urlencode($sms).'&msisdn='.$msisdn.'&csmsid=889977',
                CURLOPT_USERAGENT => 'Sample cURL Request'
                )
            );

        $resp = curl_exec($curl);
        curl_close($curl);
        Log::info($resp);
    }
    public function sendBulkSms($sms)
    {

        // $url="http://sms.sslwireless.com/pushapi/dynamic/server.php"; $param="user=".config('app.sms_user')."&pass=".config('app.sms_password')."&sms[0][0]= 880XXXXXXXXXX &sms[0][1]=".urlencode("Test SMS 1")."&sms[0][2]=123456789&sms[1][0]= 880XXXXXXXXXX &sms[1][1]=".urlencode("Test SMS &2")."&sms[1][2]=123456790&sid=".config('app.sid');

        $url="http://sms.sslwireless.com/pushapi/dynamic/server.php";
        $param="user=".config('app.sms_user')."&pass=".config('app.sms_password')."$sms&sid=".config('app.sms_sid');
        $crl = curl_init();
        curl_setopt($crl,CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($crl,CURLOPT_SSL_VERIFYHOST,2);
        curl_setopt($crl,CURLOPT_URL,$url);
        curl_setopt($crl,CURLOPT_HEADER,0);
        curl_setopt($crl,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($crl,CURLOPT_POST,1);
        curl_setopt($crl,CURLOPT_POSTFIELDS,$param);
        $response = curl_exec($crl);
        curl_close($crl);
        Log::info($response);
    }
}