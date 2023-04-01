<?php

namespace App\Modules\LoanApplication\Models;

use App\EmployeeProfile\Model\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanSession extends Model {

    protected $guarded = ["id", 'created_at', 'updated_at'];

}
