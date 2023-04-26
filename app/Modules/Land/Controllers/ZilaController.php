<?php

namespace App\Modules\Land\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Land\Models\Zila;
use App\Modules\Land\Models\Thana;
use App\Modules\Land\Models\Land;
use App\Modules\Land\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Validator;
use Illuminate\Validation\Rule;

class ZilaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query      = Zila::query();
        ($request->title ? $query->where('title', 'like', '%' . $request->title . '%') : null);
        
        $zilas      = $query->orderBy('title', 'ASC')->paginate(10);
        return view('Land::zila.index', compact('zilas'));
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
        $validator      = Validator::make($request->all(), [
            'title'     => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = [
            'title'     => $request->title,
            'status'    => 1
        ];

        //log Info---------
        $log_info['user_id']     = Auth::user()->id;
        $log_info['module_name'] = 'land';
        $log_info['menu_name']   = 'zila';
        $log_info['operation']   = 1;
        $log_info['zila_title']   = $request->title;
        $log_info['zila_status']   = 1;

        try {
            $id=Zila::create($data)->id;
            $log_info['zila_id']=$id;
            LogDetailsStore($log_info);

            return redirect()->back()->with('success', 'Zila added successfully');
        } catch (\Exception $ex) {
            dd($ex);
            Log::error($ex);
            return redirect()->back()->withErrors("Something went wrong. Please try again.");
        }
    }

    public function create_by_ajax(Request $request)
    {
        $validator      = Validator::make($request->all(), [
            'zone_id'   => 'required|exists:land_zones,id',
            'title'     => Rule::unique('land_areas', 'title')->where(function ($query) use ($request) {
                return $query->where('zone_id', $request->zone_id);
            })
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = [
            'title'     => $request->title,
            'zone_id'   => $request->zone_id,
            'status'    => 1
        ];

        try {
            Area::create($data);
            // return redirect()->back()->with('success', 'Land Area added successfully');
        } catch (\Exception $ex) {
            Log::error($ex);
            // return redirect()->back()->withErrors("Something went wrong. Please try again.");
        }

        $areas = Area::pluck('title', 'id');
        return response()->json([
            'areas'       => $areas,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Modules\Land\Models\Area $area
     * @return \Illuminate\Http\Response
     */
    public function show(Area $area)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Modules\Land\Models\Area $area
     * @return \Illuminate\Http\Response
     */
    public function edit(Area $area)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Modules\Land\Models\Area $area
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator      = Validator::make($request->all(), [
            'title'     => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = [
            'title'     => $request->title,
            'status'    => $request->status
        ];

        //log Info---------
        $log_info['user_id']     = Auth::user()->id;
        $log_info['module_name'] = 'land';
        $log_info['menu_name']   = 'zila';
        $log_info['operation']   = 2;
        $log_info['zila_title']   = $request->title;
        $log_info['zila_status']   = $request->status;
        $log_info['zila_id']=$id;
 
        try {
            Zila::where('id', $id)->update($data);
            LogDetailsStore($log_info);

            return redirect()->back()->with('success', 'Zila updated successfully');
        } catch (\Exception $ex) {
            Log::error($ex);
            return redirect()->back()->withErrors("Something went wrong. Please try again.");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Modules\Land\Models\Area $area
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(isset($id)){
            if( Thana::where('zila_id',$id)->exists()){
                return redirect()->back()->withErrors("Sorry, You can not delete this Zila");
            }
            $zila=Zila::find($id);
            //log Info---------
            $log_info['user_id']     = Auth::user()->id;
            $log_info['module_name'] = 'land';
            $log_info['menu_name']   = 'zila';
            $log_info['operation']   = 3;
            $log_info['zila_title']   = $zila->title;
            $log_info['zila_status']   = $zila->status;
            $log_info['zila_id']=$id;

            Zila::where('id', $id)->delete();
            LogDetailsStore($log_info);

            return redirect()->back()->with('success', "Zila successfully deleted");
        } else {
            return redirect()->back()->withErrors("No Data Found");
        }
    }

    /**
     * Get areas
     * @param Request $request [description]
     * @return json           [description]
     * @author Risul Islam <risul321@gmail.com>
     */
    public function getAreas($zoneId)
    {
        $areas      = Area::where('zone_id', $zoneId)->pluck('title', 'id');
        return json_encode($areas);
    }
}
