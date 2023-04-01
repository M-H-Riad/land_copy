<?php

namespace App\Modules\Land\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AuditTrails;
use Illuminate\Database\Eloquent\SoftDeletes;

class Land extends Model
{
    use SoftDeletes, AuditTrails;
    // protected $fillable = ['title', 'zila_id', 'thana_id', 'zone_id', 'area_id', 'land_source_id', 'address', 'dag_no', 'khotian', 'quantity','khajna_land', 'ownership_details', 'current_status', 'khajna', 'namjari', 'comment', 'coordinates', 'status'];
    protected $guarded = [];
    
    /**
     * Get the zone that owns the area.
     */
    public function zone()
    {
        return $this->belongsTo('App\Modules\Land\Models\Zone', 'zone_id', 'id');
    }

    /**
     * Get the zila that owns the land.
     */
    public function zila()
    {
        return $this->belongsTo('App\Modules\Land\Models\Zila', 'zila_id', 'id');
    }
    /**
     * Get the thana that owns the land.
     */
    public function thana()
    {
        return $this->belongsTo('App\Modules\Land\Models\Thana', 'thana_id', 'id');
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
    public function source()
    {
        return $this->belongsTo('App\Modules\Land\Models\LandSource', 'land_source_id', 'id');
    }

    /**
     * Get the documents of this land
     * @return [type] [description]
     * @author Risul Islam <risul321@gmail.com>
     */
    public function landDoc() {
        return $this->hasMany('App\Modules\Land\Models\LandDoc', 'land_id', 'id');
    }
}
