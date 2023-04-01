<?php

namespace App\Modules\LabTest\Models;

use Illuminate\Database\Eloquent\Model;

class WaterQualityAnalysisDetails extends Model
{
    protected $table = 'lab_water_qa_details';

    public $timestamps = false;

    public function parameter()
    {
        return $this->belongsTo(LabTestingParameter::class,'parameter_id');
    }

    public function unit()
    {
        return $this->belongsTo(LabUnit::class,'unit_id');
    }
}
