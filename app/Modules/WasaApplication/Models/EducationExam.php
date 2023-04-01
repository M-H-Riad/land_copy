<?php

namespace App\Modules\WasaApplication\Models;

use Illuminate\Database\Eloquent\Model;

class EducationExam extends Model {

    protected $guarded = ['id'];

    public function group() {
        return $this->hasMany('App\EducationGroup', 'education_exam_id', 'id');
    }

}
