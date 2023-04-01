<?php

namespace App\Library;

class Currency
{
  function __construct()
  {
  }

  // http://www.phpbuilder.com/board/showthread.php?t=10350901
  function get_bd_money_format($amount, $translateToBengali = false)
  {
    $output_string = '';
    $fraction = '';
    $tokens = explode('.', $amount);
    $number = $tokens[0];
    if(count($tokens) > 1)
    {
      $fraction = (double)('0.' . $tokens[1]);
      $fraction = $fraction * 100;
      $fraction = round($fraction, 0);
      $fraction = '.' . $fraction;
    }

    $number = $number . '';
    $spl=str_split($number);
    $lpcount=count($spl);
    $rem=$lpcount-3;

    //echo "rem".$rem."";

    //even one
    if($lpcount%2==0)
    {
      for($i=0;$i<=$lpcount-1;$i++)
      {

        if($i%2!=0 && $i!=0 && $i!=$lpcount-1)
        {
          $output_string .= ",";
        }
        $output_string .= $spl[$i];
      }
    }

    //odd one
    if($lpcount%2!=0)
    {
      for($i=0;$i<=$lpcount-1;$i++)
      {
        if($i%2==0 && $i!=0 && $i!=$lpcount-1)
        {
          $output_string .= ",";
        }
        $output_string .= $spl[$i];
      }
    }
    $str = $output_string . $fraction;

    if($translateToBengali)
    {
      return $this->en2bnNumber($str);
    }
    return $str;
  }

  private function en2bnNumber($number)
  {
    $replace_array = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
    $search_array = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
    $en_number = str_replace($search_array, $replace_array, $number);
    return $en_number;
  }

  // http://efreedom.com/Question/1-3181945/Convert-Money-Text-PHP
  function translate_to_words($number)
  {
    /*****
    * A recursive function to turn digits into words
    * Numbers must be integers from -999,999,999,999 to 999,999,999,999 inclussive.
    *
    * (C) 2010 Peter Ajtai
    * This program is free software: you can redistribute it and/or modify
    * it under the terms of the GNU General Public License as published by
    * the Free Software Foundation, either version 3 of the License, or
    * (at your option) any later version.
    *
    * This program is distributed in the hope that it will be useful,
    * but WITHOUT ANY WARRANTY; without even the implied warranty of
    * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
    * GNU General Public License for more details.
    *
    * See the GNU General Public License: <http://www.gnu.org/licenses/>.
    *
    */
    // zero is a special case, it cause problems even with typecasting if we don't deal with it here

    $max_size = pow(10,18);

    if (!$number) return "শূন্য";

    if (is_int($number) && $number < abs($max_size))
    {
      $prefix = '';
      $suffix = '';

      switch ($number)
      {
        // set up some rules for converting digits to words
        case $number < 0:
          $prefix = "ঋণাত্মক";
          $suffix = $this->translate_to_words(-1*$number);
          $string = $prefix . " " . $suffix;
          break;

        case 1:
          $string = "এক";
          break;
        case 2:
          $string = "দুই";
          break;
        case 3:
          $string = "তিন";
          break;
        case 4:
          $string = "চার";
          break;
        case 5:
          $string = "পাঁচ";
          break;
        case 6:
          $string = "ছয়";
          break;
        case 7:
          $string = "সাত";
          break;
        case 8:
          $string = "আট";
          break;
        case 9:
          $string = "নয়";
          break;
        case 10:
          $string = "দশ";
          break;
        case 11:
          $string = "এগারো";
          break;
        case 12:
          $string = "বারো";
          break;
        case 13:
          $string = "তেরো";
          break;

        case 14:
          $string = "চৌদ্দ";
          break;

        // fourteen handled later
        case 15:
          $string = "পনেরো";
          break;

        case 16:
          $string = "ষোল";
          break;

        case 17:
          $string = "সতেরো";
          break;

        case 18:
          $string = "আঠারো";
          break;

        case 19:
          $string = "উনিশ";
          break;

        case 20:
          $string = "বিশ";
          break;



        case 21:
          $string = "একুশ";
          break;

        case 22:
          $string = "বাইশ";
          break;

        case 23:
          $string = "তেইশ";
          break;

        case 24:
          $string = "চব্বিশ";
          break;

        case 25:
          $string = "পঁচিশ";
          break;
        case 26:
          $string = "চব্বিশ";
          break;
        case 27:
          $string = "সাতাশ";
          break;
        case 28:
          $string = "আটাশ";
          break;
        case 29:
          $string = "ঊনত্রিশ";
          break;
        case 30:
          $string = "ত্রিশ";
          break;

          case 31:
          $string = "একত্রিশ";
          break;

          case 32:
          $string = "বত্রিশ";
          break;

          case 33:
          $string = "তেত্রিশ";
          break;

          case 34:
          $string = "চৌত্রিশ";
          break;
          case 35:
          $string = "পঁয়ত্রিশ";
          break;
          case 36:
          $string = "ছত্রিশ";
          break;
          case 37:
          $string = "সাঁইত্রিশ";
          break;
          case 38:
          $string = "আটত্রিশ";
          break;
          case 39:
          $string = "ঊনচল্লিশ";
          break;
          case 40:
          $string = "চল্লিশ";
          break;

          case 41:
          $string = "একচল্লিশ";
          break;
          case 42:
          $string = "বিয়াল্লিশ";
          break;
          case 43:
          $string = "তেতাল্লিশ";
          break;
          case 44:
          $string = "চুয়াল্লিশ";
          break;
          case 45:
          $string = "পঁয়তাল্লিশ";
          break;
          case 46:
          $string = "ছেচল্লিশ";
          break;
          case 47:
          $string = "সাতচল্লিশ";
          break;
          case 48:
          $string = "আটচল্লিশ";
          break;
          case 49:
          $string = "ঊনপঞ্চাশ";
          break;
          case 50:
          $string = "পঞ্চাশ";
          break;


          case 51:
          $string = "একান্ন";
          break;

          case 52:
          $string = "বায়ান্ন";
          break;

          case 53:
          $string = "তিপ্পান্ন";
          break;

          case 54:
          $string = "চুয়ান্ন";
          break;
          case 55:
          $string = "পঞ্চান্ন";
          break;
          case 56:
          $string = "ছাপ্পান্ন";
          break;
          case 57:
          $string = "সাতান্ন";
          break;
          case 58:
          $string = "আটান্ন";
          break;
          case 59:
          $string = "ঊনষাট";
          break;
          case 60:
          $string = "ষাট";
          break;



          case 61:
          $string = "একষট্টি";
          break;

          case 62:
          $string = "বাষট্টি";
          break;

          case 63:
          $string = "তেষট্টি";
          break;

          case 64:
          $string = "চৌষট্টি";
          break;
          case 65:
          $string = "পঁয়ষট্টি";
          break;
          case 66:
          $string = "ছেষট্টি";
          break;
          case 67:
          $string = "সাতষট্টি";
          break;
          case 68:
          $string = "আটষট্টি";
          break;
          case 69:
          $string = "ঊনসত্তর";
          break;
          case 70:
          $string = "সত্তর";
          break;



          case 71:
          $string = "একাত্তর";
          break;

          case 72:
          $string = "বাহাত্তর";
          break;

          case 73:
          $string = "তিয়াত্তর";
          break;

          case 74:
          $string = "চুয়াত্তর";
          break;
          case 75:
          $string = "পঁচাত্তর";
          break;
          case 76:
          $string = "ছিয়াত্তর";
          break;
          case 77:
          $string = "সাতাত্তর";
          break;
          case 78:
          $string = "আটাত্তর";
          break;
          case 79:
          $string = "ঊনআশি";
          break;
          case 80:
          $string = "আশি";
          break;

          case 81:
          $string = "একাশি";
          break;

          case 82:
          $string = "বিরাশি";
          break;

          case 83:
          $string = "তিরাশি";
          break;

          case 84:
          $string = "চুরাশি";
          break;
          case 85:
          $string = "পঁচাশি";
          break;
          case 86:
          $string = "ছিয়াশি";
          break;
          case 87:
          $string = "সাতাশি";
          break;
          case 88:
          $string = "আটাশি";
          break;
          case 89:
          $string = "ঊননব্বই";
          break;
          case 90:
          $string = "নব্বই";
          break;

          case 91:
          $string = "একানব্বই";
          break;

          case 92:
          $string = "বিরানব্বই";
          break;

          case 93:
          $string = "তিরানব্বই";
          break;

          case 94:
          $string = "চুরানব্বই";
          break;
          case 95:
          $string = "পঁচানব্বই";
          break;
          case 96:
          $string = "ছিয়ানব্বই";
          break;
          case 97:
          $string = "সাতানব্বই";
          break;
          case 98:
          $string = "আটানব্বই";
          break;
          case 99:
          $string = "নিরানব্বই";
          break;


        case $number < 100:
          $prefix = $this->translate_to_words($number-$number%10);
          $suffix = $this->translate_to_words($number%10);
          //$string = $prefix . "-" . $suffix;
          $string = $prefix . " " . $suffix;
          break;

          // handles all number 100 to 999
        case $number < pow(10,3):

          // floor return a float not an integer
          $prefix = $this->translate_to_words(intval(floor($number/pow(10,2)))) . " শত";

          if ($number%pow(10,2)) $suffix = " " . $this->translate_to_words($number%pow(10,2));
          $string = $prefix . $suffix;
          break;
        case $number < pow(10,6):
          // floor return a float not an integer
          $prefix = $this->translate_to_words(intval(floor($number/pow(10,3)))) . " হাজার";
          if ($number%pow(10,3)) $suffix = $this->translate_to_words($number%pow(10,3));
          $string = $prefix . " " . $suffix;
          break;
      }
    } else
    {
      echo "ERROR with - $number
          Number must be an integer between -" . number_format($max_size, 0, ".", ",") . " and " . number_format($max_size, 0, ".", ",") . " exclussive.";
    }

    return $string;
  }

  function get_bd_amount_in_text($amount)
  {
    $output_string = '';

    $tokens = explode('.', $amount);
    $current_amount = $tokens[0];
    $fraction = '';

    if(count($tokens) > 1)
    {
      $fraction = (double)('0.' . $tokens[1]);
      $fraction = $fraction * 100;
      $fraction = round($fraction, 0);
      $fraction = (int)$fraction;
      $fraction = $this->translate_to_words($fraction) . ' পয়সা';
      $fraction = ' টাকা ' . $fraction;
    }

    $crore = 0;

    if($current_amount >= pow(10,7))
    {
      $crore = (int)floor($current_amount / pow(10,7));
      $output_string .= $this->translate_to_words($crore) . ' কোটি ';
      $current_amount = $current_amount - $crore * pow(10,7);
    }

    $lakh = 0;
    if($current_amount >= pow(10,5))
    {
      $lakh = (int)floor($current_amount / pow(10,5));
      $output_string .= $this->translate_to_words($lakh) . ' লক্ষ ';
      $current_amount = $current_amount - $lakh * pow(10,5);
    }

    $current_amount = (int)$current_amount;
    $output_string .= $this->translate_to_words($current_amount);

    $output_string = $output_string . $fraction . ' মাত্র';
    $output_string = ucwords($output_string);

    return $output_string;
  }
}





/*
$currency_object = new Currency();

for($i=1; $i<10; $i++)
{
  $seed = time() / ($i + 1);
  srand($seed);
  $amount = mt_rand(100, 9999999);
  $amount = $amount + $i/10;
  echo $currency_object->get_bd_money_format($amount) . ' : ' . $currency_object->get_bd_amount_in_text($amount) . '
  ';
}
*/
