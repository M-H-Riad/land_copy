<?php

namespace App\Modules\Land\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    //
	protected $table = 'land_properties';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    
    /**
     * Get the type of the property.
     */
    public function propertyType()
    {
        return $this->belongsTo('App\Modules\Land\Models\PropertyType', 'property_type_id', 'id');
    }
    
    /**
     * Get the land of the property.
     */
    public function land()
    {
        return $this->belongsTo('App\Modules\Land\Models\Land', 'land_id', 'id');
    }

}
