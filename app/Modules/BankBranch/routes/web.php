<?php

Route::group(['module' => 'BankBranch', 'middleware' => ['web','auth','permission:manage_bank_account','auditTrails'], 'namespace' => 'App\Modules\BankBranch\Controllers'], function() {

    Route::resource('bank', 'BankController');
    Route::resource('branch', 'BranchController');
    Route::resource('bank-branch', 'BankBranchController');

});
