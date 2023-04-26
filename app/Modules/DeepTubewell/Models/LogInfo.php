<?php

namespace App\Modules\DeepTubewell\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class LogInfo extends Model
{
    
    protected $table = 'log_info';
    protected $fillable = ['id','user_id','module_name','menu_name','operation','zone_id','zone_title','zone_status','zila_id','zila_title','zila_status','thana_id','thana_title','thana_zila_id','thana_status','thana_created_by','thana_updated_by','mowja_id','mowja_zone_id','mowja_title','mowja_status','land_sources_id','land_sources_title','land_sources_status','land_id','land_title','land_zila_id','land_thana_id','land_area_id','land_zone_id','land_source_id','land_address','land_dag_no','land_khotian','land_quantity','land_khajna_land','land_ownership_details','land_current_status','land_khajna','land_namjari','land_coordinates','land_comment','land_status','land_doc_name_1','land_doc_1','land_doc_name_2','land_doc_2','land_doc_name_3','land_doc_3','land_doc_name_4','land_doc_4','land_doc_name_5','land_doc_5','land_created_by','land_updated_by','land_deleted_by','vumi_office_id','vumi_office_upazila_id','vumi_office_mowja_id','vumi_office_office_name','vumi_office_status','vumi_office_address','vumi_office_created_by','vumi_office_updated_by','vumi_office_deleted_by','namjaris_id','namjaris_land_id','namjaris_mowja_id','namjaris_zone_id','namjaris_status','namjaris_jomir_sreny','namjaris_jomir_sreny_details','namjaris_namjari_date','namjaris_purchase_date','namjari_khotian_no','namjarir_pore_khotian_no','namjarir_dag_no','oi_dage_mot_jomi','jomir_unit','namjari_jot_no','namjari_jl_no','dager_moddhe_khotianer_ongsho','ongsho_onujaie_jomir_poriman','ongsho_onujaie_jomir_akok','namjaris_note','namjaris_created_by','namjaris_updated_by','namjaris_deleted_by','khajna_office_info_id','khajna_office_info_land_id','khajna_office_info_upazila_id','khajna_office_info_mowja_id','khajna_office_info_khajna_office_id','khajna_office_info_open_year','khajna_office_info_total_bokeya','khajna_office_info_from_year','khajna_office_info_to_year','khajna_office_info_status','khajna_office_info_created_by','khajna_office_info_updated_by','khajna_office_info_deleted_by','khajna_infos_id','khajna_infos_land_id','khajna_infos_khajna_date','khajna_infos_khajna_date_month','khajna_infos_khajna_date_year','khajna_infos_from_year','khajna_infos_to_year','khajna_infos_khajna_office_id','khajna_infos_upazila_id','khajna_infos_mowja_id','khajna_infos_bokeya','khajna_infos_hal','khajna_infos_note','khajna_infos_document','khajna_infos_dakhila','khajna_infos_created_by','khajna_infos_updated_by','khajna_infos_deleted_by','land_property_types_id','land_property_types_title','land_property_types_status','land_properties_id','land_properties_title','land_properties_land_id','land_properties_latitude','land_properties_longitude','land_properties_type_id','land_properties_status','deep_tubewell_source_type_id','deep_tubewell_source_type_title','deep_tubewell_source_type_status','deep_tubewell_id','deep_tubewell_zone_id','deep_tubewell_area_id','deep_tubewell_source_type','deep_tubewell_source','deep_tubewell_onumoti_chukti_boraddo','deep_tubewell_onumoti_chukti_boraddo_date','deep_tubewell_onumoti_chukti_boraddo_attach_name','deep_tubewell_onumoti_chukti_boraddo_attach','deep_tubewell_dokholpotro_date','deep_tubewell_dokholpotro_attach_name','deep_tubewell_dokholpotro_attach','deep_tubewell_deep_tubewell_place_name','deep_tubewell_khotiyan_no','deep_tubewell_dag_no','deep_tubewell_jomir_poriman','deep_tubewell_destination','deep_tubewell_other_attach'];


    
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
