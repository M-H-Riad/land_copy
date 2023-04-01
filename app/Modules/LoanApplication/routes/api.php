<?php

Route::group(['module' => 'LoanApplication', 'middleware' => ['api'], 'namespace' => 'App\Modules\LoanApplication\Controllers'], function() {

    Route::resource('LoanApplication', 'LoanApplicationController');

});
