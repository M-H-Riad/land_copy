<?php


namespace App\Modules\LoanApplication\Models;


use App\EmployeeProfile\Model\Employee;
use App\Modules\LoanManagement\Models\LoanCategories;
use Illuminate\Database\Eloquent\Model;

class LoanApprove extends Model
{
    protected $guarded = [];

    public function loanApplication(){
        return $this->belongsTo(LoanApplication::class, "loan_application_id", "id");
    }

    public function approver(){
        return $this->belongsTo(Employee::class, 'approver_id', 'id');
    }
    public function employee(){
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
    public function scopeApproveCount($query, $loanId){
        return $query->where('loan_application_id', $loanId)
            ->whereIn("approver_type", ["Witness","Guarantor"])
            ->where('status', 'Approved')->count();

    }
    public function loanCategory(){
        return $this->belongsTo(LoanCategories::class, 'loan_category_id', 'id');
    }

    /**
     * @param $query
     * @param $loanId
     * @return mixed
     */
    public function scopeAdminPendingLoan($query, $loanId){
        return $query->where("loan_application_id", $loanId)
            ->where("approver_type", "Admin")
            ->where("status", "Pending");
    }

    public function scopeAsUserPendingLoan($query, $loanId){
        return $query->where("loan_application_id", $loanId)
            ->where("approver_type", LOAN_APPROVER_AS)
            ->where("status", LOAN_STATUS_PENDING);
    }

    public function scopeDsUserPendingLoan($query, $loanId){
        return $query->where("loan_application_id", $loanId)
            ->where("approver_type", LOAN_APPROVER_DS)
            ->where("status", LOAN_STATUS_PENDING);
    }

    public function scopeSecretaryPendingLoan($query, $loanId){
        return $query->where("loan_application_id", $loanId)
            ->where("approver_type", LOAN_APPROVER_SECRETARY)
            ->where("status", LOAN_STATUS_PENDING);
    }
    public function scopeMdPendingLoan($query, $loanId){
        return $query->where("loan_application_id", $loanId)
            ->where("approver_type", LOAN_APPROVER_MD)
            ->where("status", LOAN_STATUS_PENDING);
    }
    public function scopeDmdPendingLoan($query, $loanId){
        return $query->where("loan_application_id", $loanId)
            ->where("approver_type", LOAN_APPROVER_DMD)
            ->where("status", LOAN_STATUS_PENDING);
    }
}