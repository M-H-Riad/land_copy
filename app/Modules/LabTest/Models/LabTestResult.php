<?php

namespace App\Modules\LabTest\Models;

use Illuminate\Database\Eloquent\Model;

class LabTestResult extends Model {

    public $timestamps = false;
    protected $guarded = [];

    public function parameter()
    {
        return $this->belongsTo(LabTestingParameter::class,'parameter_id');
    }

    public function wss()
    {
        return $this->belongsTo(LabWaterSampleSource::class,'wss_id');
    }

    public function lab()
    {
        return $this->belongsTo(Lab::class);
    }

    public function zone()
    {
        return $this->belongsTo(LabZone::class);
    }

    public function pump()
    {
        return $this->belongsTo(LabPump::class);
    }

    public function institute()
    {
        return $this->belongsTo(LabInstitute::class);
    }

    public function dma()
    {
        return $this->belongsTo(LabDma::class);
    }

}
