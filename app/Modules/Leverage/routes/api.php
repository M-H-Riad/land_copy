<?php

Route::group(['module' => 'Leverage', 'middleware' => ['api'], 'namespace' => 'App\Modules\Leverage\Controllers'], function() {

    Route::resource('Leverage', 'LeverageController');

});
