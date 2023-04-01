<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Modules\LabTest\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

/**
 * Description of CustomWaterSampleTest
 *
 * @author johnny
 */
class CustomWaterSampleTest extends Model {

    protected $table = 'custom_water_sample_tests';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function parameters() {
        return $this->hasMany(CustomWaterSampleTestParameter::class, 'custom_water_sample_test_id');
    }

    public function tableHead() {
        return $this->hasMany(CustomWaterSampleTestHead::class, 'custom_water_sample_test_id');
    }

    public function createdBy() {
        return $this->belongsTo(User::class, 'created_by');
    }

}
