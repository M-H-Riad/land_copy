<?php

namespace App\Modules\Land\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AuditTrails;
use Illuminate\Database\Eloquent\SoftDeletes;

class Namjari extends Model
{
    use SoftDeletes, AuditTrails;
    protected $guarded = [];

    /**
     * Get the land info
     */
    public function land()
    {
        return $this->belongsTo('App\Modules\Land\Models\Land', 'land_id', 'id');
    }

    public function zone()
    {
        return $this->belongsTo('App\Modules\Land\Models\Zone', 'zone_id', 'id');
    }

    public function mowza()
    {
        return $this->belongsTo('App\Modules\Land\Models\Area', 'area_id', 'id');
    }

    public function status()
    {
        if($this->status == 0){
            return "No";
        }
        return "Yes";
    }
}
