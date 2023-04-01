<?php


namespace App\Modules\LabTest\Models;

use Illuminate\Database\Eloquent\Model;

class LabBottlePlantHead extends Model
{
    protected $table = 'lab_bottle_plant_head';
    protected $guarded = ['id'];

    public $timestamps = false;

    public function waterQualityAnalysis()
    {
        return $this->belongsTo(LabBottlePlant::class, 'lab_bottle_plant_id');
    }

    public function parameter()
    {
        return $this->belongsTo(LabTestingParameter::class, 'head_parameter_id', 'id');
    }

    public function unit()
    {
        return $this->belongsTo(LabUnit::class, 'parameter_unit_id');
    }
}