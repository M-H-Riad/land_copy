<?php

namespace App\Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArrDedOffAlert extends Model
{
    use SoftDeletes ;
    protected $table = "arr_ded_off_alert";
    protected $dates = ['deleted_at'];
}
