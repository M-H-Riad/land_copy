<?php

namespace App\Modules\DeepTubewell\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AuditTrails;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeepTubewellSourceType extends Model
{
    protected $table = 'deep_tubewell_source_type';
    protected $fillable = ['id','title','status'];
    
}
