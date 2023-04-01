<?php

namespace App\Modules\Land\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    //
	protected $table = 'land_areas';
    protected $fillable = ['title', 'zone_id', 'status'];
    
    /**
     * Get the zone that owns the area.
     */
    public function zone()
    {
        return $this->belongsTo('App\Modules\Land\Models\Zone', 'zone_id', 'id');
    }
}
