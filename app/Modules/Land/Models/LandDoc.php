<?php

namespace App\Modules\Land\Models;

use Illuminate\Database\Eloquent\Model;

class LandDoc extends Model
{
    //
	protected $table = 'land_docs';
    protected $fillable = ['title', 'land_id', 'file_title', 'file_type_id', 'file_path', 'status'];

    public function file_type()
    {
        return $this->belongsTo('App\EmployeeProfile\Model\FileType', 'file_type_id', 'id');
    }
}
