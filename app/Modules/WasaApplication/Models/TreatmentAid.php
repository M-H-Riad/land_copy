<?php

namespace App\Modules\WasaApplication\Models;

use Illuminate\Database\Eloquent\Model;
class TreatmentAid extends Model {

    protected $guarded = ['id'];
    
    public function employee()
    {
        return $this->belongsTo('App\EmployeeProfile\Model\Employee','employee_id','id');
    }

}
