<?php

Route::group(['module' => 'EmployeeProfile', 'middleware' => ['api'], 'namespace' => 'App\Modules\EmployeeProfile\Controllers'], function() {

    Route::resource('EmployeeProfile', 'EmployeeProfileController');

});
