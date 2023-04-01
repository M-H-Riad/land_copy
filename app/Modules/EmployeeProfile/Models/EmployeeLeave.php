<?php

namespace App\EmployeeProfile\Model;

use App\Modules\GeneralConfiguration\Models\LeaveType;
use App\Traits\AuditTrails;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeLeave extends Model
{
    protected $guarded = ['id'];


    use AuditTrails, SoftDeletes;

    public function type()
    {
        return $this->belongsTo(LeaveType::class);
    }
}
