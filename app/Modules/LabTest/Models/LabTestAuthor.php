<?php


namespace App\Modules\LabTest\Models;

use Illuminate\Database\Eloquent\Model;

class LabTestAuthor extends Model
{
    protected $table = 'lab_test_authors';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function labTest()
    {
        return $this->belongsTo(LabTest::class, 'lab_test_id');
    }
}