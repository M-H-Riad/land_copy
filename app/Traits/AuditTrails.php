<?php namespace App\Traits;
use Illuminate\Support\Facades\Auth;

/**
AuditTrails Traits use for set Create/Update/Delete Audit Trail
**/
trait AuditTrails {

    protected static function boot() {

        /*** During a model create Eloquent will also update the updated_at field so * need to have the updated_by field here as well * */

        parent::boot();

        static::creating(function($model) {
            if(Auth::user()) {
                $model->created_by = Auth::user()->id;
                $model->updated_by = Auth::user()->id;
            }
        });

        static::updating(function($model)  {
            if(Auth::user()) {
                $model->updated_by = Auth::user()->id;
            }
        });


        /**
         * Deleting a model is slightly different than creating or deleting. For
         * deletes we need to save the model first with the deleted_by field
         * */
        static::deleting(function($model)  {
            if(Auth::user()) {
                $model->deleted_by = Auth::user()->id;
                $model->save();
            }
        });
    }
}
