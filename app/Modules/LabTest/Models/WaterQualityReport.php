<?php


namespace App\Modules\LabTest\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class WaterQualityReport extends Model
{
    protected $table = 'lab_water_quality_report';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function details()
    {
        return $this->hasMany(WaterQualityReportDetails::class, 'lab_water_quality_report_id');
    }

    public function tableHead()
    {
        return $this->hasMany(WaterQualityReportHead::class, 'lab_water_quality_report_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}