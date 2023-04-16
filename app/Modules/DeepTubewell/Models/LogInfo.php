<?php

namespace App\Modules\DeepTubewell\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AuditTrails;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogInfo extends Model
{
    
    protected $table = 'log_info';
    protected $fillable = ['id','user_id','module_name','menu_name','operation'];
    
}
