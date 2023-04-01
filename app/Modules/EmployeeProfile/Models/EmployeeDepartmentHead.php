<?php
/**
 * Created by PhpStorm.
 * User: nurul.islam
 * Date: 11/8/2018
 * Time: 4:02 PM
 */

namespace App\Modules\EmployeeProfile\Models;

use App\EmployeeProfile\Model\Department;
use App\EmployeeProfile\Model\Employee;
use Illuminate\Database\Eloquent\Model;

class EmployeeDepartmentHead extends Model
{
    protected $table = 'employee_department_head';
    protected $guarded = ['id'];

    public $timestamp = false;

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}