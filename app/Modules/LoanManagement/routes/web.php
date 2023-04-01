<?php

Route::group(['module' => 'LoanManagement', 'middleware' => ['web','auth','auditTrails','permission:manage_loan_application'], 'namespace' => 'App\Modules\LoanManagement\Controllers'], function() {

//    Route::get('loan-application/create', 'LoanApplicationHBController@create')->name('loan.hb.create')->middleware('permission:manage_loan_application');
//
//    Route::get('loan-application/show/{id}', 'LoanApplicationHBController@show')->name('loan.hb.show')->middleware('permission:manage_loan_application');
//    Route::post('loan-application/house-building/store', 'LoanApplicationHBController@store')->name('loan.hb.store')->middleware('permission:manage_loan_application');
    Route::post('loan-application/storeInstallment', 'LoanApplicationController@storeInstallment');
//    Route::get('loan-application/house-building/one-time-deposit/{id}', 'LoanApplicationHBController@show')->name('loan.hb.otd')->middleware('permission:manage_loan_application');
//    Route::post('loan-application/house-building/one-time-deposit/{id}', 'LoanApplicationHBController@oneTimeDepositSubmit')->name('loan.hb.otds')->middleware('permission:manage_loan_application');
    Route::post('loan-application/one-time-deposit/{id}', 'LoanApplicationController@oneTimeDepositSubmit')->name('loan.otd');

//    Route::get('loan-application/{category}', 'LoanApplicationController@create')->middleware('permission:manage_loan_application');
//
    Route::put('loan-application/update-monthly-deduction/{id}', 'LoanApplicationController@UpdateMonthlyDeduction')->name('loan.update-monthly-deduction');


    /**
     * Reports
     *
     */
    Route::get('loan-application/export-pdf', 'ExportController@getLoanListPdf')->name('loan-application.export-pdf')->middleware('permission:manage_loan_application');
    Route::get('loan-application/export-ledger-pdf', 'ExportController@getLedgerPdf')->name('loan-application.export-ledger-pdf')->middleware('permission:manage_loan_application');
    Route::get('loan-application/export-ledger-pdf/{id}', 'ExportController@getSingleLedgerPdf')->name('loan-application.export-single-ledger-pdf');
    Route::get('loan-application/export-ledger-csv/{id}', 'ExportController@getSingleLedgerCsv')->name('loan-application.export-single-ledger-csv');
    Route::get('loan-application/loan-info/{id}', 'ExportController@getLoanInfo')->name('loan-application.export-loan-info');



    Route::resource('loan-interest', 'LoanInterestController')->middleware('permission:manage_loan_interest');
    Route::resource('loan-category', 'LoanCategoryController')->middleware('permission:manage_loan_category');

    Route::resource('loan-application', 'LoanApplicationController');

    Route::get('loan-application/settlement/{id}', 'LoanManagementController@settlementFrom')->name('loan-settlement.from');
    Route::put('loan-application/settlement/{id}', 'LoanManagementController@settlement')->name('loan-application.settlement');
    Route::post('loan-application/deposit-settlement/{id}', 'LoanManagementController@depositSettlement')->name('loan-application.deposit_settlement');
    Route::put('loan-application/edit-deposit/{id}', 'LoanManagementController@editDeposit')->name('loan-application.edit_deposit');
    Route::delete('loan-application/edit-deposit/{id}', 'LoanManagementController@deleteDeposit')->name('loan-application.delete_deposit');

    Route::get('loan-application/generate_settlement/{id}', 'LoanManagementController@generateSettlement')->name('loan-application.generate_settlement');

    Route::get('loan-application/adjust/{id}', 'LoanManagementController@adjustLoan')->name('adjust.loan');
    Route::post('loan-application/adjust/{id}', 'LoanManagementController@adjustLoanStore')->name('adjust_loan.store');
});
