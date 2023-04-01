<?php

namespace App\Modules\Land\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AuditTrails;
use Illuminate\Database\Eloquent\SoftDeletes;

class KhajnaOffice extends Model
{
    use SoftDeletes, AuditTrails;
    protected $table = 'khajna_office';
    protected $guarded = [];
}
