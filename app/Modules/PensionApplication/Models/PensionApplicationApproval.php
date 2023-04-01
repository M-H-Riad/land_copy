<?php
/**
 * Created by PhpStorm.
 * User: nurul.islam
 * Date: 11/11/2018
 * Time: 12:48 PM
 */

namespace App\Modules\PensionApplication\Models;

use App\EmployeeProfile\Model\EmployeeDocument;
use Illuminate\Database\Eloquent\Model;

class PensionApplicationApproval extends Model
{
    protected $table = 'pension_application_approval';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function pension_application()
    {
        return $this->belongsTo(PensionApplicationPart1ka::class, 'application_id');
    }

    public function signature()
    {
        $this->hasOne(EmployeeDocument::class, 'employee_id', 'approved_by')
            ->where('file_type_id', 4);
    }
}