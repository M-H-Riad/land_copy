<?php

namespace App\Modules\LabTest\Models;

use Illuminate\Database\Eloquent\Model;

class LabTestingParameter extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'lab_testing_parameters';

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
