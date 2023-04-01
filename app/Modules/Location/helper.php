<?php

/**
 * 	Location Helper
 */

function get_states_dropdown($country_id = 20){
	$states = \App\Modules\Location\Models\Division::where('country_id',$country_id)->where('status',1)->orderBy('name')->pluck('name','id');
	return $states;
}
function get_district_dropdown($division_id){
	$district = \App\Modules\Location\Models\District::where('state_id',$division_id)->where('status',1)->orderBy('name')->pluck('name','id');
	return $district;
}function get_thana_dropdown($district_id){
	$thana = \App\Modules\Location\Models\Thana::where('city_id',$district_id)->where('status',1)->orderBy('name','asc')->pluck('name','id');
	return $thana;
}
function get_post_office_dropdown($thana_id){
	$thana = \App\Modules\Location\Models\PostOffice::selectRaw("CONCAT(name,' (',zip_code,')') as name,id")->where('thana_id',$thana_id)->where('status',1)->orderBy('name','asc')->pluck('name','id');
	return $thana;
}

