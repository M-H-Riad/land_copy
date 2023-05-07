<?php

namespace App\Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AuditTrails;
use Illuminate\Database\Eloquent\SoftDeletes;

class Designation extends Model
{
    protected $table = 'designations';
    protected $fillable = ['id','title','ranking_id','old_id','reference_id','status'];
    
}