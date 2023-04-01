<?php

namespace App\Modules\LoanManagement\Models;

use App\EmployeeProfile\Model\Employee;
use App\Traits\AuditTrails;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanInfo extends Model {

    use AuditTrails, SoftDeletes;
	protected $table = 'loan_info';
	protected $guarded = ['id','created_at','updated_at'];

	public function ledgers()
    {
	    return $this->hasMany(LoanLedger::class,'loan_id');
    }

	public function employee()
    {
	    return $this->belongsTo(Employee::class);
    }
	public function category()
    {
	    return $this->belongsTo(LoanCategories::class,'loan_category_id','id');
    }
}
