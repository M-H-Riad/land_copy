<?php

namespace App\Modules\Land\Models;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    //
	protected $table = 'land_zones';
    protected $fillable = ['title', 'status'];
}
