<?php

namespace App\Modules\DeepTubewell\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class LogInfo extends Model
{
    
    protected $table = 'log_info';
    protected $fillable = ['id','user_id','module_name','menu_name','operation'];
    
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
