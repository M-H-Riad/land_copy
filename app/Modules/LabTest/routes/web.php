<?php

Route::group(['module' => 'LabTestResult', 'middleware' => ['web', 'auth', 'auditTrails'], 'namespace' => 'App\Modules\LabTest\Controllers'], function () {

    Route::resource('lab-test-result', 'LabTestResultController');
    Route::resource('lab-test', 'LabTestController');

    Route::resource('labs', 'LabsController');
    Route::resource('lab-pump', 'LabPumpController');
    Route::resource('lab-testing-parameter', 'LabTestingParameterController');
    Route::resource('lab-treatment-plant', 'LabTreatmentPlantController');
    Route::resource('lab-unit', 'LabUnitController');
    Route::resource('lab_water_types', 'lab_water_typesController');
    Route::resource('lab-water-type', 'LabWaterTypeController');
    Route::resource('lab-water-sample-source', 'LabWaterSampleSourceController');
    Route::resource('lab-zone', 'LabZoneController');
    Route::resource('lab-dma', 'LabDmaController');
    Route::resource('lab-institute', 'LabInstituteController');
    Route::resource('standard-parameter-value', 'StandardParameterValueController');
    
    Route::post('get-standard-parameter-value', 'StandardParameterValueController@getValue');

    Route::resource('lab-test-author', 'LabTestAuthorController');
    
    Route::resource('lab-report-head', 'ReportHeadController');

    Route::get('water-quality-analysis/{id}/pdf', 'WaterQualityAnalysisController@pdf');
    Route::resource('water-quality-analysis', 'WaterQualityAnalysisController');

    Route::get('morning-water-quality-analysis/{id}/pdf', 'MorningWaterAnalysisController@pdf');
    Route::resource('morning-water-quality-analysis', 'MorningWaterAnalysisController');

    Route::resource('chlorine-demand-test', 'ChlorineDemandTestController');
    Route::get('chlorine-demand-test/{id}/pdf', 'ChlorineDemandTestController@pdf');

    Route::resource('water-sample-test', 'WaterSampleTestController');
    Route::get('water-sample-test/{id}/pdf', 'WaterSampleTestController@pdf');
    
    Route::post('custom-water-sample-test', 'WaterSampleTestController@customReport');
    Route::get('custom-water-sample-test/{id}/pdf', 'WaterSampleTestController@customPdf');

    Route::resource('water-quality-report', 'WaterQualityReportController');
    Route::get('water-quality-report/{id}/pdf', 'WaterQualityReportController@pdf');

    Route::resource('central-water-quality-analysis', 'CentralWaterQualityAnalysisController');
    Route::get('central-water-quality-analysis/{id}/pdf', 'CentralWaterQualityAnalysisController@pdf');

    Route::resource('saidabad-water-quality-analysis', 'SaidabadWaterQualityAnalysisController');
    Route::get('saidabad-water-quality-analysis/{id}/pdf', 'SaidabadWaterQualityAnalysisController@pdf');

    Route::resource('bottle-water-quality-analysis', 'BottleWaterQualityAnalysisController');
    Route::get('bottle-water-quality-analysis/{id}/pdf', 'BottleWaterQualityAnalysisController@pdf');
});
