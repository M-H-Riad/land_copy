<?php

namespace App\Modules\LabTest\Models;

use App\Traits\AuditTrails;
use Illuminate\Database\Eloquent\Model;

class WaterQualityAnalysis extends Model
{
    use AuditTrails;
    protected $table = 'lab_water_qa';

    protected $guarded = [];
    protected $dates = ['test_date'];

    public function details()
    {
        return $this->hasMany(WaterQualityAnalysisDetails::class,'water_qa_id');
    }

    public function chemicalDosing()
    {
        return $this->hasMany(WaterQualityAnalysisChemicalDosing::class,'water_qa_id');
    }
}
