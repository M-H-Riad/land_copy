<?php


namespace App\Modules\LoanApplication\Models;


use App\EmployeeProfile\Model\Employee;
use App\Modules\LoanManagement\Models\LoanCategories;
use Illuminate\Database\Eloquent\Model;

class LoanApprovalHistory extends Model
{
    protected $guarded = [];

    public function loanApplication(){
        return $this->belongsTo(LoanApplication::class, 'loan_application_id','id');
    }
    public function loanApprove(){
        return $this->belongsTo(LoanApprove::class, 'loan_approve_id','id');
    }
    public function loanCategory(){
        return $this->belongsTo(LoanCategories::class, 'loan_category_id', 'id');
    }
    public function approver(){
        return $this->belongsTo(Employee::class, 'approved_by', 'id');
    }
    public function employee(){
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}