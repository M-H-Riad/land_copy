<?php

namespace App\Modules\User\Models;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    //

    public function module()
    {
        return $this->belongsTo('App\Modules\User\Models\Module');
    }

    public function permission_module()
    {
        return $this->belongsTo('App\Modules\Stakeholder\Models\PermissionModule');
    }
}
