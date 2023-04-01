<?php

namespace App\Modules\Pension\Models;

use App\EmployeeProfile\Model\Employee;
use App\EmployeeProfile\Model\PensionBankAccount;
use App\EmployeeProfile\Model\PensionFundEmp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PensionMonthly extends Model {
    //
    use SoftDeletes;
	protected $table = 'pension_monthly';
	protected $guarded = ['id', 'created_at', 'updated_at'];

	public function bank(){
		return $this->belongsTo(PensionBankAccount::class,'pension_bank_account_id','id');
	}
	public function employee(){
		return $this->belongsTo(Employee::class,'employee_id','id');
	}
	public function pensionJob() {
		return $this->hasMany('App\EmployeeProfile\Model\PensionJob','employee_id','employee_id');
	}

	public function pension_fund_emp(){
	    return $this->belongsTo(PensionFundEmp::class);
    }
}
