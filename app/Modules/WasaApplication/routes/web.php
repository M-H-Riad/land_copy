<?php

Route::group(['module' => 'WasaApplication','prefix'=>'wasa-application', 'middleware' => ['web','auth','auditTrails','permission:manage_scholarship'], 'namespace' => 'App\Modules\WasaApplication\Controllers'], function() {

    Route::get('scholarship/download-excel','ScholarshipController@downloadExcel');
    Route::resource('scholarship', 'ScholarshipController');
    Route::resource('treatment', 'TreatmentController');
    
    Route::get('application-setting/load-form/{id}','ApplicationSettings@loadForm');



    Route::resource('application-setting', 'ApplicationSettings');

});
