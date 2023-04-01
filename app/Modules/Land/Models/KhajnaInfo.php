<?php

namespace App\Modules\Land\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AuditTrails;
use Illuminate\Database\Eloquent\SoftDeletes;

class KhajnaInfo extends Model
{
    use SoftDeletes, AuditTrails;
    protected $guarded = [];

    public function upazila()
    {
        return $this->belongsTo('App\Modules\Land\Models\Upazila', 'upazila_id', 'id');
    }

    public function mowza()
    {
        return $this->belongsTo('App\Modules\Land\Models\Mowja', 'mowja_id', 'id');
    }

    public function khajna_office()
    {
        return $this->belongsTo('App\Modules\Land\Models\KhajnaOffice', 'khajna_office_id', 'id');
    }

    public function land()
    {
        return $this->belongsTo('App\Modules\Land\Models\Land', 'land_id', 'id');
    }
}
