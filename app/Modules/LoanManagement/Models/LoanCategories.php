<?php

namespace App\Modules\LoanManagement\Models;

use Illuminate\Database\Eloquent\Model;

class LoanCategories extends Model {

    //
	protected $table = 'loan_categories';
	protected $guarded = ['id','created_at','updated_at'];
}
