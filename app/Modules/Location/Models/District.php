<?php

namespace App\Modules\Location\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /* Relation(s) */

    /**
     * A city has many zones
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */


    /**
     * A city belongs to a state
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function state()
    {
        return $this->belongsTo('App\Modules\Location\Models\Division', 'state_id', 'id');
    }

}
