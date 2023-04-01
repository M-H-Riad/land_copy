<?php

Route::group(['module' => 'Land', 'prefix' => 'land', 'middleware' => ['web', 'auth', 'auditTrails'], 'namespace' => 'App\Modules\Land\Controllers'], function () {

    Route::get('land/{id}/single-pdf', 'LandController@single_pdf')->name('land.single-pdf');
    Route::get('land/list-pdf', 'LandController@pdf')->name('land.pdf');
    Route::get('land/land/export', 'LandController@export')->name('land.export');

    Route::resource('land', 'LandController');
    Route::get('getareas/{zoneId}', 'AreaController@getAreas');
    Route::get('getthanas/{zilaID}', 'ThanaController@getThana');
    Route::resource('zone', 'ZoneController');
    // Route::resource('zila', 'ZilaController');
    Route::resource('thana', 'ThanaController');
    Route::resource('area', 'AreaController');
    Route::resource('source', 'LandSourceController');
    Route::resource('propertytype', 'PropertyTypeController');
    Route::resource('property', 'PropertyController');

    //Zila routes....
    Route::any('zila', 'ZilaController@index');
    Route::any('zila-store', 'ZilaController@store');
    Route::any('zila/{id}', 'ZilaController@update');
    Route::any('zila-delete/{id}', 'ZilaController@destroy')->name('zila.destroy');
    Route::any('thana-delete/{id}', 'ThanaController@destroy')->name('thana.delete');




    // Land ajax routes.....
    Route::get('create-area', 'AreaController@create_by_ajax')->name('area.create-ajax');
    Route::get('create-source', 'LandSourceController@create_by_ajax')->name('source.create-ajax');


    //Namjari routes
    Route::resource('namjari', 'NamjariController');
    Route::get('namjari/{id}/single-pdf', 'NamjariController@single_pdf')->name('namjari.single-pdf');
    Route::get('namjari/pdf/list-pdf', 'NamjariController@pdfList')->name('namjari.pdf.download');
    Route::get('namjari/namjari/export', 'NamjariController@export')->name('namjari.export');
    Route::get('get-land-info/zone/mowja', 'NamjariController@getLandInfo');

    // Khajna office info
    Route::resource('khajna-office', 'KhajnaOfficeInfoController');
    Route::get('khajna-office/{id}/single-pdf', 'KhajnaOfficeInfoController@single_pdf')->name('khajna-office.single-pdf');
    Route::get('khajna-office/pdf/list-pdf', 'KhajnaOfficeInfoController@pdfList')->name('khajna-office.pdf.download');
    Route::get('khajna-office/khajna-office/export', 'KhajnaOfficeInfoController@export')->name('khajna-office.export');


    // Vumi office info
    Route::resource('vumi_office', 'VumiOfficeController');
    Route::get('vumi_office/{id}/single-pdf', 'VumiOfficeController@single_pdf')->name('vumi_office.single-pdf');
    Route::get('vumi_office/pdf/list-pdf', 'VumiOfficeController@pdfList')->name('vumi_office.pdf.download');
    Route::get('vumi_office/vumi_office/export', 'VumiOfficeController@export')->name('vumi_office.export');


    // Khajna info...
    Route::resource('khajna-info', 'KhajnaInfoController');
    Route::get('get-khajna-office-info', 'KhajnaInfoController@getKhajnaOfficeInfo');
    Route::get('get-oorishodito-khajna-info', 'KhajnaInfoController@getPorishoditoKhajnaInfo');
    Route::get('khajna-info/{id}/single-pdf', 'KhajnaInfoController@single_pdf')->name('khajna-info.single-pdf');
    Route::get('khajna-info/pdf/list-pdf', 'KhajnaInfoController@pdfList')->name('khajna-info.pdf.download');
    Route::get('khajna-info/khajna-info/export', 'KhajnaInfoController@export')->name('khajna-info.export');

    // Report routes...........
    Route::get('khajna/payment/report', 'LandReportController@getKhajnaPaymentReport')->name('khajna-pay.report');
    Route::get('khajna/payment/report/list-pdf', 'LandReportController@khajnaPaymentReportPdfList')->name('khajna-payment.report.pdf');
    Route::get('khajna/payment/report/export', 'LandReportController@khajnaPaymentReportExport')->name('khajna-pay.report.export');

    Route::get('khajna-pay/vumioffice/report', 'LandReportController@getKhajnaVumiOfficeReport')->name('khajna-yearly.report');
    Route::get('khajna-pay/vumioffice/report/list-pdf', 'LandReportController@khajnaPayVumiOfficeReportPdfList')->name('khajna-pay.vumiOffice.report.pdf');
    Route::get('khajna-pay/vumioffice/report/export', 'LandReportController@vumiOfficekhajnaPayReportExport')->name('khajna-pay.vumiOffice.report.export');

    Route::get('yearly/khajna-pay/report', 'LandReportController@getYearlyKhajnaPayReport')->name('yearly-khajna-pay.report');
    Route::get('yearly/khajna-pay/report/list-pdf', 'LandReportController@yearlyKhajnaPayReportPdfList')->name('yearly-khajna-pay.report.pdf');
    Route::get('yearly/khajna-pay/report/export', 'LandReportController@yearlykhajnaPayReportExport')->name('yearly-khajna-pay.report.export');
    
    Route::get('khajna-bokeya/report', 'LandReportController@getKhajnaBokeyaReport')->name('khajna-bokeya.report');
    Route::get('khajna-bokeya/report/list-pdf', 'LandReportController@khajnaBokeyaReportPdfList')->name('khajna-bokeya.report.pdf');
    Route::get('khajna-bokeya/report/export', 'LandReportController@khajnaBokeyaReportExport')->name('khajna-bokeya.report.export');

    Route::get('zone/khajna-pay/report', 'LandReportController@getZoneKhajnaReport')->name('zone-khajna.report');
    Route::get('zone/khajna-pay/report/list-pdf', 'LandReportController@zoneKhajnaReportPdfList')->name('zone-khajna.report.pdf');
    Route::get('zone/khajna-pay/report/export', 'LandReportController@zoneKhajnaReportExport')->name('zone-khajna.report.export');


    Route::get('khotian/namjari-report', 'LandReportController@getNamjariReportByKhotian')->name('khotian-namjari.report');
    Route::get('khotian/namjari-report/pdf-export', 'LandReportController@exportNamjariReportByKhotianPdf')->name('khotian-namjari.report.export');
    
    
    
    Route::get('up-mowja', 'KhajnaOfficeInfoController@get_mowja');
    Route::get('mowja-khajnaoffice', 'KhajnaOfficeInfoController@get_khajnaOffice');

    Route::post('land-document/store', 'LandDocController@store');
    Route::put('land-document/update/{document}', 'LandDocController@update')->name('land.document.update');
    Route::get('land-document/delete/{document}', 'LandDocController@delete')->name('land.document.delete');

});
