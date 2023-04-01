<?php

namespace App\Modules\WasaApplication\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationSetting extends Model
{
    protected $guarded = ['id'];
    
    public function category()
    {
        return $this->belongsTo('App\Modules\WasaApplication\Models\ApplicationCategorie','application_categorie_id','id');
    }
}
