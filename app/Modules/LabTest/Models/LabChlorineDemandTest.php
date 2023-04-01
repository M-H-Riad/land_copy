<?php
/**
 * Created by PhpStorm.
 * User: nurul.islam
 * Date: 11/5/2018
 * Time: 10:25 AM
 */

namespace App\Modules\LabTest\Models;

use App\Traits\AuditTrails;
use App\User;
use Illuminate\Database\Eloquent\Model;

class LabChlorineDemandTest extends Model
{
    use AuditTrails;

    protected $table = 'lab_chlorine_demand_test';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function details()
    {
        return $this->hasMany(LabChlorineDemandTestDetails::class, 'lab_chlorine_demand_test_id');
    }

    public function tableHead()
    {
        return $this->hasMany(LabTestTableHead::class, 'lab_chlorine_demand_test_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function concentration()
    {
        return $this->hasOne(LabChlorineDemandTestConcentration::class, 'lab_chlorine_demand_test_id');
    }

    public function sample()
    {
        return $this->hasMany(LabChlorineDemandSampleCharacteristic::class, 'lab_chlorine_demand_test_id');
    }

}