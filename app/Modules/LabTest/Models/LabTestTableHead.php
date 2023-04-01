<?php
/**
 * Created by PhpStorm.
 * User: nurul.islam
 * Date: 11/7/2018
 * Time: 3:11 PM
 */

namespace App\Modules\LabTest\Models;

use Illuminate\Database\Eloquent\Model;

class LabTestTableHead extends Model
{
    protected $table = 'lab_test_table_head';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function chlorineDemandTest()
    {
        return $this->belongsTo(LabChlorineDemandTest::class, 'lab_chlorine_demand_test_id');
    }

}