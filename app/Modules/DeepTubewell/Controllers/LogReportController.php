<?php

namespace App\Modules\DeepTubewell\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\DeepTubewell\Models\LogInfo;
use App\User;
use Illuminate\Http\Request;

class LogReportController extends Controller
{

    public function logReport(Request $request){
        //dd($request->all());
        $users=User::all()->pluck('name','id');;
        $loginfo=LogInfo::with('user');
        if($request->user_id){
            $loginfo->where('user_id',$request->user_id);
        }
        if($request->operation){
            $loginfo->where('operation',$request->operation);
        }
        if($request->status){
            $loginfo->where('status',$request->status);
        }
        if($request->orderby){
            ($request->orderby == 'asc') ? $loginfo->orderBy('id', 'ASC'):$loginfo->orderBy('id','DESC'); 
        }
        $loginfos=$loginfo->whereIn('operation',[1,2])->get();
        return view('DeepTubewell::log-report.index',compact('users','loginfos'));
    }

    public function destroy($id)
    {
        if(isset($id)){
            LogInfo::find($id)->delete();
            return redirect()->back()->with('success', "Log successfully deleted");
        } else {
            return redirect()->back()->withErrors("No Data Found");
        }
    }
}