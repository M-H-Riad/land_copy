<?php

namespace App\EmployeeProfile\Model;

use Illuminate\Database\Eloquent\Model;

class DepartmentGroup extends Model
{
    protected $guarded = ['id'];
    protected $table = 'department_group';
    public $timestamps = false;
}
