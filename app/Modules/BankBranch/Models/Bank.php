<?php
namespace App\Modules\BankBranch\Models;

use App\AuditTrailObserver;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
//    protected $table = 'gmn_bank_list';
//    public $timestamps = false;

    //protected $guarded = ["id"];
    protected $fillable = ['bank_name','status','created_by','updated_by'];
    public static $rules = array(
        'bank_name'=>'required|unique'
    );


    public static function boot()
    {
        $class = get_called_class();
        $class::observe(new AuditTrailObserver(10));

        parent::boot();
    }
}
