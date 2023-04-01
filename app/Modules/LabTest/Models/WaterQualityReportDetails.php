<?php


namespace App\Modules\LabTest\Models;

use Illuminate\Database\Eloquent\Model;

class WaterQualityReportDetails extends Model
{
    protected $table = 'lab_water_quality_report_details';
    protected $guarded = ['id'];

    public $timestamps = false;

    public function waterQuality()
    {
        return $this->belongsTo(WaterQualityReport::class, 'lab_water_quality_report_id');
    }

    public function parameter()
    {
        return $this->belongsTo(LabTestingParameter::class, 'parameter_id');
    }

    public function unit()
    {
        return $this->belongsTo(LabUnit::class, 'unit_id');
    }
}