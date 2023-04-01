<?php

Route::group(['module' => 'BankBranch', 'middleware' => ['api'], 'namespace' => 'App\Modules\BankBranch\Controllers'], function() {

    Route::resource('BankBranch', 'BankBranchController');

});
