<?php

Route::group(['module' => 'Leverage', 'middleware' => ['web','auth'], 'namespace' => 'App\Modules\Leverage\Controllers'], function() {


    Route::post('leverage/distribution/create', 'LeverageDistributionController@create');
    Route::get('leverage/distribution/download-excel/{id}', 'LeverageDistributionController@downloadExcel')->name('distribution.excel');
    Route::resource('leverage/distribution', 'LeverageDistributionController');
    Route::resource('leverage/product', 'LeverageProductController');

    Route::resource('Leverage', 'LeverageController');

});
