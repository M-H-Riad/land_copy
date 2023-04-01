<?php

namespace App\EmployeeProfile\Model;

use Illuminate\Database\Eloquent\Model;

class EmployeeEducation extends Model
{
      protected $guarded = ['id'];

      public function qualification()
      {
          return $this->belongsTo(Qualification::class);
      }
}
