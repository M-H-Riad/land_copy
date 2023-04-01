<?php

namespace App\Modules\Location\Models;

use Illuminate\Database\Eloquent\Model;

class PostOffice extends Model
{
    protected $table = 'post_office';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /* Relation(s) */

    /**
     * A zone belongs to a city
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    /**
    * An product belongs to a pickup_location
    */

    public function thana(){
        return $this->belongsTo('App\Modules\Location\Models\Thana','thana_id','id');
    }
}
