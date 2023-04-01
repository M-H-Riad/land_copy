<?php

namespace App\EmployeeProfile\Model;

use App\Modules\EmployeeProfile\Models\PensionRelative;
use App\Modules\Pension\Models\PensionMonthly;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PensionFundEmp extends Model {

    use SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'pension_fund_emp';

    public function pensio_type() {
        return $this->belongsTo('App\EmployeeProfile\Model\PensionType', 'pension_type_id', 'id');
    }

    public function pension_type() {
        return $this->belongsTo(PensionType::class);
    }

    public function employee() {
        return $this->belongsTo('App\EmployeeProfile\Model\Employee', 'employee_id', 'id');
    }

    public function relatives() {
        return $this->hasMany('App\Modules\EmployeeProfile\Models\PensionRelative', 'employee_id', 'employee_id');
    }

    public function pensionJob() {
        return $this->hasMany(PensionJob::class, 'employee_id', 'employee_id');
    }
    public function pensionBank() {
        return $this->hasMany(PensionBankAccount::class, 'employee_id', 'employee_id');
    }
    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable())->select('ppo_no');
    }
    public function all_monthly_of_an_emp(){
        return $this->hasMany(PensionMonthly::class, 'employee_id', 'employee_id');
    }
    public function monthlyPensionDeduction(){
        return $this->hasOne(\App\Modules\Pension\Models\PensionDeduction::class, 'employee_id', 'employee_id')->where('status',1);
    }
}
