<?php

namespace App\Http\Middleware;

use App\Modules\Stakeholder\Models\PermissionModule;
use App\Modules\User\Models\Module;
use Closure;
use Illuminate\Support\Facades\Auth;

class ModulePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param $module_id
     * @return mixed
     */
    public function handle($request, Closure $next, $module_id = '')
    {
        if(!$module_id){
            $module_id = Module::where('name',$request->segment(1))->pluck('id');
        }
        $permission = PermissionModule::where(
            [
                'stakeholder_id'   => Auth::user()->stakeholder_id,
                'module_id'        => $module_id,
            ]
        )->count();

		if (! $permission > 0) {
            abort(403);
        }

        return $next($request);
    }
}
