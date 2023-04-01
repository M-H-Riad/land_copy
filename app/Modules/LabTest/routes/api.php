<?php

Route::group(['module' => 'LabTestResult', 'middleware' => ['api'], 'namespace' => 'App\Modules\LabTest\Controllers'], function() {

    Route::resource('LabTestResult', 'LabTestController');

});
