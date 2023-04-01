<?php

namespace App\Modules\LoanApplication\Models;

use App\EmployeeProfile\Model\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanOfficeOrder extends Model {

    protected $guarded = ["id", 'created_at', 'updated_at'];

    public function session() {
        return $this->belongsTo(Employee::class);
    }

    public function applications() {
        return $this->hasMany(LoanOfficeOrderApplication::class);
    }

}
