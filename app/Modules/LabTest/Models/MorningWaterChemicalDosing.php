<?php

namespace App\Modules\LabTest\Models;

use Illuminate\Database\Eloquent\Model;

class MorningWaterChemicalDosing extends Model
{
    protected $table = 'lab_morning_water_chemical_dosing';
    protected $guarded = ['id'];

    public $timestamps = false;

    public function chemical()
    {
        return $this->belongsTo(LabChemicals::class,'chemical_id');
    }

}
