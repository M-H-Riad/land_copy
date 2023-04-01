<?php

namespace App\Modules\Land\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Land\Models\Land;
use App\Modules\Land\Models\Property;
use App\Modules\Land\Models\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $propertyTypes = PropertyType::pluck('title', 'id');
        $properties = Property::all();
        return view('Land::property.index', compact('propertyTypes', 'properties'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $land = Land::find($request->land_id);

        if($land == null)
            return redirect('land/land')->withErrors("Land Not Found!");

        $propertyTypes = PropertyType::pluck('title', 'id');

        return view('Land::property.create', compact('propertyTypes', 'land'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'land_id' => 'required',
            'property_type_id' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $data = [
            'title' => $request->title,
            'land_id' => $request->land_id,
            'property_type_id' => $request->property_type_id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'status' => 1
        ];

        try {
            Property::create($data);
            return redirect('land/land/'.$request->land_id)->with('success', 'Property added successfully');
        } catch (\Exception $ex) {
            Log::error($ex);
            return redirect()->back()->withErrors("Something went wrong. Please try again.");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function show(Property $property)
    {
        //
        return view('Land::property.show', compact('property'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function edit(Property $property)
    {
        //
        $propertyTypes = PropertyType::pluck('title', 'id');
        return view('Land::property.edit', compact('propertyTypes', 'property'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request, [
            'title' => 'required',
            'land_id' => 'required',
            'property_type_id' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        $data = [
            'title' => $request->title,
            'land_id' => $request->land_id,
            'property_type_id' => $request->property_type_id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'status' => $request->status,
        ];

        try {
            Property::where('id', $id)->update($data);
            return redirect('land/property/'.$id)->with('success', 'Property updated successfully');
        } catch (\Exception $ex) {
            Log::error($ex);
            return redirect()->back()->withErrors("Something went wrong. Please try again.");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function destroy(Property $property)
    {
        //
    }
}
