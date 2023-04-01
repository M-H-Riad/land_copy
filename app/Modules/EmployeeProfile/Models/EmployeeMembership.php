<?php

namespace App\EmployeeProfile\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeMembership extends Model
{
    use SoftDeletes;
   protected $guarded = ['id'];

    public function organization()
    {
        return $this->belongsTo(MembershipOrganization::class,'membership_organization_id','id');
    }
}
