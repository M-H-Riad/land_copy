<?php

Route::group(['module' => 'PensionApplication', 'middleware' => ['api'], 'namespace' => 'App\Modules\PensionApplication\Controllers'], function() {

    Route::resource('PensionApplication', 'PensionApplicationController');

});
