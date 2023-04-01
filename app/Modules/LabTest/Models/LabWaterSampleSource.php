<?php

namespace App\Modules\LabTest\Models;

use Illuminate\Database\Eloquent\Model;

class LabWaterSampleSource extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'lab_water_sample_sources';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public $timestamps = false;
}
