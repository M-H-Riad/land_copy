<?php

namespace App\Modules\Land\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AuditTrails;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mowja extends Model
{
    use SoftDeletes, AuditTrails;
    protected $table = 'mowja_info';
    protected $guarded = [];
}
