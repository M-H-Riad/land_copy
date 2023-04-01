<?php

Route::group(['module' => 'Pension', 'middleware' => ['api'], 'namespace' => 'App\Modules\Pension\Controllers'], function() {

    Route::resource('Pension', 'PensionController');

});
