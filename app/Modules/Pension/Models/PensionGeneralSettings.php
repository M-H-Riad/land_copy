<?php

namespace App\Modules\Pension\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PensionGeneralSettings extends Model {
    //
	use SoftDeletes;
	protected $table = 'pension_general_settings';
	protected $fillable = [ "pahela_baishakh","eid_al_fitr","eid_al_adha","durga_puja","buddha_s_birthday","christmas","net_pension_increment_month","net_pension_increment_percentage","year"];
	protected $hidden = ['created_at','updated_at','created_by','updated_by','deleted_at','deleted_by'];

}
