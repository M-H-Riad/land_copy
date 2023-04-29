<?php

namespace App;

use App\Traits\SmsApi;
use App\Modules\PensionApplication\Models\PensionApplicationAuthor;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use  Notifiable, SmsApi;
    use EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name','full_name_ban','email', 'password', 'user_name', 'employee_id','pf_no','office_id','department_id','designation_id','phone','remember_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * A user has many role but initially loaded a has one role
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function role()
    {
        return $this->hasOne('App\Modules\User\Models\RoleUser', 'user_id');
    }


    /**
     * A user can be belongs to a Stakeholder except the System User
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stakeholder()
    {
        return $this->belongsTo('App\Modules\Stakeholder\Models\Stakeholder');
    }

    public function sendSMS($msisdn, $sms)
    {
        return $this->sendCustomMessage($msisdn, $sms);
    }

    public function pensionAuthor()
    {
        return $this->hasMany(PensionApplicationAuthor::class, 'author_id', 'employee_id');
    }
    
    public function hods() {
        return $this->hasMany(Modules\EmployeeProfile\Models\EmployeeDepartmentHead::class, 'employee_id', 'employee_id');
    }
    
    public function waitingLoanApplications() {
        return $this->hasOne(Modules\LoanApplication\Models\LoanApprove::class, 'approver_id', 'employee_id')->whereIn('approver_type',[LOAN_APPROVER_WITNESS,LOAN_APPROVER_GUARANTOR])->whereStatus(LOAN_STATUS_PENDING);
    }
    
    public function loanApprover() {
        return $this->hasOne(Modules\LoanApplication\Models\LoanCommittee::class, 'employee_id', 'employee_id')->whereStatus('Active');
    }
    
    public function isLoanApproverLDA() {
        return $this->hasOne(Modules\LoanApplication\Models\LoanCommittee::class, 'employee_id', 'employee_id')->whereUserType(LOAN_APPROVER_LDA)->whereStatus('Active');
    }

}
