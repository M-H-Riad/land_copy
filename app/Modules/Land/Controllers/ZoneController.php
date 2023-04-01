<?php

namespace App\Modules\Land\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Land\Models\Area;
use App\Modules\Land\Models\Land;
use App\Modules\Land\Models\LandSource;
use App\Modules\Land\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query      = Zone::query();
        ($request->title ? $query->where('title', 'like', '%' . $request->title . '%') : null);
        ($request->filled('status') ? $query->where('status', $request->status) : null);
        $zones      = $query->orderBy('title', 'ASC')->paginate(10);
        return view('Land::zone.index', compact('zones'));
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
            'title'     => 'required|unique:land_zones,title'
        ]);

        $data = [
            'title'     => $request->title,
            'status'    => 1
        ];

        try {
            Zone::create($data);
            return redirect()->back()->with('success', 'Land Zone added successfully');
        } catch (\Exception $ex) {
            Log::error($ex);
            return redirect()->back()->withErrors("Something went wrong. Please try again.");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Modules\Land\Models\Zone $zone
     * @return \Illuminate\Http\Response
     */
    public function show(Zone $zone)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Modules\Land\Models\Zone $zone
     * @return \Illuminate\Http\Response
     */
    public function edit(Zone $zone)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Modules\Land\Models\Zone $zone
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title'     => 'required|unique:land_zones,title,' . $id,
            'status'    => 'required|boolean',
        ]);

        $data = [
            'title'     => $request->title,
            'status'    => $request->status
        ];
        try {
            Zone::where('id', $id)->update($data);
            return redirect()->back()->with('success', 'Land Zone updated successfully');
        } catch (\Exception $ex) {
            Log::error($ex);
            return redirect()->back()->withErrors("Something went wrong. Please try again.");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Modules\Land\Models\Zone $zone
     * @return \Illuminate\Http\Response
     */
    public function destroy(Zone $zone)
    {
        if($zone){
            if( Land::where('zone_id',$zone->id)->exists() || Area::where('zone_id',$zone->id)->exists() ){
                return redirect()->back()->withErrors("Sorry, You can not delete this Zone");
            }
            $zone->delete();
            return redirect()->back()->with('success', "Zone successfully deleted");
        } else {
            return redirect()->back()->withErrors("No Data Found");
        }

    }
}
