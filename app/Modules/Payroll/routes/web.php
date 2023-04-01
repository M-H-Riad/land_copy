<?php


Route::group(['module' => 'Payroll', 'middleware' => ['web','auth','auditTrails','permission:manage_payroll'], 'namespace' => 'App\Modules\Payroll\Controllers'], function() {


    Route::post('payroll/generate', ['as' => 'payroll.generate', 'uses' => 'PayrollController@generate'])->middleware('permission:generate_salary');
//    Route::get('payroll/lock-unlock/{month_id}', ['as' => 'payroll.lock', 'uses' => 'PayrollController@lock'])->middleware('permission:confirm_salary');
    Route::get('payroll/lock/{month_id}', ['as' => 'payroll.lock', 'uses' => 'PayrollController@lock'])->middleware('permission:confirm_salary');
    Route::get('payroll/salary_confirmation_alert/{month_id}', ['as' => 'payroll.salary_confirmation_alert', 'uses' => 'PayrollController@salary_confirmation_alert'])->middleware('permission:send_salary_confirmation_alert');
    Route::get('payroll/reset/{month_id}', ['as' => 'payroll.reset', 'uses' => 'PayrollController@reset'])->middleware('permission:generate_salary');
    Route::get('payroll/download-pdf/{month_id}/{type?}', ['as' => 'payroll.download-pdf', 'uses' => 'PayrollController@downloadPDF'])->middleware('permission:download_department_report');
    Route::post('payroll/reconciliation', ['as' => 'payroll.reconciliation', 'uses' => 'PayrollController@reconciliation'])->middleware('permission:salary_reconciliation');
  //  Route::get('payroll/download-bangla-pdf/', ['as' => 'payroll.download-bangla-pdf', 'uses' => 'PayrollController@generateBanglaPDF']);
    Route::get('payroll/download-csv/{month_id}', ['as' => 'payroll.download-csv', 'uses' => 'ExportController@downloadSalaryCsv'])->middleware('permission:download_monthly_salary_csv');
    Route::get('payroll/download-bank-csv/{month_id}/{group_id}', ['as' => 'payroll.download-bank-csv', 'uses' => 'BankReportController@downloadBankCsv'])->middleware('permission:download_bank_report_csv');
    Route::get('payroll/download-bank-pdf/{month_id}/{group_id}', ['as' => 'payroll.download-bank-pdf', 'uses' => 'BankReportController@downloadBankPdf'])->middleware('permission:download_bank_report_pdf');
    Route::get('payroll/download-bank-pdf-wasa-drainage/{month_id}', ['as' => 'payroll.download-bank-pdf-wasa-drainage', 'uses' => 'BankReportController@downloadBankPdfWasaDrainage'])->middleware('permission:download_bank_report_pdf');
    Route::get('payroll/download-bank-csv-wasa-drainage/{month_id}', ['as' => 'payroll.download-bank-csv-wasa-drainage', 'uses' => 'BankReportController@downloadBankCsvWasaDrainage'])->middleware('permission:download_bank_report_csv');
    Route::get('payroll/advice-for-bank-pdf/{month_id}/{group_id}', ['as' => 'payroll.advice-bank-pdf', 'uses' => 'BankReportController@downloadAdviceBankPdf'])->middleware('permission:download_bank_report_pdf');
    Route::get('payroll/download-summery/{month_id}/{group_id}', ['as' => 'payroll.download-summery', 'uses' => 'ExportController@downloadSummery'])->middleware('permission:download_group_summery');
    Route::get('payroll/download-total-summery/{month_id}', ['as' => 'payroll.download-summery-total', 'uses' => 'ExportController@downloadTotalSummery'])->middleware('permission:download_total_summery');
    Route::get('payroll/download-department-report/{month_id}/{department_id}', ['as' => 'payroll.download-report-department', 'uses' => 'ExportController@downloadDepartmentReport'])->middleware('permission:download_department_report');
    Route::get('payroll/download-all-department-summery/{month_id}', ['as' => 'payroll.download-all-department-summery', 'uses' => 'ExportController@downloadDepartmentSummery'])->middleware('permission:download_all_department_summery');
    Route::get('payroll/change_salary_department', ['as' => 'change_salary_department.get', 'uses' => 'PayrollController@changeSalaryDepartmentGet'])->middleware('permission:change_salary_department');
    Route::put('payroll/change_salary_department/{id}', ['as' => 'change_salary_department.post', 'uses' => 'PayrollController@changeSalaryDepartmentPost'])->middleware('permission:change_salary_department');
    Route::resource('payroll', 'PayrollController');
    Route::resource('bonus', 'BonusController')->only(['index','store','show','update']);
    Route::post('bonus/generate', ['as' => 'bonus.generate', 'uses' => 'BonusController@generate']);
    Route::get('bonus/lock-unlock/{bonus_id}', ['as' => 'bonus.lock', 'uses' => 'BonusController@lock']);
    Route::get('bonus/reset/{bonus_id}', ['as' => 'bonus.reset', 'uses' => 'BonusController@reset']);
    Route::get('bonus/download-csv/{bonus_id}', ['as' => 'bonus.download-csv', 'uses' => 'ExportController@downloadBonusCsv'])->middleware('permission:download_festival_bonus_csv');
    Route::get('bonus/download-bank-csv/{month_id}/{group_id}', ['as' => 'bonus.download-bank-csv', 'uses' => 'BankReportController@downloadBonusBankCsv'])->middleware('permission:download_bank_report_csv');
    Route::get('bonus/download-bank-pdf/{month_id}/{group_id}', ['as' => 'bonus.download-bank-pdf', 'uses' => 'BankReportController@downloadBonusBankPdf'])->middleware('permission:download_bank_report_pdf');
    Route::get('bonus/download-bank-pdf-wasa-drainage/{month_id}', ['as' => 'bonus.download-bank-pdf-wasa-drainage', 'uses' => 'BankReportController@downloadBankPdfBonusWasaDrainage'])->middleware('permission:download_bank_report_pdf');
    Route::get('bonus/download-bank-csv-wasa-drainage/{month_id}', ['as' => 'bonus.download-bank-csv-wasa-drainage', 'uses' => 'BankReportController@downloadBankCsvBonusWasaDrainage'])->middleware('permission:download_bank_report_csv');
    Route::get('bonus/advice-for-bank-pdf/{month_id}/{group_id}', ['as' => 'bonus.advice-bank-pdf', 'uses' => 'BankReportController@downloadAdviceBankBonusPdf'])->middleware('permission:download_bank_report_pdf');
    Route::get('bonus/download-summery/{bonus_id}/{group_id}', ['as' => 'bonus.download-summery', 'uses' => 'ExportController@downloadBonusSummery'])->middleware('permission:download_group_summery');
    Route::get('bonus/download-total-summery/{month_id}', ['as' => 'bonus.download-summery-total', 'uses' => 'ExportController@downloadTotalBonusSummery'])->middleware('permission:download_total_summery');
    Route::get('bonus/download-department-report/{bonus_id}/{department_id}', ['as' => 'bonus.download-report-department', 'uses' => 'ExportController@downloadBonusDepartmentReport'])->middleware('permission:download_department_report');
    Route::get('bonus/download-all-department-summery/{bonus_id}', ['as' => 'bonus.download-all-department-summery', 'uses' => 'ExportController@downloadBonusDepartmentSummery'])->middleware('permission:download_all_department_summery');

    Route::post('income-tax-report/download',  ['as' => 'income-tax-report.download', 'uses' => 'IncomeTaxReportController@download']);
    Route::get('income-tax-report/download/{month_id}',  ['as' => 'income-tax-info.download', 'uses' => 'IncomeTaxReportController@downloadITDeductionInfo'])->middleware('permission:download_income_tax_summery_monthly');
    Route::get('salary-increment/{id?}',  ['as' => 'salary-increment', 'uses' => 'PayrollInfoSettingController@salaryIncrement'])->middleware('permission:manage_salary_increment');
    Route::get('salary-report',  ['as' => 'salary-report', 'uses' => 'SalaryReportController@index'])->middleware('permission:salary_report');
    Route::post('salary-report/download',  ['as' => 'salary-report.download', 'uses' => 'SalaryReportController@download']);
    Route::get('gpf-report',  ['as' => 'gpf-report', 'uses' => 'ProvidentFundReportController@index']);
    Route::post('gpf-report/download',  ['as' => 'gpf-report.download', 'uses' => 'ProvidentFundReportController@download']);
    Route::get('deduction-info',  ['as' => 'deduction-info', 'uses' => 'DeductionInfoController@index'])->middleware('permission:deduction_info');
    Route::post('deduction-info/download',  ['as' => 'deduction-info.download', 'uses' => 'DeductionInfoController@download'])->middleware('permission:deduction_info');
    //over time
    Route::get('overtime',['as' => 'overtime.index', 'uses' => 'OvertimeController@index'])->middleware('permission:manage_overtime');
    Route::get('overtime/create',['as' => 'overtime.create', 'uses' => 'OvertimeController@create'])->middleware('permission:create_overtime');
    Route::post('overtime/store',['as' => 'overtime.store', 'uses' => 'OvertimeController@store'])->middleware('permission:create_overtime');
    Route::get('overtime/{id}',['as' => 'overtime.show', 'uses' => 'OvertimeController@show'])->middleware('permission:manage_overtime');
    Route::put('overtime/{id}',['as' => 'overtime.update', 'uses' => 'OvertimeController@update'])->middleware('permission:edit_overtime');
    Route::get('overtime/download-department-report/{id}/{department_id?}',['as' => 'overtime.download-report-department', 'uses' => 'OvertimeController@downloadOvertimeDepartmentReport'])->middleware('permission:download_overtime_department_report');
    Route::get('overtime/download-department-report-xlxs/{id}/{department_id}',['as' => 'overtime.download-report-department-xlxs', 'uses' => 'OvertimeController@downloadOvertimeDepartmentReportForBank'])->middleware('permission:download_overtime_department_report');
    Route::get('overtime/lock/{id}', ['as' => 'overtime.lock', 'uses' => 'OvertimeController@lock'])->middleware('permission:confirm_overtime');
    Route::get('overtime/reset/{id}', ['as' => 'overtime.reset', 'uses' => 'OvertimeController@reset'])->middleware('permission:create_overtime');
    Route::post('overtime/demo', ['as' => 'overtime.demo', 'uses' => 'OvertimeController@demo']);
    //night-allowance
    Route::get('night-allowance',['as' => 'night_allowance.index', 'uses' => 'NightAllowanceController@index'])->middleware('permission:manage_night_allowance');
    Route::get('night-allowance/create',['as' => 'night_allowance.create', 'uses' => 'NightAllowanceController@create'])->middleware('permission:create_night_allowance');
    Route::post('night-allowance/store',['as' => 'night_allowance.store', 'uses' => 'NightAllowanceController@store'])->middleware('permission:create_night_allowance');
    Route::get('night-allowance/{id}',['as' => 'night_allowance.show', 'uses' => 'NightAllowanceController@show'])->middleware('permission:manage_night_allowance');
    Route::put('night-allowance/{id}',['as' => 'night_allowance.update', 'uses' => 'NightAllowanceController@update'])->middleware('permission:edit_night_allowance');
    Route::get('night-allowance/download-department-report/{id}/{department_id?}',['as' => 'night_allowance.download-report-department', 'uses' => 'NightAllowanceController@downloadNightAllowanceDepartmentReport'])->middleware('permission:download_night_allowance_department_report');
    Route::get('night-allowance/download-department-report-xlxs/{id}/{department_id}',['as' => 'night_allowance.download-report-department-xlxs', 'uses' => 'NightAllowanceController@downloadNightAllowanceDepartmentReportForBank'])->middleware('permission:download_night_allowance_department_report');
    Route::get('night-allowance/lock/{id}', ['as' => 'night_allowance.lock', 'uses' => 'NightAllowanceController@lock'])->middleware('permission:confirm_night_allowance');
    Route::get('night-allowance/reset/{id}', ['as' => 'night_allowance.reset', 'uses' => 'NightAllowanceController@reset'])->middleware('permission:create_night_allowance');
    Route::post('night-allowance/demo', ['as' => 'night_allowance.demo', 'uses' => 'NightAllowanceController@demo']);
    //ifter-bill
    Route::get('ifter-bill',['as' => 'ifter_bill.index', 'uses' => 'IfterBillController@index'])->middleware('permission:manage_ifter_bill');
    Route::get('ifter-bill/create',['as' => 'ifter_bill.create', 'uses' => 'IfterBillController@create'])->middleware('permission:create_ifter_bill');
    Route::post('ifter-bill/store',['as' => 'ifter_bill.store', 'uses' => 'IfterBillController@store'])->middleware('permission:create_ifter_bill');
    Route::get('ifter-bill/{id}',['as' => 'ifter_bill.show', 'uses' => 'IfterBillController@show'])->middleware('permission:manage_ifter_bill');
    Route::put('ifter-bill/{id}',['as' => 'ifter_bill.update', 'uses' => 'IfterBillController@update'])->middleware('permission:edit_ifter_bill');
    Route::get('ifter-bill/download-department-report/{id}/{department_id?}',['as' => 'ifter_bill.download-report-department', 'uses' => 'IfterBillController@downloadIfterBillDepartmentReport'])->middleware('permission:download_ifter_bill_department_report');
    Route::get('ifter-bill/download-department-report-xlxs/{id}/{department_id}',['as' => 'ifter_bill.download-report-department-xlxs', 'uses' => 'IfterBillController@downloadIfterBillDepartmentReportForBank'])->middleware('permission:download_ifter_bill_department_report');
    Route::get('ifter-bill/lock/{id}', ['as' => 'ifter_bill.lock', 'uses' => 'IfterBillController@lock'])->middleware('permission:confirm_ifter_bill');
    Route::get('ifter-bill/reset/{id}', ['as' => 'ifter_bill.reset', 'uses' => 'IfterBillController@reset'])->middleware('permission:create_ifter_bill');
    Route::post('ifter-bill/demo', ['as' => 'ifter_bill.demo', 'uses' => 'IfterBillController@demo']);
    //test url--------------------------------------------------
//    Route::get('test/update-payroll','TestPayroll@payroll');
//    Route::get('test/check-payroll','TestPayroll@payrollCheck');
//    Route::get('test/payroll-update-monthly','TestPayroll@payrollUpdateMonthly');
//    Route::get('test/salary-increment','TestPayroll@salary');
//    Route::get('test/wasa-payroll-upload','TestPayroll@payrollUpload');
//    Route::post('test/wasa-payroll-update','TestPayroll@payrollUpdate');
//        Route::get('test/wasa-old-salary','TestPayroll@oldSalaryUpload');
//    Route::post('test/wasa-old-salary-update','TestPayroll@oldSalaryUpdate');
//    Route::get('test/wasa-payroll-details-update','TestPayroll@payrollSettingToDetails');
//    Route::get('test/wasa-payroll-settings-update','TestPayroll@payrollDetailsToSetting');
//    Route::get('test/prl-off','TestPayroll@prlOff');
//    Route::get('test/class-add','TestPayroll@classAdd');
//    Route::get('test/vhl_alw','TestPayroll@updateVhlAlw');
//    Route::get('test/conv_alw','TestPayroll@updateConvAlw');
//    Route::get('test/chrg_alw','TestPayroll@updateChrgAlw');
//    Route::get('test/tiffin_alw','TestPayroll@updateTiffinAlw');
//    Route::get('test/newIncomeTax','TestPayroll@newIncomeTaxCalculation');

//    Route::get('data-migration','TestOldDataMigration@index');
//    Route::get('data-migration/employee-list-download','TestOldDataMigration@employeeListDownload');
//    Route::get('data-migration/date-format','TestOldDataMigration@changeDateFormat');
//    Route::get('data-migration/loan-employee','TestOldDataMigration@loanEmployee');
    Route::get('data-migration/loan-info', 'TestOldDataMigration@getLoanInfo');

   Route::get('data-migration/wasa-old-salary','TestOldDataMigration@oldSalaryUpload');
   Route::post('data-migration/wasa-old-salary-update','TestOldDataMigration@oldSalaryUpdate');

    //test url--------------------------------------------------
});



Route::group(['module' => 'Payroll', 'middleware' => ['web','auth','auditTrails'], 'namespace' => 'App\Modules\Payroll\Controllers'], function() {

    Route::resource('payroll-details', 'PayrollInfoSettingController')->middleware('permission:manage_payroll_details');
    Route::resource('payroll-setting', 'PayrollSettingController')->middleware('permission:manage_payroll_setting');
    Route::resource('bonus-setting', 'BonusSettingController')->middleware('permission:manage_bonus_setting');
    Route::resource('income-tax-report', 'IncomeTaxReportController')->only(['index','edit','update'])->middleware('permission:income_tax_report');
    Route::resource('payroll-head-setting', 'PayrollHeadSettingController')->middleware('permission:manage_payroll_head_setting');

});