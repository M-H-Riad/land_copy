<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Modules\LabTest\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of CustomWaterSampleTestParameter
 *
 * @author johnny
 */
class CustomWaterSampleTestParameter extends Model {

    protected $table = 'custom_water_sample_test_parameters';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function headValue() {
        return $this->hasMany(CustomWaterSampleTestValue::class, 'custom_water_sample_test_parameter_id');
    }

    public function parameter() {
        return $this->belongsTo(LabTestingParameter::class, 'parameter_id');
    }

    public function unit() {
        return $this->belongsTo(LabUnit::class, 'unit_id');
    }

}
