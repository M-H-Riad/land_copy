<?php

namespace App\Modules\Location\Models;

use Illuminate\Database\Eloquent\Model;

class QuarterLocation extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
   // protected $table = 'quarter_locations';

    /* Relation(s) */

    /**
     * A state has many cities
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
}
