<?php

namespace App\EmployeeProfile\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MembershipOrganization extends Model
{
    use SoftDeletes;
	protected $guarded = ['id'];
}
