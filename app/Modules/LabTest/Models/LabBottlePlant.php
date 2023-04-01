<?php


namespace App\Modules\LabTest\Models;

use App\User;
use App\Modules\User\Models\Module;

class LabBottlePlant extends Module
{
    protected $table = 'lab_bottle_plant';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function details()
    {
        return $this->hasMany(LabBottlePlantDetails::class, 'lab_bottle_plant_id');
    }

    public function tableHead()
    {
        return $this->hasMany(LabBottlePlantHead::class, 'lab_bottle_plant_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}