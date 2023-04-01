<?php

namespace App\EmployeeProfile\Model;

use App\Traits\AuditTrails;
use Illuminate\Database\Eloquent\Model;

class EmployeeChildren extends Model
{
    use AuditTrails;
    protected $guarded = ['id'];
}
