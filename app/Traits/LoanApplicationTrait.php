<?php

namespace App\Traits;

use App\Modules\LoanApplication\Models\LoanApprove;
use App\Modules\LoanApplication\Models\LoanCommittee;
use App\Modules\LoanApplication\Models\LoanComment;
use App\Modules\LoanApplication\Models\LoanOfficeOrder;
use App\Modules\LoanApplication\Models\LoanOfficeOrderApplication;
use App\User;
use Log;
use DB;
use Mail;
use Exception;

trait LoanApplicationTrait {

    public function createApplicationApproval($application) {
        $statusNapprover = $this->loanStatusApproval($application);
//        dd($statusNapprover);
        try {
            $application->status = $statusNapprover['status'];
            $application->save();

            if (!is_null($statusNapprover['nextApproveType']) && count($statusNapprover['nextApprovers']) < 1) {
                return ['status' => false, 'message' => 'Next loan approver not found!'];
            }
            if (!is_null($statusNapprover['nextApproveType']) && count($statusNapprover['nextApprovers']) > 0) {
                foreach ($statusNapprover['nextApprovers'] as $nextApprover) {
                    $approver = new LoanApprove();
                    $approver->loan_application_id = $application->id;
                    $approver->step = $statusNapprover['nextApproveStep'];
                    $approver->approver_type = $statusNapprover['nextApproveType'];
                    $approver->approver_id = $nextApprover->employee_id;
                    $approver->save();
                }
            }
            return ['status' => true, 'message' => 'success'];
        } catch (\Exception $exception) {
            Log::error($exception);
            throw new Exception('Something went wrong!');
        }
    }

    public function loanStatusApproval($application) {
        switch ($application->loanApprover->step) {
            case 1:
                $status = LOAN_STATUS_WAITING_FOR_AS;
                $nextApproveStep = 2;
                $nextApproveType = LOAN_APPROVER_AS;
                $nextApprovers = LoanCommittee::whereUserType(LOAN_APPROVER_AS)->whereStatus('Active')->get();
                break;
            case 2:
                $status = LOAN_STATUS_WAITING_FOR_DS;
                $nextApproveStep = 3;
                $nextApproveType = LOAN_APPROVER_DS;
                $nextApprovers = LoanCommittee::whereUserType(LOAN_APPROVER_DS)->whereStatus('Active')->get();
                break;
            case 3:
                $status = LOAN_STATUS_WAITING_FOR_SECRETARY;
                $nextApproveStep = 4;
                $nextApproveType = LOAN_APPROVER_SECRETARY;
                $nextApprovers = LoanCommittee::whereUserType(LOAN_APPROVER_SECRETARY)->whereStatus('Active')->get();
                break;
            case 4:
                $status = LOAN_STATUS_WAITING_FOR_MD;
                $nextApproveStep = 5;
                $nextApproveType = LOAN_APPROVER_MD;
                $nextApprovers = LoanCommittee::whereUserType(LOAN_APPROVER_MD)->whereStatus('Active')->get();
                break;
            case 5:
                $status = LOAN_STATUS_WAITING_FOR_DMD;
                $nextApproveStep = 6;
                $nextApproveType = LOAN_APPROVER_DMD;
                $nextApprovers = LoanCommittee::whereUserType(LOAN_APPROVER_DMD)->whereStatus('Active')->get();
                break;
            case 6:
                $status = LOAN_STATUS_WAITING_FOR_DS_ADMIN;
                $nextApproveStep = 7;
                $nextApproveType = LOAN_APPROVER_DS;
                $nextApprovers = LoanCommittee::whereUserType(LOAN_APPROVER_DS)->whereStatus('Active')->get();
                break;
            case 7:
                $status = LOAN_PENDING_OFFICE_ORDER;
                $nextApproveStep = 8;
                $nextApproveType = LOAN_APPROVER_SECRETARY;
                $nextApprovers = LoanCommittee::whereUserType(LOAN_APPROVER_SECRETARY)->whereStatus('Active')->get();
                break;
            case 8:
                $status = LOAN_STATUS_WAITING_FOR_ACCOUNTS;
                $nextApproveStep = 9;
                $nextApproveType = LOAN_APPROVER_ACCOUNTS;
                $nextApprovers = LoanCommittee::whereUserType(LOAN_APPROVER_ACCOUNTS)->whereStatus('Active')->get();
                break;
            case 9:
                $status = LOAN_STATUS_APPROVED;
                $nextApproveType = null;
                $nextApprovers = [];
                break;
        }

        return ['status' => $status, 'nextApproveStep' => $nextApproveStep, 'nextApproveType' => $nextApproveType, 'nextApprovers' => $nextApprovers];
    }

    public function createApplicationComment($application, $request, $messageType = 'comment') {
//        $commentUser = $this->loanCommentUser($application);
//        dd($statusNapprover);
        try {
            $preApprover = LoanApprove::whereLoanApplicationId($application->id)->whereStatus(LOAN_STATUS_APPROVED)->orderBy('id', 'desc')->first();
            $preApprover->need_reply = ($messageType == 'comment') ? 1 : 0;
            $preApprover->save();

            $comment = new LoanComment();
            $comment->loan_application_id = $application->id;
            $comment->loan_approve_id = $application->lastPandingApproval->id;
            $comment->comment_user_type = ($messageType == 'comment') ? $application->loanApprover->approver_type : $preApprover->approver_type;
            $comment->comment_type = ($messageType == 'comment') ? 'comment' : 'reply';
            $comment->message = $request->message;
            $comment->comment_by = auth()->user()->employee_id;
            ($messageType == 'comment') ? $comment->comment_for = $preApprover->approver_id : null;
            $comment->save();

            return ['status' => true, 'message' => 'success'];
        } catch (\Exception $exception) {
            Log::error($exception);
            throw new Exception('Something went wrong!');
        }
    }

    public function oldLoanStatusApproval($application) {
        switch ($application->loanApprover->step) {
            case LOAN_APPROVER_WITNESS:
            case LOAN_APPROVER_GUARANTOR:
                $status = LOAN_STATUS_WAITING_FOR_HOD;
                $nextApproveType = LOAN_APPROVER_HOD;
                $nextApprovers = User::join('employee_department_head', 'employee_department_head.employee_id', 'users.employee_id')
                                ->whereDepartmentId($application->employee->office_id)->get();
                break;
            case LOAN_APPROVER_HOD:
                $status = LOAN_STATUS_WAITING_FOR_ADMIN;
                $nextApproveType = LOAN_APPROVER_ADMIN;
                $nextApprovers = LoanCommittee::whereUserType(LOAN_APPROVER_ADMIN)->whereStatus('Active')->get();
                break;
            case LOAN_APPROVER_ADMIN:
                $status = LOAN_STATUS_WAITING_FOR_COMMITTEE;
                $nextApproveType = LOAN_APPROVER_COMMITTEE;
                $nextApprovers = LoanCommittee::whereUserType(LOAN_APPROVER_COMMITTEE)->whereStatus('Active')->get();
                break;
            case LOAN_APPROVER_COMMITTEE:
                $status = LOAN_STATUS_WAITING_FOR_OFFICE_SUPER;
                $nextApproveType = LOAN_APPROVER_OFFICE_SUPER;
                $nextApprovers = LoanCommittee::whereUserType(LOAN_APPROVER_OFFICE_SUPER)->whereStatus('Active')->get();
                break;
            case LOAN_APPROVER_OFFICE_SUPER:
                $status = LOAN_STATUS_WAITING_FOR_AS;
                $nextApproveType = LOAN_APPROVER_AS;
                $nextApprovers = LoanCommittee::whereUserType(LOAN_APPROVER_AS)->whereStatus('Active')->get();
                break;
            case LOAN_APPROVER_AS:
                $status = LOAN_STATUS_WAITING_FOR_DS;
                $nextApproveType = LOAN_APPROVER_DS;
                $nextApprovers = LoanCommittee::whereUserType(LOAN_APPROVER_DS)->whereStatus('Active')->get();
                break;
            case LOAN_APPROVER_DS:
                $status = LOAN_STATUS_WAITING_FOR_SECRETARY;
                $nextApproveType = LOAN_APPROVER_SECRETARY;
                $nextApprovers = LoanCommittee::whereUserType(LOAN_APPROVER_SECRETARY)->whereStatus('Active')->get();
                break;
            case LOAN_APPROVER_SECRETARY:
                $status = LOAN_STATUS_WAITING_FOR_MD;
                $nextApproveType = LOAN_APPROVER_MD;
                $nextApprovers = LoanCommittee::whereUserType(LOAN_APPROVER_MD)->whereStatus('Active')->get();
                break;
            case LOAN_APPROVER_MD:
                $status = LOAN_STATUS_WAITING_FOR_DMD;
                $nextApproveType = LOAN_APPROVER_DMD;
                $nextApprovers = LoanCommittee::whereUserType(LOAN_APPROVER_DMD)->whereStatus('Active')->get();
                break;
            case LOAN_APPROVER_DMD:
                $status = LOAN_STATUS_WAITING_FOR_DS_ADMIN;
                $nextApproveType = LOAN_APPROVER_DS_ADMIN;
                $nextApprovers = LoanCommittee::whereUserType(LOAN_APPROVER_DS_ADMIN)->whereStatus('Active')->get();
                break;
            case LOAN_APPROVER_DS_ADMIN:
                $status = LOAN_STATUS_APPROVED; // approve in this part
                $nextApproveType = LOAN_APPROVER_LDA;
                $nextApprovers = LoanCommittee::whereUserType(LOAN_APPROVER_LDA)->whereStatus('Active')->get();
                break;
            case LOAN_APPROVER_LDA:
                $status = LOAN_STATUS_APPROVED;
                $nextApproveType = null;
                $nextApprovers = [];
                break;
            default :
                $status = LOAN_STATUS_APPROVED;
                $nextApproveType = null;
                $nextApprovers = [];
                break;
        }

        return ['status' => $status, 'nextApproveType' => $nextApproveType, 'nextApprovers' => $nextApprovers];
    }

    public function createOfficeOrderApplication($request, $applications) {

        $officeOrder = new LoanOfficeOrder();
        $officeOrder->loan_session_id = $request->loan_session_id;
        $officeOrder->memo_no = $request->memo_no;
        $officeOrder->generate_date = date('Y-m-d', strtotime($request->generate_date));
        $officeOrder->category_amount = $request->category_amount;
        $officeOrder->created_by = auth()->user()->employee_id;
        $officeOrder->save();
        foreach ($applications as $application) {            
            $officeOrderApplication = new LoanOfficeOrderApplication();
            $officeOrderApplication->loan_office_order_id = $officeOrder->id;
            $officeOrderApplication->loan_application_id = $application->id;
            $officeOrderApplication->release_percentage = $releasePercentage = ($application->loan_category_id == 1) ? 25 : 100;
            $officeOrderApplication->applied_amount = $application->loan_amount;
            $officeOrderApplication->release_amount = ($releasePercentage == 100) ? $application->loan_amount : ($application->loan_amount * $releasePercentage) / 100;
            $officeOrderApplication->created_by = auth()->user()->employee_id;
            $officeOrderApplication->save();
        }
        
        return $officeOrder;
    }

}
