<?php

namespace App\Modules\LabTest\Models;

use Illuminate\Database\Eloquent\Model;

class MorningWaterProductionLevel extends Model
{
    protected $table = 'lab_morning_water_production_level';

    protected $guarded = ['id'];

    public $timestamps = false;
}
