<?php

Route::group(['module' => 'LoanManagement', 'middleware' => ['api'], 'namespace' => 'App\Modules\LoanManagement\Controllers'], function() {

    Route::resource('LoanManagement', 'LoanManagementController');

});
