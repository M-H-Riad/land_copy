<?php
/**
 * Created by PhpStorm.
 * User: nurul.islam
 * Date: 12/12/2018
 * Time: 2:45 PM
 */

namespace App\Modules\LabTest\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class WaterSampleTest extends Model
{
    protected $table = 'lab_water_sample_test';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function details()
    {
        return $this->hasMany(WaterSampleTestDetails::class, 'lab_water_sample_test_id');
    }

    public function tableHead()
    {
        return $this->hasMany(WaterSampleTableHead::class, 'lab_water_sample_test_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}