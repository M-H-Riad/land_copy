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

class ThanaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $zilas      = Zila::orderBy('title', 'ASC')->pluck('title', 'id');
        $query      = Thana::query();
        ($request->title ? $query->where('title', 'like', '%' . $request->title . '%') : null);
        ($request->zila_id ? $query->where('zila_id', $request->zila_id) : null);

        $thanas      = $query->orderBy('title', 'ASC')->paginate(10);
        return view('Land::thana.index', compact('zilas', 'thanas'));
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
            'zila_id'   => 'required|exists:zilas,id',
            'title'     => Rule::unique('thanas', 'title')->where(function ($query) use ($request) {
                return $query->where('zila_id', $request->zila_id);
            })
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = [
            'title'     => $request->title,
            'zila_id'   => $request->zila_id,
            'status'    => 1
        ];

         //log Info---------
         $log_info['user_id']     = Auth::user()->id;
         $log_info['module_name'] = 'land';
         $log_info['menu_name']   = 'thana';
         $log_info['operation']   = 1;
         $log_info['thana_title']  = $request->title;
         $log_info['thana_zila_id'] = $request->zila_id;
         $log_info['thana_status'] = 1;
         $log_info['thana_created_by'] = Auth::user()->id;

        try {
            $id=Thana::create($data)->id;
            $log_info['thana_id']   = $id;
            LogDetailsStore($log_info);

            return redirect()->back()->with('success', 'Thana added successfully');
        } catch (\Exception $ex) {
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
            'status'    => 'required|boolean',
            'zila_id'   => 'required|exists:land_zones,id',
            'title'     => Rule::unique('thanas', 'title')->where(function ($query) use ($request) {
                return $query->where('zila_id', $request->zila_id);
            })->ignore($id)
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = [
            'title'     => $request->title,
            'zila_id'   => $request->zila_id,
            'status'    => $request->status
        ];
        //log Info---------
        $log_info['user_id']     = Auth::user()->id;
        $log_info['module_name'] = 'land';
        $log_info['menu_name']   = 'thana';
        $log_info['operation']   = 2;
        $log_info['thana_title']  = $request->title;
        $log_info['thana_zila_id'] = $request->zila_id;
        $log_info['thana_status'] = $request->status;
        $log_info['thana_updated_by'] = Auth::user()->id;
        $log_info['thana_id']   = $id;
      

        try {
            Thana::where('id', $id)->update($data);
            LogDetailsStore($log_info);
            return redirect()->back()->with('success', 'Thana updated successfully');
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
            // if( Land::where('thana_id',$id)->exists()){
            //     return redirect()->back()->withErrors("Sorry, You can not delete this Zila");
            // }
            $thana=Thana::find($id);
            //log Info---------
            $log_info['user_id']     = Auth::user()->id;
            $log_info['module_name'] = 'land';
            $log_info['menu_name']   = 'thana';
            $log_info['operation']   = 3;
            $log_info['thana_title']  = $thana->title;
            $log_info['thana_zila_id'] = $thana->zila_id;
            $log_info['thana_status'] = $thana->status;
            $log_info['thana_created_by'] = Auth::user()->id;
            $log_info['thana_id']   = $id;

            Thana::where('id', $id)->delete();
            LogDetailsStore($log_info);

            return redirect()->back()->with('success', "Thana successfully deleted");
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
    public function getThana($zilaID)
    {
        if($zilaID > 0){
            $thanas      = Thana::where('zila_id', $zilaID)->pluck('title', 'id');
            return json_encode($thanas);
        }
        
    }
}
