<?php
/**
 * Created by PhpStorm.
 * User: nurul.islam
 * Date: 11/11/2018
 * Time: 12:44 PM
 */

namespace App\Modules\PensionApplication\Models;

use App\EmployeeProfile\Model\Employee;
use Illuminate\Database\Eloquent\Model;

class PensionApplicationAuthor extends Model
{
    protected $table = 'pension_application_author';
    protected $guarded = ['id'];

    public function pension_application()
    {
        return $this->belongsTo(PensionApplicationPart1ka::class, 'application_id');
    }

    public function author()
    {
        return $this->belongsTo(Employee::class, 'author_id');
    }
}