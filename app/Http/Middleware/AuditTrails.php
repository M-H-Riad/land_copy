<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Library\AuditTrailLib;

class AuditTrails {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (auth()->check() && !$request->ajax()) {

            if ($request->isMethod('post')) {
                AuditTrailLib::addTrail("Create Request", auth()->user()->user_name, 'Request submit for store data', 'Request', $request->fullUrl(), json_encode($request->all()));
            } elseif ($request->isMethod('put')) {
                AuditTrailLib::addTrail("Update Request", auth()->user()->user_name, 'Request submit for update data', 'Request', $request->fullUrl(), json_encode($request->all()));
            } elseif ($request->isMethod('delete')) {
                AuditTrailLib::addTrail("Delete Request", auth()->user()->user_name, 'Request submit for delete data', 'Request', $request->fullUrl(), json_encode($request->all()));
            }
        }

        return $next($request);
    }

}
