<?php


namespace App\Modules\LabTest\Models;

use Illuminate\Database\Eloquent\Model;

class WaterQualityReportHead extends Model
{
    protected $table = 'lab_water_quality_report_head';
    protected $guarded = ['id'];

    public $timestamps = false;

    public function waterQualityReport()
    {
        return $this->belongsTo(WaterQualityReport::class, 'lab_water_quality_report_id');
    }
}