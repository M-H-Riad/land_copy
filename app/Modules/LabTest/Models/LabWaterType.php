<?php

namespace App\Modules\LabTest\Models;
use Illuminate\Database\Eloquent\Model;

class LabWaterType extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'lab_water_types';

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
    protected $fillable = ['wt_description'];

    public $timestamps = false;
}
