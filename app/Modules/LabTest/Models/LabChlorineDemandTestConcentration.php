<?php
/**
 * Created by PhpStorm.
 * User: nurul.islam
 * Date: 11/5/2018
 * Time: 10:28 AM
 */

namespace App\Modules\LabTest\Models;

use Illuminate\Database\Eloquent\Model;

class LabChlorineDemandTestConcentration extends Model
{
    protected $table = 'lab_chlorine_demand_test_concentration';
    protected $guarded = ['id'];

    public $timestamps = false;

    public function chlorineDemandTest()
    {
        return $this->belongsTo(LabChlorineDemandTest::class, 'lab_chlorine_demand_test_id');
    }

    public function chlorineUnit()
    {
        return $this->belongsTo(LabUnit::class, 'unit_id_for_chlorine');
    }

    public function volumeUnit()
    {
        return $this->belongsTo(LabUnit::class, 'unit_id_for_volume');
    }

    public function beforeExperimentUnit()
    {
        return $this->belongsTo(LabUnit::class, 'unit_id_for_before_experiment');
    }

    public function afterExperimentUnit()
    {
        return $this->belongsTo(LabUnit::class, 'unit_id_for_after_experiment');
    }

    public function breakPointUnit()
    {
        return $this->belongsTo(LabUnit::class, 'unit_of_break_point');
    }
}