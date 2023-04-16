<?php

namespace App\Modules\DeepTubewell\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AuditTrails;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeepTubewellSource extends Model
{
    protected $table = 'deep_tubewell_source';
    protected $fillable = ['id','title'];
    
}