<?php

function getCountryList() {
    return ['' => 'Select Country'] + \App\Modules\Location\Models\Country::where('status', 1)->pluck('name', 'name')->all();
}

function getPrlDate($date, $type = 'General') {
    $d = changeDateFormatToDb($date);

    $dt = Carbon\Carbon::parse($d);

    //dd($dt);

    $prl = \App\Modules\GeneralConfiguration\Models\PrlSettings::where('status', 1)->where('title', $type)->first();
 
    if (count($prl) > 0) {
        $prlYear = $dt->addYears($prl->prl_age)->subDay(1)->format('Y-m-d');

        $pensionYear = $dt->addYear()->format('Y-m-d');

        return ['prl_year' => $prlYear, 'pension_year' => $pensionYear];
    } else {
        return ['prl_year' => null, 'pension_year' => null];
    }
}
