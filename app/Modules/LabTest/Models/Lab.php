<?php

namespace App\Modules\LabTest\Models;

use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'labs';

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
    protected $fillable = ['lab_name', 'address', 'phone', 'email', 'lab_incharge_name', 'designation', 'joining_date', 'mobile'];

    
}
