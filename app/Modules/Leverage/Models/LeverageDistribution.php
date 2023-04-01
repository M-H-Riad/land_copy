<?php

namespace App\Modules\Leverage\Models;

use App\Traits\AuditTrails;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeverageDistribution extends Model {

    use AuditTrails, SoftDeletes;
    //
    public $guarded = [];
    public $timestamps = false;

    public function product(){
        return $this->belongsTo(LeverageProduct::class);
    }

    public function details(){
        return $this->hasMany(LeverageDistributionDetails::class,'distribution_id');
    }


}
