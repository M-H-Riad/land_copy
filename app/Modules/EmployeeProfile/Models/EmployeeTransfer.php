<?php

namespace App\EmployeeProfile\Model;

use App\Modules\Location\Models\Division;
use Illuminate\Database\Eloquent\Model;
class EmployeeTransfer extends Model
{
    protected $guarded = ['id'];

//    protected $fillable = [
//        'id', 'employee_id', 'created_by', 'updated_by',
//        "office_order_no",
//        "order_date",
//        "is_promotion",
//        "designation_id",
//        "division_id",
//    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot() {
        parent::boot();

        // Before Creating
        static::creating(function($post) {
            $post->created_by = auth()->user()->id;
            $post->updated_by = auth()->user()->id;
        });

        // Before Updating
        static::updating(function($post) {
            $post->updated_by = auth()->user()->id;
        });
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class,'division_id','id');
    }
    public function oldDepartment()
    {
        return $this->belongsTo(Department::class,'old_division_id','id');
    }
}
