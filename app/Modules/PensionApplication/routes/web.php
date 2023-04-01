<?php

Route::group(['module' => 'PensionApplication', 'middleware' => ['web', 'auth', 'auditTrails'], 'namespace' => 'App\Modules\PensionApplication\Controllers'], function () {


//    Route::group(['middleware'=>['permission:manage_pension_application']],function(){

    Route::get('pensionApplication/all-application', 'PensionApplicationController@allApplication');
    Route::get('pensionApplication/view-pdf/{id}', 'PensionApplicationController@viewApplicationPdf');

    /**
     * PDF Routes
     */
    Route::get('pension-application/pdf/{id}/{form_number?}', 'ExportController@exportPdf')->name('pa.export.pdf');
    Route::get('pension-application/prl-payable-pdf/{employee_id}', 'ExportController@exportPrlPayablePdf')->name('pa.export-prl-payable.pdf');

    Route::resource('pension-application-2nd-part', 'PensionApplication2ndPartController');
    Route::resource('pension-application-3rd-part', 'PensionApplication3rdPartcontroller');

    Route::resource('pension-application-4th-part', 'PensionApplication4thPartController');
    Route::resource('pension-application-5th-part', 'PensionApplication5thPartController');
    Route::resource('pension-application-6th-part', 'PensionApplication6thPartController');
    Route::resource('pension-application-7th-part', 'PensionApplication7thPartController');
    Route::resource('pension-application-8th-part', 'PensionApplication8thPartController');
    Route::resource('pension-application-9th-part', 'PensionApplication9thPartController');
    Route::resource('pension-application-10th-part', 'PensionApplication10thPartController');
    Route::resource('pension-application-11th-part', 'PensionApplication11thPartController');

    Route::resource('pension-application-12th-part', 'PensionApplication12thPartController');


    Route::get('pension/prl-payable/{employee_id}/{application_id}', 'PensionPrlPayableController@index')->name('prl-payroll');

//    });

    Route::get('pension-application-export-pdf', 'PensionApplicationController@exportPdf');

    Route::get('pension-application/search-employee', 'PensionApplicationController@search')->name('pa.search-emp');
    Route::get('pension-application/create/{employee_id}', 'PensionApplicationController@create')->name('pa.create.emp');

    Route::resource('pension-application', 'PensionApplicationController');

    /**approve pension application**/
    Route::get('pensionApplication/approve-application', 'ApprovePensionController@approveApplication');
    Route::post('approve-pension-application-part-1/{applicationID}', 'ApprovePensionController@approvePart1');
    Route::post('approve-pension-application/{part}/{applicationID}', 'ApprovePensionController@generalApprove');
});
