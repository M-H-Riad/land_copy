<?php

Route::group(['module' => 'Payroll', 'middleware' => ['api'], 'namespace' => 'App\Modules\Payroll\Controllers'], function() {

    Route::resource('Payroll', 'PayrollController');

});
