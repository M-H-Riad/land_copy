<?php

namespace App\EmployeeProfile\Model;

use App\Modules\Location\Models\District;
use App\Modules\Location\Models\Division;
use App\Modules\Location\Models\Thana;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Location\Models\PostOffice;
class EmployeeAddress extends Model
{
  protected $guarded = ['id'];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function thana()
    {
        return $this->belongsTo(Thana::class);
    }
    public function postOffice()
    {
        return $this->belongsTo(PostOffice::class,'post_office','id');
    }
}
