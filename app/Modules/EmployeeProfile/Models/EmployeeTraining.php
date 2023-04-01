<?php

namespace App\EmployeeProfile\Model;

use Illuminate\Database\Eloquent\Model;

class EmployeeTraining extends Model
{
    protected $guarded = ['id'];


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
}
