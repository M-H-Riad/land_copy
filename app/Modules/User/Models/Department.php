<?php

namespace App\Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AuditTrails;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    protected $table = 'departments';
    protected $fillable = ['id','old_id','department_name','department_name_bangla','location','department_group_id','status'];
    
}