<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Modules\LabTest\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of LabParameretStandardValue
 *
 * @author johnny
 */
class LabParameretStandardValue extends Model {

    protected $table = 'lab_parameter_standard_values';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function parameter() {
        return $this->belongsTo(LabTestingParameter::class, 'parameter_id');
    }

    public function unit() {
        return $this->belongsTo(LabUnit::class, 'unit_id');
    }

}
