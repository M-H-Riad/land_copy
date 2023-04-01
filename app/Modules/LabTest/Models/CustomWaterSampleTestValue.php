<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Modules\LabTest\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of CustomWaterSampleTestValue
 *
 * @author johnny
 */
class CustomWaterSampleTestValue extends Model {

    protected $table = 'custom_water_sample_test_values';
    protected $guarded = ['id'];
    public $timestamps = false;

}
