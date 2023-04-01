<?php


namespace App\Modules\LabTest\Models;

use Illuminate\Database\Eloquent\Model;

class LabTest extends Model
{
    protected $table = 'lab_tests';
    protected $guarded = ['id'];

    public $timestamps = false;

    public function author()
    {
        return $this->hasMany(LabTestAuthor::class, 'lab_test_id');
    }
}