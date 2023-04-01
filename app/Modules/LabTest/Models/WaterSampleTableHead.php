<?php
/**
 * Created by PhpStorm.
 * User: nurul.islam
 * Date: 12/12/2018
 * Time: 2:56 PM
 */

namespace App\Modules\LabTest\Models;

use Illuminate\Database\Eloquent\Model;

class WaterSampleTableHead extends Model
{
    protected $table = 'lab_water_sample_table_head';
    protected $guarded = ['id'];

    public $timestamps = false;

    public function waterSampleTest()
    {
        return $this->belongsTo(WaterSampleTest::class, 'lab_water_sample_test_id');
    }
    
    public function reportHead()
    {
        return $this->hasOne(ReportHead::class, 'id','report_head_id');
    }
}