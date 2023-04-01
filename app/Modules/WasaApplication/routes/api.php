<?php

Route::group(['module' => 'WasaApplication', 'middleware' => ['api'], 'namespace' => 'App\Modules\WasaApplication\Controllers'], function() {

    Route::resource('WasaApplication', 'WasaApplicationController');

});
