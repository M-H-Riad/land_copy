<?php
namespace App\Library;
use App\AuditTrail;
use Auth;
use DB;
use Request;
class AuditTrailLib{
    public static function addTrail($action_title = null,$access_by = null,$description = null,$type = null,$url=null,$request=null)
    {
        AuditTrail::create(array(
            'ip'=>Request::ip(),
            'action_title'=>$action_title,
            'access_by'=>$access_by,
            'description'=>$description,
            'type'=>$type,
            'url'=>$url,
            'request'=>$request,
            'created_at'=>date('Y-m-d H:i:s'),
            'created_by'=> Auth::check() ? Auth::id() : null,
            
        ));
    }
}