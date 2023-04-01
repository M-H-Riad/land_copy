<?php

namespace App\Modules\Land\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyType extends Model
{
	protected $table = 'land_property_types';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
}
