<?php
/**
 * Created by PhpStorm.
 * User: nurul.islam
 * Date: 11/5/2018
 * Time: 10:35 AM
 */

namespace App\Modules\LabTest\Models;

use Illuminate\Database\Eloquent\Model;

class LabChlorineDemandSampleCharacteristic extends Model
{
    protected $table = 'lab_chlorine_demand_sample_characteristic';
    protected $guarded = ['id'];

    public $timestamps = false;

    public function chlorineDemandTest()
    {
        return $this->belongsTo(LabChlorineDemandTest::class, 'lab_chlorine_demand_test_id');
    }

    public function parameter()
    {
        return $this->belongsTo(LabTestingParameter::class,'parameter_id');
    }

    public function unit()
    {
        return $this->belongsTo(LabUnit::class,'unit_id');
    }
}