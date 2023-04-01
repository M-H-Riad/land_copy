<?php

namespace App\Modules\LoanManagement\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class LoanInterests extends Model {

    //
	protected $table = 'loan_interests';
	protected $guarded = ['id','created_at','updated_at'];

	public function categoryDetails(){
		return $this->belongsTo(LoanCategories::class,'category_id','id');
	}
	public function gradeDetails(){
		return $this->belongsTo('App\EmployeeProfile\Model\Scale','grade','id');
	}

    /**
     * Calculate the Interest of those days like 30 days interest
     * @param $principalAmount
     * @param $interestRate LoanInterests - Current Interest Rate
     * @param Carbon $dateFrom
     * @param Carbon $dateTo
     * @return float|int
     */
    public static function calculateInterestAmount($principalAmount, $interestRate, $dateFrom, $dateTo)
    {
//return 5000;
        $dateFrom = new Carbon($dateFrom);
        $dateTo = new Carbon($dateTo);
        $totalDays = $dateTo->isLeapYear() ? 366 : 365;
        $daysOf = $dateTo->diffInDays($dateFrom);
        return ($principalAmount / 100 * $interestRate) / $totalDays * $daysOf;

    }
}
