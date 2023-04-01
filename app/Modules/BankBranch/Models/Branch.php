<?php

namespace App\Modules\BankBranch\Models;

use App\AuditTrailObserver;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
//    protected $table = 'gmn_branch_list';
    protected $table = 'bank_branches';

    protected $guarded = [];



    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }


    public static function boot()
    {
        $class = get_called_class();
        $class::observe(new AuditTrailObserver());

        parent::boot();
    }
  
}
