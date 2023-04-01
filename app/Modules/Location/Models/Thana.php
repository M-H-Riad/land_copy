<?php

namespace App\Modules\Location\Models;

use Illuminate\Database\Eloquent\Model;

class Thana extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /* Relation(s) */

    /**
     * A zone belongs to a city
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo('App\Modules\Location\Models\District', 'city_id', 'id');
    }

    /**
    * An product belongs to a pickup_location
    */
}
