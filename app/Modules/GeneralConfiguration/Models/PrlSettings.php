<?php

namespace App\Modules\GeneralConfiguration\Models;

use Illuminate\Database\Eloquent\Model;

class PrlSettings extends Model {

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'prl_settings';

}
