<?php

namespace App\Modules\LabTest\Models;

use Illuminate\Database\Eloquent\Model;

class LabDma extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'lab_dmas';

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
    protected $fillable = ['dma_name', 'dma_address', 'dma_phone'];

    
}
