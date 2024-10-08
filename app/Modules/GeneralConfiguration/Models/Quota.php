<?php

namespace App\Modules\GeneralConfiguration\Models;

use App\Traits\AuditTrails;
use Illuminate\Database\Eloquent\Model;

class Quota extends Model
{
    use AuditTrails;
    protected $guarded = ['id'];
}
