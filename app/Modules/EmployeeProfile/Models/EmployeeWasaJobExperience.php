<?php

namespace App\EmployeeProfile\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeWasaJobExperience extends Model
{
    use SoftDeletes;
    protected $guarded = [];


    public function designation()
    {
        return $this->belongsTo(Designation::class);
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
        return $this->belongsTo(Department::class,'office_id','id');
    }
}
