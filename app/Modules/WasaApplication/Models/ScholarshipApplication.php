<?php

namespace App\Modules\WasaApplication\Models;

use Illuminate\Database\Eloquent\Model;
class ScholarshipApplication extends Model {

    protected $guarded = ['id'];
    
    public function employee()
    {
        return $this->belongsTo('App\EmployeeProfile\Model\Employee','employee_id','id');
    }
    
    public function exam()
    {
        return $this->belongsTo('App\Modules\WasaApplication\Models\EducationExam','education_exam_id','id');
    }
    public function board()
    {
        return $this->belongsTo('App\Modules\WasaApplication\Models\EducationBoard','education_board_id','id');
    }
    public function group()
    {
        return $this->belongsTo('App\Modules\WasaApplication\Models\EducationGroup','education_group_id','id');
    }

}
