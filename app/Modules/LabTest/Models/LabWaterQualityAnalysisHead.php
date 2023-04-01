<?php
/**
 * Created by PhpStorm.
 * User: nurul.islam
 * Date: 12/12/2018
 * Time: 2:56 PM
 */

namespace App\Modules\LabTest\Models;

use Illuminate\Database\Eloquent\Model;

class LabWaterQualityAnalysisHead extends Model
{
    protected $table = 'lab_water_quality_analysis_head';
    protected $guarded = ['id'];

    public $timestamps = false;

    public function waterQualityAnalysis()
    {
        return $this->belongsTo(LabWaterQualityAnalysis::class, 'lab_water_quality_analysis_id');
    }

    public function parameter()
    {
        return $this->belongsTo(LabTestingParameter::class, 'head_parameter_id','id');
    }

    public function unit()
    {
        return $this->belongsTo(LabUnit::class, 'parameter_unit_id');
    }
}