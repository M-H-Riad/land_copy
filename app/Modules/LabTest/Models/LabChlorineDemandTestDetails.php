<?php
/**
 * Created by PhpStorm.
 * User: nurul.islam
 * Date: 11/5/2018
 * Time: 10:40 AM
 */

namespace App\Modules\LabTest\Models;

use Illuminate\Database\Eloquent\Model;

class LabChlorineDemandTestDetails extends Model
{
    protected $table = 'lab_chlorine_demand_test_details';
    protected $guarded = ['id'];

    public $timestamps = false;

    public function chlorineDemandTest()
    {
        return $this->belongsTo(LabChlorineDemandTest::class, 'lab_chlorine_demand_test_id');
    }

    public function parameter()
    {
        return $this->belongsTo(LabTestingParameter::class,'test_parameter_id');
    }

    public function unit()
    {
        return $this->belongsTo(LabUnit::class,'test_parameter_unit_id');
    }
}