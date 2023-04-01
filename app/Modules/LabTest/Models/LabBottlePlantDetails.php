<?php


namespace App\Modules\LabTest\Models;

use Illuminate\Database\Eloquent\Model;

class LabBottlePlantDetails extends Model
{
    protected $table = 'lab_bottle_plant_details';
    protected $guarded = ['id'];

    public $timestamps = false;

    public function waterQuality()
    {
        return $this->belongsTo(LabBottlePlant::class, 'lab_bottle_plant_id');
    }
}