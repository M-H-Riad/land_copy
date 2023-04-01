<?php

namespace App\Modules\Leverage\Models;

use App\EmployeeProfile\Model\Employee;
use App\Traits\AuditTrails;
use Illuminate\Database\Eloquent\Model;

class LeverageDistributionDetails extends Model {

    use AuditTrails;
    public $guarded = [];
    public $timestamps = false;

    public function distribution(){
        return $this->belongsTo(LeverageDistribution::class,'distribution_id');
    }

    public function employee(){
        return $this->belongsTo(Employee::class);
    }
}
