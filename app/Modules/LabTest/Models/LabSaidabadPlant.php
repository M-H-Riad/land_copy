<?php


namespace App\Modules\LabTest\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class LabSaidabadPlant extends Model
{
    protected $table = 'lab_saidabad_plant';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function details()
    {
        return $this->hasMany(LabSaidabadPlantDetails::class, 'lab_saidabad_plant_id');
    }

    public function tableHead()
    {
        return $this->hasMany(LabSaidabadPlantHead::class, 'lab_saidabad_plant_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}