<?php


namespace App\Modules\LabTest\Models;

use Illuminate\Database\Eloquent\Model;

class LabSaidabadPlantDetails extends Model
{
    protected $table = 'lab_saidabad_plant_details';
    protected $guarded = ['id'];

    public $timestamps = false;

    public function waterQuality()
    {
        return $this->belongsTo(LabSaidabadPlant::class, 'lab_saidabad_plant_id');
    }
}