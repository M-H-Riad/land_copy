<?php

Route::group(['module' => 'Location', 'middleware' => ['web','auth','auditTrails'], 'namespace' => 'App\Modules\Location\Controllers'], function() {
	// get division
	Route::post('get-post-office','GetLocationController@get_post_office');
	Route::post('get-thana','GetLocationController@get_thana');
	Route::post('get-district','GetLocationController@get_district');
	Route::post('get-division','GetLocationController@get_division');
	Route::resource('quarter-location', 'QuarterLocationController')->middleware('permission:manage_quarter_location');
	Route::resource('post-office', 'PostOfficeController')->middleware('permission:manage_post_office');
	Route::resource('thana', 'ThanaController')->middleware('permission:manage_thana_upazila');
	Route::resource('district', 'DistrictController')->middleware('permission:manage_district');
	Route::resource('division', 'DivisionController')->middleware('permission:manage_division');
	Route::resource('Location', 'LocationController');

});
