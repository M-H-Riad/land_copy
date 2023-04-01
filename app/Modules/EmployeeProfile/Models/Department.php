<?php

namespace App\EmployeeProfile\Model;

use App\Modules\Payroll\Models\IfterBillEmployee;
use App\Modules\Payroll\Models\NightAllowanceEmployee;
use App\Modules\Payroll\Models\OvertimeEmployee;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $guarded = ['id'];

    public function group(){
        return $this->belongsTo(DepartmentGroup::class,'department_group_id','id');
    }
    public function employee(){
        return $this->hasMany(Employee::class,'office_id','id')->orderBy('current_basic_pay','DESC');
    }
    public function overtimeEmployee(){
        return $this->hasMany(OvertimeEmployee::class,'office_id','id')->orderBy('designation_ranking','DESC');
    }
    public function nightAllowanceEmployee(){
        return $this->hasMany(NightAllowanceEmployee::class,'office_id','id')->orderBy('designation_ranking','DESC');
    }
    public function ifterBillEmployee(){
        return $this->hasMany(IfterBillEmployee::class,'office_id','id')->orderBy('designation_ranking','DESC');
    }
}
