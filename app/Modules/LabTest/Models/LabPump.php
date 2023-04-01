<?php

namespace App\Modules\LabTest\Models;

use Illuminate\Database\Eloquent\Model;

class LabPump extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'lab_pumps';

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
    protected $fillable = ['pump_name', 'pump_address', 'pump_phone','zone_id'];

    public $timestamps = false;
    
}
