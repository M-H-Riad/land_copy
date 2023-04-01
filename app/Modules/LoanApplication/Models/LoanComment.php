<?php

namespace App\Modules\LoanApplication\Models;

use App\EmployeeProfile\Model\Employee;
use Illuminate\Database\Eloquent\Model;

class LoanComment extends Model {

    protected $guarded = [];

    public function loanApplication() {
        return $this->belongsTo(LoanApplication::class, "loan_application_id", "id");
    }

    public function commentBy() {
        return $this->belongsTo(Employee::class, 'comment_by', 'id');
    }

    public function commentFor() {
        return $this->belongsTo(Employee::class, 'comment_for', 'id');
    }

}
