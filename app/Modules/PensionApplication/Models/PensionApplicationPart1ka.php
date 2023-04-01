<?php

namespace App\Modules\PensionApplication\Models;

use \App\Modules\PensionApplication\Models\PensionDataFinder;
use \App\EmployeeProfile\Model\Employee;
use Illuminate\Database\Eloquent\Model;
use \Exception;

class PensionApplicationPart1ka extends Model
{
    protected $table = 'pension_application_part_1_ka';
    protected $guarded = ['id'];

    public function employee()
    {
        return $this->belongsTo('App\EmployeeProfile\Model\Employee', 'employee_id', 'id');
    }

    public function pension_leave_details()
    {
        return $this->belongsTo('App\Modules\PensionApplication\Models\PensionApplicationCalculationOfJobLeave', 'id', 'pension_application_part_1_ka_id');
    }

    public function pensionAuthor()
    {
        return $this->hasOne(PensionApplicationAuthor::class, 'application_id');
    }
}
