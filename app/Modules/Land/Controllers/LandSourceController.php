<?php

namespace App\Modules\Land\Controllers;

use App\Modules\Land\Models\Land;
use App\Modules\Land\Models\LandSource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LandSourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query      = LandSource::query();
        ($request->title ? $query->where('title', 'like', '%' . $request->title . '%') : null);
        ($request->filled('status') ? $query->where('status', $request->status) : null);
        $sources    = $query->orderBy('title', 'ASC')->paginate(10);
        return view('Land::source.index', compact('sources'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'     => 'required|unique:land_sources,title',
        ]);
        $data = [
            'title'     => $request->title,
            'status'    => 1
        ];

        //log Info---------
        $log_info['user_id']     = Auth::user()->id;
        $log_info['module_name'] = 'land';
        $log_info['menu_name']   = 'land_sources';
        $log_info['operation']   =  1;
        $log_info['land_sources_title']  = $request->title;
        $log_info['land_sources_status'] = 1;

        try {
            $id=LandSource::create($data)->id;
            $log_info['land_sources_id'] = $id;
            LogDetailsStore($log_info);

            return redirect()->back()->with('success', 'Land Source added successfully');
        } catch (\Exception $ex) {
            Log::error($ex);
            return redirect()->back()->withErrors("Something went wrong. Please try again.");
        }
    }

    public function create_by_ajax(Request $request)
    {
        $this->validate($request, [
            'title'     => 'required|unique:land_sources,title',
        ]);
        $data = [
            'title'     => $request->title,
            'status'    => 1
        ];

        try {
            LandSource::create($data);
        } catch (\Exception $ex) {
            Log::error($ex);
        }

        $sources = LandSource::pluck('title', 'id');
        return response()->json([
            'sources'       => $sources,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Modules\Land\Models\LandSource $landSource
     * @return \Illuminate\Http\Response
     */
    public function show(LandSource $landSource)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Modules\Land\Models\LandSource $landSource
     * @return \Illuminate\Http\Response
     */
    public function edit(LandSource $landSource)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Modules\Land\Models\LandSource $landSource
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title'     => 'required|unique:land_sources,title,' . $id,
            'status'    => 'required|boolean',
        ]);

        $data = [
            'title'     => $request->title,
            'status'    => $request->status
        ];

         //log Info---------
         $log_info['user_id']     = Auth::user()->id;
         $log_info['module_name'] = 'land';
         $log_info['menu_name']   = 'land_sources';
         $log_info['operation']   =  2;
         $log_info['land_sources_title']  = $request->title;
         $log_info['land_sources_status'] = $request->status;
         $log_info['land_sources_id'] = $id;
         

        try {
            LandSource::where('id', $id)->update($data);
            LogDetailsStore($log_info);

            return redirect()->back()->with('success', 'Land Source updated successfully');
        } catch (\Exception $ex) {
            Log::error($ex);
            return redirect()->back()->withErrors("Something went wrong. Please try again.");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Modules\Land\Models\LandSource $landSource
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(isset($id)){
            if( Land::where('land_source_id', $id)->exists()){
                return redirect()->back()->withErrors("Permission denied! This data is used as another reference.");
            }
            $land_source=LandSource::find($id);
            //log Info---------
            $log_info['user_id']     = Auth::user()->id;
            $log_info['module_name'] = 'land';
            $log_info['menu_name']   = 'land_sources';
            $log_info['operation']   =  3;
            $log_info['land_sources_title']  = $land_source->title;
            $log_info['land_sources_status'] = $land_source->status;
            $log_info['land_sources_id'] = $id;

            LandSource::find($id)->delete();
            LogDetailsStore($log_info);

            return redirect()->back()->with('success', "Land Source successfully deleted");
        } else {
            return redirect()->back()->withErrors("No Data Found");
        }
    }
}
