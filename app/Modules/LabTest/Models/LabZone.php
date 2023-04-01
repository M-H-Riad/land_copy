<?php
namespace App\Modules\LabTest\Models;

use Illuminate\Database\Eloquent\Model;

class LabZone extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'lab_zones';

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
    protected $fillable = ['zone_name', 'zone_address', 'zone_phone'];

    public $timestamps = false;
}
