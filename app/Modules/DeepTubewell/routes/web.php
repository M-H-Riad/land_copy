<?php


    Route::group(['module' => 'DeepTubewell', 'prefix' => 'deep-tubewell', 'middleware' => ['web', 'auth', 'auditTrails'], 'namespace' => 'App\Modules\DeepTubewell\Controllers'], function () {

    // Route::any('deep-tubewell-list', 'DeepTubewellController@index');
    Route::resource('deep-tubewell', 'DeepTubewellController');
    Route::post('get-source', 'DeepTubewellController@getAllSource')->name('get-source');
    Route::resource('source-type', 'SourceTypeController');

});   