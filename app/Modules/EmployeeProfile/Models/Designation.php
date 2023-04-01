<?php

namespace App\Modules\EmployeeProfile\Models;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    protected $guarded = ['id'];
    public function employee(){
        return $this->hasMany(Employee::class,'designation_id','id')->orderBy('current_basic_pay','DESC');
    }
}
