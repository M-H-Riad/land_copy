<?php

/**
 *    PensionApplication Helper
 */
function bnNumberFormat($number)
{
    return (new App\Library\Currency())->get_bd_money_format($number, true);
}

function bnNumberText($number)
{
    return (new App\Library\Currency())->get_bd_amount_in_text($number);
}

function deiffBetweenTwoDate($date1, $date2)
{

    $date1 = date_create($date1);
    $date2 = date_create($date2);
    return date_diff($date1, $date2);
}

function pensionAdminApprove()
{
    return \App\Modules\PensionApplication\Models\PensionApplicationAuthor::where('application_step', 1)->where('status', 1)->count();
}
