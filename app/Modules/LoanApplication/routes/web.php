<?php

Route::group(['module' => 'LoanApplication', 'middleware' => ['web','auth'], 'prefix' => 'loan', 'namespace' => 'App\Modules\LoanApplication\Controllers'], function() {

    // Start application step-1

    // Create loan
    Route::get('loan-application', 'LoanApplicationController@index')->name('loan.application.index')->middleware('permission:loan_application');
    Route::get('loan-application/search', 'LoanApplicationController@search')->name('search.create.application')->middleware('permission:loan_application');
    Route::get('loan-application/create/{employee_id}', 'LoanApplicationController@create')->name('loan.create.application')->middleware('permission:loan_application');
    Route::post('store-loan-application/{employee_id}', 'LoanApplicationController@store')->name('loan.store.application')->middleware('permission:loan_application');
    Route::get('loan-application-details/{loadId}', 'LoanApplicationController@show')->name('loan.application.show')->middleware('permission:loan_application');
    Route::get('loan-application-edit/{loadId}', 'LoanApplicationController@edit')->name('loan.application.edit')->middleware('permission:loan_application');
    Route::put('update-loan-application/{loanId}', 'LoanApplicationController@update')->name('loan.application.update')->middleware('permission:loan_application');
    Route::put('withdraw-loan-application/{loanId}', 'LoanApplicationController@withdraw')->name('loan.application.withdraw')->middleware('permission:loan_application');
    Route::get('waiting-loan-application', 'ApplicationApprovalController@application_list')->name('loan.application.waiting');
    Route::get('waiting-loan-application/{id}', 'ApplicationApprovalController@show')->name('loan.application.waiting.show');
    Route::put('loan-application-approve/{id}', 'ApplicationApprovalController@approve_loan')->name('loan.application.approve');
    Route::put('loan-application-reject/{id}', 'ApplicationApprovalController@reject_loan')->name('loan.application.reject');
    Route::put('loan-application-comment/{id}', 'ApplicationApprovalController@store_comment')->name('loan.application.comment');
    Route::put('loan-application-reply/{id}', 'ApplicationApprovalController@store_reply')->name('loan.application.reply');
    Route::get('loan-application-export', 'ApplicationApprovalController@exportLoan')->name('loan.application.export');
    Route::get('loan-application-office-order-pdf', 'ApplicationApprovalController@officeOrder')->name('loan.application.office.order.pdf');
    Route::post('loan-application-office-order-pdf', 'ApplicationApprovalController@officeOrder')->name('loan.application.office.order.pdf');
    Route::post('loan-application-office-order-approve', 'ApplicationApprovalController@appreoveOfficeOrder')->name('loan.application.office.order.approve');
    Route::get('loan-application-pdf/{id}', 'ApplicationApprovalController@pdf')->name('loan.application.pdf');

    // Witness and guarantor
    Route::group([ 'prefix' => 'witness-guarantor'], function() {

        Route::get('waiting-loans', 'WaitingLoan\WitnessAndGuarantor\WaitingApprovalLoanController@waitingApprovalLoans')->name('loan.application.witness_guarantor.waiting_loan')->middleware('permission:loan_application_approve');
        Route::put('status-update', 'WaitingLoan\WitnessAndGuarantor\WaitingApprovalLoanController@updateStatus')->name('loan.application.witness_guarantor.update_status')->middleware('permission:loan_application_approve');
        Route::get('application-details/{loadId}', 'WaitingLoan\WitnessAndGuarantor\WaitingApprovalLoanController@show')->name('loan.application.witness_guarantor.show')->middleware('permission:loan_application_approve');

    });
    // HOD
    Route::group([ 'prefix' => 'hod'], function() {

        Route::get('waiting-loans', 'WaitingLoan\HOD\HODWaitingLoanController@index')->name('loan.application.hod.waiting_loan');
        Route::put('status-update', 'WaitingLoan\HOD\HODWaitingLoanController@updateStatus')->name('loan.application.hod.update_status');
        Route::get('application-details/{loadId}', 'WaitingLoan\HOD\HODWaitingLoanController@show')->name('loan.application.hod.show');

    });
    // Admin
    Route::group([ 'prefix' => 'admin'], function() {

        Route::get('waiting-loans', 'WaitingLoan\Admin\AdminWaitingLoanController@index')->name('loan.application.admin.waiting_loan')->middleware('permission:manage_all_loan_applications');
        Route::put('status-update', 'WaitingLoan\Admin\AdminWaitingLoanController@updateStatus')->name('loan.application.admin.update_status')->middleware('permission:manage_all_loan_applications');
        Route::get('application-details/{loadId}', 'WaitingLoan\Admin\AdminWaitingLoanController@show')->name('loan.application.admin.show')->middleware('permission:manage_all_loan_applications');

    });

    // Committee
    Route::group([ 'prefix' => 'committee'], function() {

        Route::get('waiting-loans', 'WaitingLoan\Committee\CommitteeWaitingLoanController@index')->name('loan.application.committee.waiting_loan')->middleware('permission:committee_manage_all_loan_applications');
        Route::put('status-update', 'WaitingLoan\Committee\CommitteeWaitingLoanController@updateStatus')->name('loan.application.committee.update_status')->middleware('permission:committee_manage_all_loan_applications');
        Route::get('application-details/{loadId}', 'WaitingLoan\Committee\CommitteeWaitingLoanController@show')->name('loan.application.committee.show')->middleware('permission:committee_manage_all_loan_applications');

    });
    // AS user
    Route::group([ 'prefix' => 'as-user'], function() {

        Route::get('waiting-loans', 'WaitingLoan\ASUser\ASWaitingLoanController@index')->name('loan.application.as_user.waiting_loan')->middleware('permission:as_user_manage_all_loan_applications');
        Route::put('status-update', 'WaitingLoan\ASUser\ASWaitingLoanController@updateStatus')->name('loan.application.as_user.update_status')->middleware('permission:as_user_manage_all_loan_applications');
        Route::get('application-details/{loadId}', 'WaitingLoan\ASUser\ASWaitingLoanController@show')->name('loan.application.as_user.show')->middleware('permission:as_user_manage_all_loan_applications');

    });

    // DS user
    Route::group([ 'prefix' => 'ds-user'], function() {

        Route::get('waiting-loans', 'WaitingLoan\DSUser\DSWaitingLoanController@index')->name('loan.application.ds_user.waiting_loan')->middleware('permission:ds_user_manage_all_loan_applications');
        Route::put('status-update', 'WaitingLoan\DSUser\DSWaitingLoanController@updateStatus')->name('loan.application.ds_user.update_status')->middleware('permission:ds_user_manage_all_loan_applications');
        Route::get('application-details/{loadId}', 'WaitingLoan\DSUser\DSWaitingLoanController@show')->name('loan.application.ds_user.show')->middleware('permission:ds_user_manage_all_loan_applications');

    });

    // Secretary user
    Route::group([ 'prefix' => 'secretary'], function() {

        Route::get('waiting-loans', 'WaitingLoan\Secretary\SecretaryWaitingLoanController@index')->name('loan.application.secretary.waiting_loan')->middleware('permission:secretary_manage_all_loan_applications');
        Route::put('status-update', 'WaitingLoan\Secretary\SecretaryWaitingLoanController@updateStatus')->name('loan.application.secretary.update_status')->middleware('permission:secretary_manage_all_loan_applications');
        Route::get('application-details/{loadId}', 'WaitingLoan\Secretary\SecretaryWaitingLoanController@show')->name('loan.application.secretary.show')->middleware('permission:secretary_manage_all_loan_applications');

    });
    // MD user
    Route::group([ 'prefix' => 'md'], function() {

        Route::get('waiting-loans', 'WaitingLoan\MD\MdWaitingLoanController@index')->name('loan.application.md.waiting_loan')->middleware('permission:md_manage_all_loan_applications');
        Route::put('status-update', 'WaitingLoan\MD\MdWaitingLoanController@updateStatus')->name('loan.application.md.update_status')->middleware('permission:md_manage_all_loan_applications');
        Route::get('application-details/{loadId}', 'WaitingLoan\MD\MdWaitingLoanController@show')->name('loan.application.md.show')->middleware('permission:md_manage_all_loan_applications');

    });
    // DMD user
    Route::group([ 'prefix' => 'dmd'], function() {

        Route::get('waiting-loans', 'WaitingLoan\DMD\DmdWaitingLoanController@index')->name('loan.application.dmd.waiting_loan')->middleware('permission:dmd_manage_all_loan_applications');
        Route::put('status-update', 'WaitingLoan\DMD\DmdWaitingLoanController@updateStatus')->name('loan.application.dmd.update_status')->middleware('permission:dmd_manage_all_loan_applications');
        Route::get('application-details/{loadId}', 'WaitingLoan\DMD\DmdWaitingLoanController@show')->name('loan.application.dmd.show')->middleware('permission:dmd_manage_all_loan_applications');

    });
    // committee setup
    Route::get('committee-setup', 'Committee\CommitteeSetupController@index')->name('loan.application.committee_setup.index')->middleware('permission:manage_loan_committee_setup');
    Route::post('committee-setup/store', 'Committee\CommitteeSetupController@store')->name('loan.application.committee_setup.store')->middleware('permission:manage_loan_committee_setup');
    Route::delete('committee-setup/delete', 'Committee\CommitteeSetupController@delete')->name('loan.application.committee.delete')->middleware('permission:manage_loan_committee_setup');


    // history route...
    Route::get('loan-approval-history', 'Analytics\History\LoanApprovalHistoryController@index')->name('loan.application.approval_history')->middleware('permission:loan_application_history');




});
