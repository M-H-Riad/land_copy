<?php

Route::group(['module' => 'GeneralConfiguration', 'middleware' => ['web','auth','auditTrails'], 'namespace' => 'App\Modules\GeneralConfiguration\Controllers'], function() {

    Route::resource('GeneralConfiguration', 'GeneralConfigurationController');
    Route::resource('pay-scale', 'PayScaleController')->middleware('permission:manage_pay_scale');
    /*arnob*/
    Route::resource('department', 'DepartmentController')->middleware('permission:manage_department');
    Route::resource('designation', 'DesignationController')->middleware('permission:manage_designation');
    Route::resource('file-type', 'FileTypeController')->middleware('permission:manage_file_type');
    Route::resource('university', 'UniversityController')->middleware('permission:manage_university');
    Route::get('script','ScriptController@index');
    /*end arnob*/

//    Route::resource('file-type', 'FileTypeController');
    Route::resource('membership-org', 'MembershipOrganizationController')->middleware('permission:manage_membership_organaization');
    Route::resource('qualification', 'QualificationsController')->middleware('permission:manage_qualication');
    Route::get('scale','PayScaleController@restore');
    Route::post('scale-excle','PayScaleController@uploadExcel');

    Route::resource('leave-type', 'LeaveTypeController')->middleware('permission:manage_leave_type');

    Route::resource('quota', 'QuotaController');
    
    Route::get('prl-settings', 'PrlSettingsController@index');
    Route::post('prl-settings', 'PrlSettingsController@store');
    Route::put('prl-settings/{id}', 'PrlSettingsController@update');
});
