<?php

namespace App\EmployeeProfile\Model;

use Illuminate\Database\Eloquent\Model;

class EmployeeDocument extends Model
{
       protected $guarded = ['id'];


    public function file_type()
    {
        return $this->belongsTo(FileType::class);
    }
}
