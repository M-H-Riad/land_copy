<?php

namespace App\Modules\DeepTubewell\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AuditTrails;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeepTubewell extends Model
{
    
    protected $table = 'deep_tubewell';
    protected $fillable = ['id','zone_id','area_id','source_type','source','onumoti_chukti_boraddo','onumoti_chukti_boraddo_date','onumoti_chukti_boraddo_attach_name','onumoti_chukti_boraddo_attach','dokholpotro_date','dokholpotro_attach_name','dokholpotro_attach','deep_tubewell_place_name','khotiyan_no','dag_no','jomir_poriman','destination','other_attach'];

    public function zone()
    {
        return $this->belongsTo('App\Modules\Land\Models\Zone', 'zone_id', 'id');
    }


    
    /**
     * Get the zone that owns the area.
     */
    public function area()
    {
        return $this->belongsTo('App\Modules\Land\Models\Area', 'area_id', 'id');
    }

    
    /**
     * Get the zone that owns the area.
     */
    public function sourceType()
    {
        return $this->belongsTo('App\Modules\DeepTubewell\Models\DeepTubewellSourceType', 'source_type', 'id');
    }

    public function sources()
    {
        return $this->belongsTo('App\Modules\DeepTubewell\Models\DeepTubewellSource', 'source', 'id');
    }
    
}
