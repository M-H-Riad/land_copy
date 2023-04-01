<?php


namespace App\Traits;


use App\Modules\LoanApplication\Models\LoanApprovalHistory;
use Illuminate\Support\Facades\Log;

trait LoanApprovalTrait
{
    public function approvalHistoryUpdate($loanApprove){
        try{

            $loanApprovalHistory = new LoanApprovalHistory();
            $loanApprovalHistory->loan_application_id = $loanApprove->loan_application_id;
            $loanApprovalHistory->loan_approve_id = $loanApprove->id;
            $loanApprovalHistory->approver_type = $loanApprove->approver_type;
            $loanApprovalHistory->approved_by = $loanApprove->approver_id;
            $loanApprovalHistory->remarks = $loanApprove->remarks;
            $loanApprovalHistory->loan_status = $loanApprove->status;
            $loanApprovalHistory->save();

        }catch (\Exception $exception){

            Log::error("LoanApprovalTrait::approvalHistoryUpdate() " . $exception);
        }
    }

}