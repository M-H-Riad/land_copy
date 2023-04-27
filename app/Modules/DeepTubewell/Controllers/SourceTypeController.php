<?php

namespace App\Modules\DeepTubewell\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Land\Models\Area;
use App\Modules\DeepTubewell\Models\DeepTubewell;
use App\Modules\DeepTubewell\Models\DeepTubewellSourceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Validation\Rule;

class SourceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $query      = DeepTubewellSourceType::query();
        ($request->title ? $query->where('title', 'like', '%' . $request->title . '%') : null);
        ($request->filled('status') ? $query->where('status', $request->status) : null);
        $source_types  = $query->orderBy('title', 'ASC')->paginate(10);
        // dd($source_types);
        return view('DeepTubewell::source-type.index', compact('source_types'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title'     => 'required|unique:deep_tubewell_source_type,title',
        ]);
        $data = [
            'title'     => $request->title,
            'status'    => 1
        ];

        $chk_log = LogDetailsStore(Auth::user()->id,'deep-tubewell','deep-tubewell Source Type',1);//1=Insert,2=Update,3=Delete.

        try {
            DeepTubewellSourceType::create($data);
            return redirect()->back()->with('success', 'Deep-Tubewell Source Type added successfully');
        } catch (\Exception $ex) {
            Log::error($ex);
            return redirect()->back()->withErrors("Something went wrong. Please try again.");
        }
    }

    public function edit(DeepTubewellSourceType $DeepTubewellSourceType)
    {
        //
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title'     => 'required|unique:deep_tubewell_source_type,title,' . $id,
            'status'    => 'required|boolean',
        ]);

        $data = [
            'title'     => $request->title,
            'status'    => $request->status
        ];
        try {
            DeepTubewellSourceType::where('id', $id)->update($data);
            return redirect()->back()->with('success', 'Deep Tubewell Source Type updated successfully');
        } catch (\Exception $ex) {
            Log::error($ex);
            return redirect()->back()->withErrors("Something went wrong. Please try again.");
        }
    }
    public function destroy($id)
    {
        if(isset($id)){
            // if( DeepTubewell::where('land_source_id', $id)->exists()){
            //     return redirect()->back()->withErrors("Permission denied! This data is used as another reference.");
            // }
            DeepTubewellSourceType::find($id)->delete();
            return redirect()->back()->with('success', "Land Source successfully deleted");
        } else {
            return redirect()->back()->withErrors("No Data Found");
        }
    }

    public function create_by_ajax(Request $request)
    {
        $this->validate($request, [
            'title'     => 'required|unique:deep_tubewell_source_type,title',
        ]);
        $data = [
            'title'     => $request->title,
            'status'    => 1
        ];

        try { 
            DeepTubewellSourceType::create($data);
            // return redirect()->back()->with('success', 'Land Area added successfully');
        } catch (\Exception $ex) {
            Log::error($ex);
            // return redirect()->back()->withErrors("Something went wrong. Please try again.");
        }

        $source_types = DeepTubewellSourceType::pluck('title', 'id');
        return response()->json([
            'source_types'       => $source_types,
        ]);
    }

    
}
