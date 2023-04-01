<?php

Route::group(['module' => 'Pension', 'middleware' => ['web', 'auth', 'permission:manage_pensionable_setting'], 'namespace' => 'App\Modules\Pension\Controllers'], function() {

    Route::resource('Pension', 'PensionController');
    Route::resource('pensionable-time-period-year', 'PensionableTimePeriodYearController');
    Route::resource('pensionable-percent', 'PensionableTimePeriodPercentageController');
    Route::resource('gratuity-year', 'GratuityYearController');
    Route::resource('gratuity-value', 'GratuityValueController');
    // Route::get('set-employee-to-application', 'PensionApplicationController@set_employee_to_application');
    // Route::resource('pension-application', 'PensionApplicationController');
});
Route::group(['module' => 'Pension', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Pension\Controllers'], function() {
    // generate excel report
    Route::post('preview-pdf-generated-pension-autometically','GenerateMonthlyPensionController@preview_pdf_generated_pension_autometically');
    Route::post('generate-excel-pension-fund','PensionFundReportController@generate_excel_pension_fund');
    // general setting
    Route::resource('pension-general-setting','PensionGeneralSettingController')->middleware('permission:manage_pension_general_setting');
    // hold individual employee pension payment
    Route::get('hold-pension-payment/{employee_id}/{id}/{status_type}', 'PensionFundReportController@hold_pension_payment')->middleware('permission:hold_pension_payment');
    //
    Route::post('confirm-generate-monthly-pension-autometically', 'GenerateMonthlyPensionController@confirm_generate_monthly_pension')->middleware('permission:generate_monthly_pension');
    Route::post('generate-monthly-pension-autometically', 'GenerateMonthlyPensionController@generate_monthly_pension')->middleware('permission:generate_monthly_pension');
    Route::get('set-employee-to-application', 'PensionApplicationController@set_employee_to_application')->middleware('permission:manage_pension_application');
    //change by arnob for resolve conflict
    Route::resource('ppension-application', 'PensionApplicationController')->middleware('permission:manage_pension_application');

    Route::get('export-pension-fund-report',['as' => 'pension.export-pension-fund-report', 'uses' => 'PensionFundReportController@export_pdf'] )->middleware('permission:manage_pension_fund_report');
    Route::resource('pension-fund-report', 'PensionFundReportController')->middleware('permission:manage_pension_fund_report');
});


Route::group(['module' => 'Pension', 'middleware' => ['web','auth','permission:manage_pension_monthly_report'], 'namespace' => 'App\Modules\Pension\Controllers'], function() {
    // Pensioner Statement
    Route::post('generate-pensioner-monthly-statement','PensionMonthlyReportController@generate_pensioner_monthly_statement');
    //
    //Bank Advice Form
    Route::get('pension/export-bank-advice', ['as' => 'pension.export-bank-advice', 'uses' => 'PensionMonthlyReportController@exportBankAdviceAsPdf']);
    // End Bank advice
    Route::get('pension/export-detail-summary', ['as' => 'pension.export-detail-summary', 'uses' => 'PensionMonthlyReportController@exportDetailSummaryPdf']);
    Route::get('pension/send-sms-and-set-status', ['as' => 'pension.send-sms-and-set-status', 'uses' => 'PensionMonthlyReportController@sendSmsAndSetStatus']);

    Route::get('pension/export-pension-monthly-report-excel', ['as' => 'pension.export-excel', 'uses' => 'PensionMonthlyReportController@exportExcel']);
    Route::get('pension/export-excel-report-from-pdf', ['as' => 'pension.export-excel-report-from-pdf', 'uses' => 'PensionMonthlyReportController@export_pdf_to_excel']);
    Route::get('pension/export-pension-monthly-report-pdf', ['as' => 'pension.export-pdf', 'uses' => 'PensionMonthlyReportController@exportPdf']);
    Route::get('pension/export-pension-monthly-report-excel-as-pdf', ['as' => 'pension.export-excel-as-pdf', 'uses' => 'PensionMonthlyReportController@exportExcelAsPdf']);

    Route::delete('pension/delete-pension-monthly-report/{id}', ['as' => 'pension.delete-monthly-report', 'uses' => 'PensionMonthlyReportController@destroy']);

//    Route::get('export-pension-monthly-report', 'PensionMonthlyReportController@export_pdf');

    Route::resource('generate-monthly-pension-report', 'PensionMonthlyReportController');
    Route::resource('generate-pension-report-by-emp', 'PensionMonthlyReportByEmployeeController');

    Route::resource('generate-monthly-pension-report', 'PensionMonthlyReportController');

});

Route::group(['module'=>'Pension','middleware'=>['web','auth','permission:manage_pension_deduction'],'namespace'=>'App\Modules\Pension\Controllers'],function(){
   
    Route::post('pension-deduction/add-more-amount/{id}','PensionDeductionController@addMoreAmount');
    Route::resource('pension-deduction','PensionDeductionController');
});
