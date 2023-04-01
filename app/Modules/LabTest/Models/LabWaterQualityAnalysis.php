<?php
/**
 * Created by PhpStorm.
 * User: nurul.islam
 * Date: 12/12/2018
 * Time: 2:45 PM
 */

namespace App\Modules\LabTest\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class LabWaterQualityAnalysis extends Model
{
    protected $table = 'lab_water_quality_analysis';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function details()
    {
        return $this->hasMany(LabWaterQualityAnalysisDetails::class, 'lab_water_quality_analysis_id');
    }

    public function tableHead()
    {
        return $this->hasMany(LabWaterQualityAnalysisHead::class, 'lab_water_quality_analysis_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}