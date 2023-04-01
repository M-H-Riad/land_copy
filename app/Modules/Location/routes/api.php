<?php

Route::group(['module' => 'Location', 'middleware' => ['api'], 'namespace' => 'App\Modules\Location\Controllers'], function() {

    Route::resource('Location', 'LocationController');

});
