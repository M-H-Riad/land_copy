<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Modules\LabTest\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of CustomWaterSampleTestHead
 *
 * @author johnny
 */
class CustomWaterSampleTestHead extends Model {

    protected $table = 'custom_water_sample_test_heads';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function test() {
        return $this->belongsTo(CustomWaterSampleTest::class, 'custom_water_sample_test_id', 'id');
    }

    public function head() {
        return $this->hasOne(ReportHead::class, 'id', 'report_head_id');
    }

}
