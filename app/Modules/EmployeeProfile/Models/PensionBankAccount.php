<?php

namespace App\EmployeeProfile\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PensionBankAccount extends Model {

    use SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'pension_bank_account';

    public function bank() {
        return $this->belongsTo('App\Modules\BankBranch\Models\Bank', 'bank_id', 'id');
    }

    public function branch() {
        return $this->belongsTo('App\Modules\BankBranch\Models\Branch', 'branch_id', 'id');
    }

}
