<?php

namespace App\Modules\LoanManagement\Models;

use App\EmployeeProfile\Model\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanOneTimeDeposit extends Model {

    use \App\Traits\AuditTrails,SoftDeletes;
    protected $table = 'loan_one_time_deposit';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function employee() {
        return $this->belongsTo(Employee::class);
    }

}
