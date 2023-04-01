<?php

namespace App\Modules\LabTest\Models;

use Illuminate\Database\Eloquent\Model;

class WaterQualityAnalysisChemicalDosing extends Model
{
    protected $table = 'lab_water_qa_chemical_dosing';

    public $timestamps = false;

    public function chemical()
    {
        return $this->belongsTo(LabChemicals::class,'chemical_id');
    }

}
