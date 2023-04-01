<?php

namespace App\Http\Controllers;

use App\AuditTrail;
use Illuminate\Http\Request;
use Auth;
class AuditTrailController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $action_title_array = AuditTrail::groupBy('action_title')->orderBy('action_title','ASC')->pluck('action_title','action_title')->toArray();
        $type_array = AuditTrail::groupBy('type')->orderBy('type','ASC')->pluck('type','type')->toArray();
        $query = AuditTrail::orderBy('id','DESC');
        ($request->ip_s ? $query->where('ip','LIKE','%'.$request->ip_s.'%') : null);
        ($request->access_by_s ? $query->where('access_by','LIKE','%'.$request->access_by_s.'%') : null);
        ($request->description ? $query->where('description','LIKE','%'.$request->description.'%') : null);
        ($request->action_title_s ? $query->where('action_title',$request->action_title_s) : null);
        ($request->type_s ? $query->where('type',$request->type_s) : null);
        if($request->date_from and $request->date_to){
            $query->whereBetween('created_at',[changeDateFormatToDb($request->date_from).' 00:00',changeDateFormatToDb($request->date_to).' 23:59']);
        }
        elseif($request->date_from){
            $query->whereDate('created_at',changeDateFormatToDb($request->date_from));
        }
        elseif($request->date_to){
            $query->whereDate('created_at',changeDateFormatToDb($request->date_to));
        }
        else{
            $query->whereDate('created_at',date('Y-m-d'));
        }
        $audit_trails = $query->paginate(50);
        return view('audit_trails.index',compact('audit_trails','action_title_array','type_array'));
    }
    public function show($id){
        $data['audit_trail'] = AuditTrail::where('id',$id)->first();
        return view('audit_trails._show',$data);
    }
}
