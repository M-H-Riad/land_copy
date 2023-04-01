<?php

namespace App\Modules\Pension\Models;
use App\Modules\Pension\Models\PensionDeductionLedgers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class PensionDeduction extends Model {
	use SoftDeletes;
	protected $table = 'pension_deductions';
	protected $guarded = ['id', 'created_at', 'updated_at'];

	public function pensionType() {
		return $this->belongsTo('App\EmployeeProfile\Model\PensionType', 'pension_type_id', 'id');
	}
	public function ledgers(){
		return $this->hasMany(PensionDeductionLedgers::class,'deduction_id','id');
	}
}
