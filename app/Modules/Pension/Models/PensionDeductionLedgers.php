<?php

namespace App\Modules\Pension\Models;
use Illuminate\Database\Eloquent\Model;

class PensionDeductionLedgers extends Model {

    protected $table = 'pension_deduction_ledgers';
    protected $guarded = ['id', 'created_at', 'updated_at'];

   

}
