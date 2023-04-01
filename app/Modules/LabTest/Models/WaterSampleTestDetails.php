<?php
/**
 * Created by PhpStorm.
 * User: nurul.islam
 * Date: 12/12/2018
 * Time: 2:49 PM
 */

namespace App\Modules\LabTest\Models;

use Illuminate\Database\Eloquent\Model;

class WaterSampleTestDetails extends Model
{
    protected $table = 'lab_water_sample_test_details';
    protected $guarded = ['id'];

    public $timestamps = false;

    public function waterSample()
    {
        return $this->belongsTo(WaterSampleTest::class, 'lab_water_sample_test_id');
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