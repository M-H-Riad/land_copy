<?php

Route::group(['module' => 'EmployeeProfile','middleware' => ['web','auth','auditTrails'], 'namespace' => 'App\Modules\EmployeeProfile\Controllers'], function() {

    Route::get('employee-export-pdf/{id}',['as' => 'export-pdf', 'uses' => 'ExportController@pdfProfile']);
    Route::get('employee-export/excel',['as' => 'export-excel', 'uses' => 'ExportController@getEmployeeListExcel']);
    Route::get('employee-basic-export/excel',['as' => 'export-basic-excel', 'uses' => 'ExportController@getEmployeeListExcelBasic']);
    Route::get('employee-export/pdf',['as' => 'export-list-pdf', 'uses' => 'ExportController@getEmployeeListPDF']);
    Route::get('employee-export/religion/pdf',['as' => 'export-list-religion-pdf', 'uses' => 'ExportController@getReligionEmployeeListPdf']);
    Route::get('employee-basic-export/pdf',['as' => 'export-basic-list-pdf', 'uses' => 'ExportController@getEmployeeListPDFBasic']);
    Route::get('employee-excel-download',['as' => 'download-excel', 'uses' => 'ExportController@downloadExcelList']);

//    Route::post('employee-store-user', 'EmployeeProfileController@employeeStoreUser');
    Route::post('employee-user/store-user', 'EmployeeUserController@storeUser');
    Route::post('employee-user/update-role', 'EmployeeUserController@updateRole');

    Route::post('employee-profile/create/get-bank-branch', 'EmployeeProfileController@getBankBranch');

    Route::post('employee-document/store', 'EmployeeDocumentController@store');
    Route::post('employee-document/upload-photo', 'EmployeeDocumentController@uploadPhoto');
    Route::get('employee-profile/search', 'EmployeeProfileController@search');
    Route::get('prl-retirement',['as' => 'prl-retirement', 'uses' => 'EmployeeProfileController@PRLRetirement']);
    Route::get('pre-prl',['as' => 'pre-prl', 'uses' => 'EmployeeProfileController@prePRL']);


    /**
     * Pension Related Routes related with Employee Information
     */
    Route::post('employee/pension-relative', ['as' => 'employee.pension-relative', 'uses' => 'PensionRelativeController@store']);
    Route::put('employee/pension-relative', ['as' => 'employee.pension-relative', 'uses' => 'PensionRelativeController@update']);
    Route::delete('employee/pension-relative/{id}','PensionRelativeController@destroy');
    Route::get('employee-profile/create-pension-employee', ['as' => 'emp.pension-employee', 'uses' => 'PensionEmployeeController@createEmployee']);
    Route::post('employee-profile/store-pension-employee', ['as' => 'emp.pension-employee-store', 'uses' => 'PensionEmployeeController@storeEmployee']);
//    Route::put('employee-profile/update-pension-employee/{id}', ['as' => 'emp.pension-employee-update', 'uses' => 'PensionEmployeeController@updateEmployee']);

    Route::post('employee-membership', ['as' => 'employee-membership', 'uses' => 'EmployeeMembershipController@store']);
    Route::post('employee-payroll-setting', ['as' => 'employee-payroll-setting', 'uses' => 'EmployeePayrollSettingsController@store']);

    // End

    /**assign hod**/
    Route::post('employee-profile/assign-hod', 'EmployeeProfileController@assignHOD');
    Route::post('employee-profile/remove-assign-hod', 'EmployeeProfileController@removeAssignHOD');

    /*
     * Start Resource section
     */
    Route::resource('employee-addresss', 'EmployeeAddressController');
//    Route::resource('employee-membership', 'EmployeeMembershipController');
    Route::resource('employee-training', 'EmployeeTrainingController');
    Route::resource('employee-suspension', 'EmployeeSuspensionController');
    Route::resource('employee-disciplinary-records', 'EmployeeDisciplinaryRecordController');
    Route::resource('employee-quarter', 'EmployeeQuarterController');
    Route::resource('employee-education', 'EmployeeEducationController');
    Route::resource('employee-children', 'EmployeeChildrenController');
    Route::resource('employee-profile', 'EmployeeProfileController');
    Route::resource('employee-job-experience', 'EmployeeWasaJobExperienceController');
    Route::resource('employee-service-experience', 'EmployeeServiceExperienceController');
    Route::resource('employee-transfer', 'EmployeeTransferController');
    Route::resource('employee-leave', 'EmployeeLeaveController');
    Route::get('pension-holder', 'EmployeeProfileController@pensionHolderList');
    //masud
    Route::resource('pension-bank-account', 'PensionBankAccountController');
    Route::resource('pension-fund-emp', 'PensionFundEmpController');
    Route::resource('pension-job-experience', 'PensionJobController');

    Route::post('get-basic-pay-by-grade','EmployeeProfileController@getBasicPayByGrade');
    Route::post('get-scale-list-by-year','EmployeeProfileController@getScaleListByYear');
    
//    Route::get('import-data','TestImportController@index');
//    Route::get('import-data-miss','TestImportController@importDataMiss');
//    Route::get('import-data-match','TestImportController@match');
//    Route::get('import-data-ac-cc','TestImportController@importDataAcCc');
//    Route::get('update-emp-id','TestImportController@updateEmpeloyeeId');
//    Route::get('update-wasa-job-exp','TestImportController@updateWasaJobExp');
//    Route::get('update-ac-cc','TestImportController@matchAcCc');
//    Route::get('update-import-employee-info','TestImportController@importEmployeeInfo');
//    Route::get('update-import-dep-group','TestImportController@importDepartmentGroup');
//    Route::get('update-employee-data','TestImportController@importEmployeeInfoForSalary');
//    Route::get('update-employee-basic','TestImportController@updateEmployeeBasicSalary');
//    Route::get('update-loan-data','TestImportController@loanData');
//    Route::get('update-employee-department','TestImportController@updateEmployeeDepartment');
//    Route::get('update-payroll','TestImportController@payroll');
//    Route::get('check-payroll','TestImportController@payrollCheck');
//    Route::get('freedom-fighter-off','TestImportController@freedomFighterOff');

});
