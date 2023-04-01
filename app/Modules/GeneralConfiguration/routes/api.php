<?php

Route::group(['module' => 'GeneralConfiguration', 'middleware' => ['api'], 'namespace' => 'App\Modules\GeneralConfiguration\Controllers'], function() {

    Route::resource('GeneralConfiguration', 'GeneralConfigurationController');

});
