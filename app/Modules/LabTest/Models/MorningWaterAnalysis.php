<?php

namespace App\Modules\LabTest\Models;

use App\Traits\AuditTrails;
use App\User;
use Illuminate\Database\Eloquent\Model;

class MorningWaterAnalysis extends Model
{
    use AuditTrails;
    protected $table = 'lab_morning_water_analysis';

    protected $guarded = ['id'];
    protected $dates = ['test_date'];

    public function details()
    {
        return $this->hasMany(MorningWaterAnalysisDetails::class, 'morning_water_analysis_id');
    }

    public function chemicalDosing()
    {
        return $this->hasMany(MorningWaterChemicalDosing::class, 'morning_water_analysis_id');
    }

    public function productionLevel()
    {
        return $this->hasOne(MorningWaterProductionLevel::class, 'morning_water_analysis_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
