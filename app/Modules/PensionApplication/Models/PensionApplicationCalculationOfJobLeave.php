<?php

namespace App\Modules\PensionApplication\Models;

use Illuminate\Database\Eloquent\Model;
class PensionApplicationCalculationOfJobLeave extends Model {

    protected $table = 'pension_application_calculation_of_job_leave';
    protected $guarded = ['id'];

    public function pension_application()
    {
        return $this->belongsTo(
          'App\Modules\PensionApplication\Models\PensionApplicationPart1ka',
          'pension_application_part_1_ka_id',
          'id');
    }
}
