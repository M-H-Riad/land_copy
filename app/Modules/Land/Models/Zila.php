<?php

namespace App\Modules\Land\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AuditTrails;
use Illuminate\Database\Eloquent\SoftDeletes;

class Zila extends Model
{
    use SoftDeletes, AuditTrails;
	protected $table = 'zilas';
    protected $guarded = [];
    
    /**
     * Get the zone that owns the area.
     */
    public function zone()
    {
        return $this->belongsTo('App\Modules\Land\Models\Zone', 'zone_id', 'id');
    }
}
