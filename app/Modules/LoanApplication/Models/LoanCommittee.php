<?php


namespace App\Modules\LoanApplication\Models;


use App\EmployeeProfile\Model\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanCommittee extends Model
{
    protected $guarded = [""];

    public function employee(){
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}