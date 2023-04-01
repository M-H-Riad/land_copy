<?php

namespace App\Modules\LoanApplication\Models;

use App\EmployeeProfile\Model\Employee;
use App\Modules\LoanManagement\Models\LoanCategories;
use Illuminate\Database\Eloquent\Model;

class LoanApplication extends Model {

    protected $guarded = [];

    public function guarantorEmployee() {
        return $this->hasOne(Employee::class, 'id', 'guarantor');
    }

    public function witnessEmployee1() {
        return $this->hasOne(Employee::class, 'id', 'witness_1');
    }

    public function witnessEmployee2() {
        return $this->hasOne(Employee::class, 'id', 'witness_2');
    }

    public function loanApproves() {
        return $this->hasMany(LoanApprove::class);
    }

    public function loanApprover() {
        return $this->hasOne(LoanApprove::class)->where('approver_id', auth()->user()->employee_id)->whereStatus(LOAN_STATUS_PENDING);
    }

    public function pandingApprovals() {
        return $this->hasMany(LoanApprove::class)->whereIn('approver_type', [LOAN_APPROVER_HOD, LOAN_APPROVER_ADMIN, LOAN_APPROVER_AS, LOAN_APPROVER_DS, LOAN_APPROVER_SECRETARY, LOAN_APPROVER_MD, LOAN_APPROVER_DMD, LOAN_APPROVER_DS_ADMIN, LOAN_APPROVER_LDA])->whereStatus(LOAN_STATUS_PENDING);
    }

    public function lastPandingApproval() {
        return $this->hasOne(LoanApprove::class)->whereStatus(LOAN_STATUS_PENDING)->latest();
    }

    public function guarantorApproval() {
        return $this->hasOne(LoanApprove::class)->whereApproverType(LOAN_APPROVER_GUARANTOR)->whereStatus(LOAN_STATUS_APPROVED);
    }

    public function witnessApprovals() {
        return $this->hasMany(LoanApprove::class)->whereApproverType(LOAN_APPROVER_WITNESS)->whereStatus(LOAN_STATUS_APPROVED);
    }

    public function committeeApprovals() {
        return $this->hasMany(LoanApprove::class)->whereApproverType(LOAN_APPROVER_COMMITTEE)->whereStatus(LOAN_STATUS_APPROVED);
    }

    public function committeeRejects() {
        return $this->hasMany(LoanApprove::class)->whereApproverType(LOAN_APPROVER_COMMITTEE)->whereStatus(LOAN_STATUS_REJECTED);
    }

    public function pendingReply() {
        return $this->hasOne(LoanApprove::class)->whereStatus(LOAN_STATUS_APPROVED)->whereNeedReply(1);
    }

    public function commentsForReplier() {
        return $this->hasMany(LoanComment::class)->whereCommentFor(auth()->user()->employee_id);
    }

    public function comments() {
        return $this->hasMany(LoanComment::class);
    }

    public function pendingComments() {
        return $this->hasMany(LoanComment::class)->whereCommentFor(auth()->user()->employee_id)->whereNull('message');
    }

    public function scopeIsApprover($query) {
        return $query->whereHas('loanApprove', function ($q) {
                    $q->where('approver_id', auth()->user()->employee_id);
                });
    }

    public function loanCategory() {
        return $this->belongsTo(LoanCategories::class, 'loan_category_id', 'id');
    }

    public function employee() {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function officeOrderApplication() {
        return $this->belongsTo(LoanOfficeOrderApplication::class,'id');
    }

}
