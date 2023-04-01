<?php

namespace App\Modules\Land\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AuditTrails;
use Illuminate\Database\Eloquent\SoftDeletes;

class Thana extends Model
{
    use SoftDeletes, AuditTrails;
	protected $table = 'thanas';
    protected $guarded = [];
    
    /**
     * Get the zone that owns the area.
     */
    public function zila()
    {
        return $this->belongsTo('App\Modules\Land\Models\Zila', 'zila_id', 'id');
    }
}
