<?php
use Illuminate\Support\Facades\Auth;

/**
 * Replace the special character from Form Fields as a caption
 * @param $field
 * @return string
 */
function fieldLabel($field)
{
    $except = [
        'nid'           => 'National ID No',
        'employee_id'   => 'Employee ID No'
    ];
    if(array_key_exists($field, $except)){
        return $except[$field];
    }
    return ucwords(preg_replace('/[^a-zA-Z]|w*id\b/', ' ', $field));
}

/**
 * Reverse of FieldLabel Function
 * @param $string
 * @return mixed
 */
function clean($string)
{
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

    return strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', $string)); // Removes special chars.
}

/**
 * Load Json Data from Resource folder
 * File Path: resource/assets/json/$filename.json
 * @param $filename
 * @return ArrayObject
 * @throws Exception
 */
function loadJSON($filename)
{
    $path = resource_path() . "\assets\json\\${filename}.json"; // ie: /var/www/laravel/app/storage/json/filename.json
    if (!\File::exists($path)) {
        throw new Exception("Invalid File Path/Name(file: ${filename}.json)");
    }

    $file = File::get($path); // string

    // Verify Validate JSON?

    if(!isJson($file)){
        throw new Exception("Invalid File Content (file: ${filename}.json)");
    }
    // Your other Stuff
    return json_decode($file);
}

/**
 * Check the Json is valid or not
 * @param $jsonString
 * @return bool
 * @internal param $string
 */
function isJson($jsonString)
{
    json_decode($jsonString);
    return (json_last_error() == JSON_ERROR_NONE);
}

/**
 * Image Validation rules for general purpose image
 * @return string
 */
function commonImageValidator()
{
    return 'image|mimes:jpeg,bmp,png|dimensions:min_width=50,min_height=50,max_width=500,max_height=500';
}

function isStakeholder()
{
    return Auth::user()->stakeholder_id > 0;
}
function stakeholder_id()
{
    return Auth::user()->stakeholder_id;
}
function user_id()
{
    return Auth::user()->id;
}

/**
 * get the related users
 */
function getRelatedUserId(){
    return [Auth::user()->id,2];
}

/**
 * Amount in Words convert the amount into String/Word for money
 * @param $amount
 * @return string
 */
function amountInWords($amount)
{
    return $amount;
    $digit = new NumberFormatter("en", NumberFormatter::SPELLOUT);
    return ucwords($digit->format($amount));
}

/**
 *  Function:   convert_number
 *
 *  Description:
 *  Converts a given integer (in range [0..1T-1], inclusive) into
 *  alphabetical format ("one", "two", etc.)
 *
 * @int
 *
 * @param $number
 * @return string
 * @throws Exception
 */
function convert_number($number)
{
//    $decimal = floor($number);      // 1
//    $fraction = number($number - $decimal);
//    dd($fraction);

    if (($number < 0) || ($number > 999999999))
    {
        throw new Exception("Number is out of range");
    }
    $Kt = floor($number / 10000000); /* Koti */
    $number -= $Kt * 10000000;
    $Gn = floor($number / 100000);  /* lakh  */
    $number -= $Gn * 100000;
    $kn = floor($number / 1000);     /* Thousands (kilo) */
    $number -= $kn * 1000;
    $Hn = floor($number / 100);      /* Hundreds (hecto) */
    $number -= $Hn * 100;
    $Dn = floor($number / 10);       /* Tens (deca) */
    $n = $number % 10;               /* Ones */
    $res = "";
    if ($Kt)
    {
        $res .= convert_number($Kt) . " Crore ";
    }
    if ($Gn)
    {
        $res .= convert_number($Gn) . " Lakh";
    }
    if ($kn)
    {
        $res .= (empty($res) ? "" : " ") .
            convert_number($kn) . " Thousand";
    }
    if ($Hn)
    {
        $res .= (empty($res) ? "" : " ") .
            convert_number($Hn) . " Hundred";
    }
//    if ($fraction)
//    {
//        $res .= (empty($res) ? "" : " ") .
//            ' AND '.convert_number($fraction) . " Poisha";
//    }
    $ones = array("", "One", "Two", "Three", "Four", "Five", "Six",
        "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen",
        "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen",
        "Nineteen");
    $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty",
        "Seventy", "Eigthy", "Ninety");
    if ($Dn || $n)
    {
        if (!empty($res))
        {
            $res .= "  "; // and
        }
        if ($Dn < 2)
        {
            $res .= $ones[$Dn * 10 + $n];
        }
        else
        {
            $res .= $tens[$Dn];
            if ($n)
            {
                $res .= "-" . $ones[$n];
            }
        }
    }
    if (empty($res))
    {
        $res = "zero";
    }
    return $res;
}
function num2bangla($number)
{
    if (($number < 0) || ($number > 999999999))
    {
        return "নাম্বারটি অতিরিক্ত বড়";
    } elseif (!is_numeric($number))
    {
        return "বৈধ নাম্বার নয়";
    }
    $Kt = floor($number / 10000000); /* Koti */
    $number -= $Kt * 10000000;
    $Gn = floor($number / 100000);  /* lakh  */
    $number -= $Gn * 100000;
    $kn = floor($number / 1000);     /* Thousands (kilo) */
    $number -= $kn * 1000;
    $Hn = floor($number / 100);      /* Hundreds (hecto) */
    $number -= $Hn * 100;
    $Dn = floor($number / 10);       /* Tens (deca) */
    $n = $number % 10;               /* Ones */
    $res = "";
    if ($Kt)
    {
        $res .= num2bangla($Kt) . " কোটি ";
    }
    if ($Gn)
    {
        $res .= num2bangla($Gn) . " লাখ";
    }
    if ($kn)
    {
        $res .= (empty($res) ? "" : " ") .
            num2bangla($kn) . " হাজার";
    }
    if ($Hn)
    {
        $res .= (empty($res) ? "" : " ") .
            num2bangla($Hn) . " শত";
    }
    $hund = ["", "এক", "দুই", "তিন", "চার", "পাঁচ", "ছয়", "সাত", "আট", "নয়", "দশ",
        "এগার", "বার", "তের", "চৌদ্দ", "পনের", "ষোল", "সতের", "আঠার", "ঊনিশ", "বিশ",
        "একোশ", "বাইশ", "তেইশ", "চব্বিশ", "পঁচিশ", "ছাব্বিশ", "সাতাশ", "আঠাশ", "ঊনত্রিশ", "ত্রিশ",
        "একত্রিশ", "বত্রিশ", "তেত্রিশ", "চৌত্রিশ", "পয়ত্রিশ", "ছত্রিশ", "সতত্রিশ", "আটত্রিশ", "ঊনচল্লিশ", "চল্লিশ",
        "একচল্লিশ", "বেয়াল্লিশ", "তেতাল্লিশ", "চোয়াল্লিশ", "পঁয়তাল্লিশ", "ছেচল্লিশ", "সতচল্লিশ", "আটচল্লিশ", "ঊনপঞ্চাশ", "পঞ্চাশ",
        "একান্ন", "বাহান্ন", "তেপান্ন", "চোয়ান্ন", "পঁঞ্চান্ন", "ছাপ্পান্ন", "সাতান্ন", "আটান্ন", "ঊনষাট", "ষাট",
        "একষট্টি", "বাষট্টি", "তেষট্টি", "চৌষট্টি", "পঁয়ষট্টি", "ছেষট্টি", "সতাষট্টি", "আটষট্টি", "ঊনসত্তর", "সত্তর",
        "একাত্তর", "বাহাত্তর", "তেহাত্তর", "চোয়াত্তর", "পঁচাত্তর", "ছিয়াত্তর", "সাতাত্তর", "আটাত্তর", "ঊনআশি", "আশি",
        "একাশি", "বিরাশি", "তিরাশি", "চোরাশি", "পঁচাশি", "ছিয়াশি", "সাতাশি", "অটাশি", "ঊননব্বই", "নব্বই",
        "একানব্বই", "বিরানব্বই", "তিরানব্বই", "চুরানব্বই", "পঁচানব্বই", "ছিয়ানব্বই", "সাতানব্বই", "আটানব্বই", "নিরানব্বই", "একশ"];
    if ($Dn || $n)
    {
        if (!empty($res))
        {
            $res .= " ";
        }
        $res .= $hund[$Dn * 10 + $n];
    }
    if (empty($res))
    {
        $res = "শূন্য";
    }
    return $res;
}
//$chequeNow = 87474840;
//echo $chequeNow ." = ". num2bangla($chequeNow);
if (!function_exists('writeToLog')) {

    function writeToLog($logMessage, $logType = 'error')
    {
        try {
            $allLogTypes = ['alert', 'critical', 'debug', 'emergency', 'error', 'info'];
            $logType = strtolower($logType);
            if (in_array($logType, $allLogTypes)) {
                \Illuminate\Support\Facades\Log::{$logType}($logMessage);
            } else {
                \Illuminate\Support\Facades\Log::debug($logMessage);
            }
        } catch (\Exception $exception) {
            //
        }
    }
}

function bn2en($number) {
    $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
    $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
    return str_replace($bn, $en, $number);

}

function en2bn($number) {
    $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
    $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
    return str_replace($en, $bn, $number);
}