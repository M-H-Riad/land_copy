<?php

namespace App\Http\Controllers;

use App\Modules\Pension\Models\PensionMonthly;
use Illuminate\Http\Request;
use Excel;
use Log;
use DB;

class RunTestScriptController extends Controller
{
    //
    public function uniToBan($uni_str)
    {
        //$uni_str = "0985099509CD099F09CB09AC09B0002009E809E609E709EE002009AA09B009CD09AF09A809CD09A4002009AA09C709A809B609A8002F098509A809CD09AF09BE09A809CD09AF002009AD09BE09A409BE09A609BF002009AC09BE09AC09A6002009E809E609E609E60020099F09BE099509BE0020098609AA09A809BE09B0002009AC09CD09AF09BE09820995002009B909BF09B809C709AC09C70020099C09AE09BE002009B909DF09C7099B09C70964000A002D002D09A209BE099509BE0020099309DF09BE09B809BE";

        $All = "";
        for ($i = 0; $i < strlen($uni_str); $i += 4) {
            $new = "&#x" . substr($uni_str, $i, 4) . ";";
            $txt = html_entity_decode("$new", ENT_COMPAT, "UTF-8");
            $All .= $txt;
        }

        return $All;
    }

    public function scriptWiseSmsCheck($month, $year, $mobile_no)
    {
        $net_payable_amount = 2000.00;
        $date = engDateToBanDate(date('F Y', strtotime('01-' . $month . '-' . $year)));

        $smsBody = $date . " পর্যন্ত পেনশন/অন্যান্য ভাতাদি বাবদ " . engToBanNumber($net_payable_amount) . " টাকা আপনার ব্যাংক হিসেবে জমা হয়েছে।\n--ঢাকা ওয়াসা";
        //$smsBodyBan = strtoupper(bin2hex(iconv('UTF-8', 'UCS-2BE', $smsBody)));
        $smsBodyBan = $smsBody;
        //return $smsBodyBan;
        $mobileNo = $mobile_no;
        /* update the status to paid */
        $this->dispatch((new \App\Jobs\SendSmsQ($mobileNo, $smsBodyBan))); // Set queue for send sms
        //$this->dispatch((new \App\Jobs\SendVoiceCallForMonthyPension($mobileNo))); //
        dd('done');

    }

    public function index()
    {
        $month = '11';
        $year = '2018';
        $date = engDateToBanDate(date('F Y', strtotime('01-' . $month . '-' . $year)));
        $testData = [
            [
                'net_payable_amount' => 50000,
                'mobile_no' => '01670737698'
            ]
        ];
        foreach ($testData as $row) {
            $smsBody = $date . " পর্যন্ত পেনশন/অন্যান্য ভাতাদি বাবদ " . engToBanNumber($row['net_payable_amount']) . " টাকা আপনার ব্যাংক হিসেবে জমা হয়েছে।\n--ঢাকা ওয়াসা";
            //$smsBodyBan = strtoupper(bin2hex(iconv('UTF-8', 'UCS-2BE', $smsBody)));
            $smsBodyBan = $smsBody;
            $mobileNo = $row['mobile_no'];
            /* update the status to paid */
            $this->dispatch((new \App\Jobs\SendSmsQ($mobileNo, $smsBodyBan))); // Set queue for send sms
            $this->dispatch((new \App\Jobs\SendVoiceCallForMonthyPension($mobileNo))); // send voice call queue

        }

        die('check sms wasa');
        $reciver_no = "01722412196";
        $smsBodyBan = "জুন ২০১৮ পর্যন্ত পেনশন/অন্যান্য ভাতাদি বাবদ ৩০১০৬.৫০ টাকা আপনার ব্যাংক হিসেবে জমা হয়েছে। --ঢাকা ওয়াসা";
        $this->dispatch((new \App\Jobs\SendSmsQ($reciver_no, $smsBodyBan))); // Set queue for send sms
        $this->dispatch((new \App\Jobs\SendVoiceCallForMonthyPension($reciver_no)));
    }

    public function manual_excel($month, $year)
    {
        try {
            $date = engDateToBanDate(date('F Y', strtotime('01-' . $month . '-' . $year)));
            $excels = PensionMonthly::selectRaw("net_payable_amount,pension_fund_emp_id")
                ->whereYearOf($year)
                ->whereMonthOf($month)
                ->get();
            if ($excels) {
                $datas = null;
                $i = 0;
                foreach ($excels as $excel) {
                    $mobileNo = $excel->pension_fund_emp ? $excel->pension_fund_emp->mobile_no : null;
                    $ppo_no = $excel->pension_fund_emp ? $excel->pension_fund_emp->ppo_no : null;
                    $smsBody = $date . " পর্যন্ত পেনশন/অন্যান্য ভাতাদি বাবদ " . engToBanNumber($excel->net_payable_amount) . " টাকা আপনার ব্যাংক হিসেবে জমা হয়েছে।\n--ঢাকা ওয়াসা";
                    $datas[$i]['ppo_no'] = $ppo_no;
                    $datas[$i]['mobile_no'] = $mobileNo;
                    $datas[$i++]['sms'] = $smsBody;
                }
                if (!is_null($datas)) {
                    Excel::create('Pension Monthly - ' . date('Y-m-d'), function ($excel) use ($datas) {
                        $excel->sheet('Excel For Bank', function ($sheet) use ($datas) {
                            $sheet->setOrientation('landscape');
                            $sheet->fromArray($datas);
                        });
                    })->export('xls');
                } else {
                    dd('No data found with this month and year');
                }
            } else {
                dd('No data found with this month and year');
            }
        } catch (\Exception $e) {
            Log::error($e);
            dd('Something went wrong');
        }

    }
}
