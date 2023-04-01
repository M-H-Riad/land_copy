<?php

namespace App\Modules\LoanApplication\Models;

use App\EmployeeProfile\Model\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanOfficeOrderApplication extends Model {

    protected $guarded = [""];
    public $timestamps = false;

    public function officeOrder() {
        return $this->belongsTo(LoanOfficeOrder::class, 'id');
    }

}
