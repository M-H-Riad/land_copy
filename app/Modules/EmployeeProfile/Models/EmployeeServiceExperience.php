<?php

namespace App\EmployeeProfile\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeServiceExperience extends Model
{
    use SoftDeletes;
    protected $guarded = [];


    public function scale()
    {
        return $this->belongsTo(Scale::class);
    }
}
