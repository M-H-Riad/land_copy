<?php

namespace App\Modules\EmployeeProfile\Models;

use App\Modules\EmployeeProfile\Models\PensionRelative;
use App\Modules\PensionApplication\Models\PensionApplicationAuthor;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{

    use SoftDeletes;

    protected $table = 'employees';
    protected $guarded = ['id'];
    protected $dates = ['date_of_birth'];

    /**
     * Accessor for Age.
     */
    public function getAgeAttribute()
    {
        return Carbon::parse($this->attributes['date_of_birth'])->age;
    }

    /**
     * Accessor for Age.
     */
    public function getNameAttribute()
    {
        return $this->attributes['first_name'] . ' ' . $this->attributes['middle_name'] . ' ' . $this->attributes['last_name'];
    }

    /**
     * Accessor for PPO_NO.
     */
    public function getPpoNoAttribute()
    {
        $data = $this->hasMany(PensionFundEmp::class);
        $result = $data->pluck('ppo_no')->toArray();
        if ($result) {
            return implode($result, ',');
        } else {
            return '';
        }
    }

    public function children()
    {
        return $this->hasMany(EmployeeChildren::class);
    }

    public function childrenBefore23Age()
    {
        return $this->hasMany(EmployeeChildren::class)->where('date_of_birth', '>=', \Carbon\Carbon::now()->subYears(23));
    }

    public function education()
    {
        return $this->hasMany(EmployeeEducation::class)->orderBy('passing_year', 'DESC');
    }

    public function training()
    {
        return $this->hasMany(EmployeeTraining::class);
    }

    public function experience()
    {
        return $this->hasOne(EmployeeWasaJobExperience::class)->orderBy('joining_date', 'desc');
    }

    public function firstExperience()
    {
        return $this->hasOne(EmployeeWasaJobExperience::class)->orderBy('joining_date', 'asc');
    }

    public function serviceExperience()
    {
        return $this->hasMany(EmployeeServiceExperience::class)->orderBy('from_date', 'DESC');
    }

    public function wasaJobExprience()
    {
        return $this->hasMany(EmployeeWasaJobExperience::class)->orderBy('joining_date', 'DESC');
      //  return $this->hasMany(EmployeeWasaJobExperience::class)->orderBy('id', 'DESC');
    }

    public function transfer()
    {
        return $this->hasMany(EmployeeTransfer::class)->orderBy('order_date', 'DESC');
//        return $this->hasMany(EmployeeTransfer::class)->orderBy('id', 'DESC');
    }

    public function membership()
    {
        return $this->hasMany(EmployeeMembership::class);
    }

    public function quarter()
    {
        return $this->hasMany(EmployeeQuarter::class)->orderBy('reference_date', 'DESC');
    }

    public function suspension()
    {
        return $this->hasMany(EmployeeSuspension::class)->orderBy('order_date', 'DESC');
    }

    public function disciplinary_record()
    {
        return $this->hasMany(EmployeeDesciplinaryRecord::class)->orderBy('ref_date', 'DESC');
    }

    public function document()
    {
        return $this->hasMany(EmployeeDocument::class);
    }

    public function address()
    {
        return $this->hasMany(EmployeeAddress::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function houseLoan()
    {
        return $this->hasOne('App\Modules\LoanManagement\Models\LoanInfo', 'id', 'house_loan_id');
    }

    public function bankName()
    {
        return $this->belongsTo(Bank::class, 'bank_name', 'id');
    }

    public function bankbranch()
    {
        return $this->belongsTo(BankBranch::class, 'branch_name', 'id');
    }

    public function pensionBankAccount()
    {
        return $this->hasMany('App\EmployeeProfile\Model\PensionBankAccount', 'employee_id', 'id');
    }

    public function relatives()
    {
        return $this->hasMany(PensionRelative::class);
    }

    public function pensionFund()
    {
        return $this->hasMany('App\EmployeeProfile\Model\PensionFundEmp', 'employee_id', 'id');
    }

    public function pensionJob()
    {
        return $this->hasMany(PensionJob::class);
    }

    public function search_by_ppo_no()
    {
        return $this->hasOne('App\EmployeeProfile\Model\PensionFundEmp', 'employee_id', 'id');
    }

    public function payrollSetting()
    {
        return $this->hasOne(EmployeePayrollSetting::class);
    }

    public function quota()
    {
        return $this->hasOne('App\Modules\GeneralConfiguration\Models\Quota', 'id', 'quota_id');
    }

    public function leave()
    {
        return $this->hasMany(EmployeeLeave::class)->orderBy('ref_date', 'desc');
    }


    public function designation()
    {
        return $this->belongsTo(Designation::class,'designation_id','id');
    }

    public function scale()
    {
        return $this->belongsTo(Scale::class);
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'office_id', 'id');
    }

    public function pensionAuthor()
    {
        return $this->hasMany(PensionApplicationAuthor::class, 'author_id');
    }

}
