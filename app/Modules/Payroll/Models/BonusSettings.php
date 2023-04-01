<?php

namespace App\Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BonusSettings extends Model
{
    use SoftDeletes ;
    protected $table = "bonus_settings";
    protected $dates = ['deleted_at'];
    public function scopeActive($query)
    {
        return $query->where('status','active');
    }
}
