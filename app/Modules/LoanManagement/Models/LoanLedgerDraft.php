<?php

namespace App\Modules\LoanManagement\Models;

use App\Traits\AuditTrails;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanLedgerDraft extends Model {

    use AuditTrails;
	protected $guarded = [];
	protected $dates = ['pay_date'];

    public function loan()
    {
        return $this->belongsTo(LoanInfo::class);
    }
}
