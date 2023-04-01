<?php
/**
 * Created by PhpStorm.
 * User: nurul.islam
 * Date: 12/12/2018
 * Time: 2:49 PM
 */

namespace App\Modules\LabTest\Models;

use Illuminate\Database\Eloquent\Model;

class LabWaterQualityAnalysisDetails extends Model
{
    protected $table = 'lab_water_quality_analysis_details';
    protected $guarded = ['id'];

    public $timestamps = false;

    public function waterQuality()
    {
        return $this->belongsTo(LabWaterQualityAnalysis::class, 'lab_water_quality_analysis_id');
    }


}