<?php


    Route::group(['module' => 'DeepTubewell', 'prefix' => 'deep-tubewell', 'middleware' => ['web', 'auth', 'auditTrails'], 'namespace' => 'App\Modules\DeepTubewell\Controllers'], function () {

    // Route::any('deep-tubewell-list', 'DeepTubewellController@index');
    Route::resource('deep-tubewell', 'DeepTubewellController');
    Route::post('get-source', 'DeepTubewellController@getAllSource')->name('get-source');
    Route::resource('source-type', 'SourceTypeController');

    Route::get('create-source-type', 'SourceTypeController@create_by_ajax')->name('source_type.create-ajax');

    Route::get('log-report', 'LogReportController@logReport');
    Route::get('log-report/delete/{id}', 'LogReportController@logDelete');
    Route::get('log-report/destroy/{id}', ['as' => 'log.destroy', 'uses' => 'LogReportController@destroy']);

});   