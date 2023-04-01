<?php

namespace App\Modules\LabTest\Models;

use Illuminate\Database\Eloquent\Model;

class MorningWaterAnalysisDetails extends Model
{
    protected $table = 'lab_morning_water_analysis_details';
    protected $guarded = ['id'];

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
