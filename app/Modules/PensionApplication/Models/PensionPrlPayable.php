<?php
/**
 * Created by PhpStorm.
 * User: anowar
 * Date: 5/21/18
 * Time: 10:33 AM
 */

namespace App\Modules\PensionApplication\Models;


use App\EmployeeProfile\Model\Employee;
use App\Modules\Payroll\Models\PayrollMonth;
use App\Traits\AuditTrails;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PensionPrlPayable extends Model {

    use AuditTrails, SoftDeletes;
    protected $guarded = ['id'];


    public function month()
    {
        return $this->belongsTo(PayrollMonth::class);
    }
//
//    public function employee()
//    {
//        return $this->belongsTo(Employee::class);
//    }
}