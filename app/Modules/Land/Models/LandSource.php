<?php

namespace App\Modules\Land\Models;

use Illuminate\Database\Eloquent\Model;

class LandSource extends Model
{
    //
	protected $table = 'land_sources';
    protected $fillable = ['title', 'status'];
}
