<?php

namespace App\Modules\DeepTubewell\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Land\Models\Area;
use App\Modules\DeepTubewell\Models\DeepTubewell;
use App\Modules\DeepTubewell\Models\DeepTubewellSource;
use App\Modules\DeepTubewell\Models\DeepTubewellSourceType;
use App\Modules\Land\Models\Zone;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Validation\Rule;

class DeepTubewellController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $areas          = Area::pluck('title', 'id');
        $zones          = Zone::pluck('title', 'id');
        $source_type    = DeepTubewellSourceType::pluck('title', 'id');
        $deepTubewells  = $this->__filter($request)->paginate(10);
        return view('DeepTubewell::deep-tubewell.index', compact('areas','zones','source_type','deepTubewells'));
    }

    public function create()
    {
        $zones      = Zone::pluck('title', 'id');
        $areas      = Area::where('zone_id', '1')->pluck('title', 'id');
        $source_type= DeepTubewellSourceType::pluck('title', 'id');

        return view('DeepTubewell::deep-tubewell.create', compact('zones', 'areas', 'source_type'));
    }

    public function store(Request $request)
    {
        $valid = $this->validate($request, [
            // 'title'             => 'required',
            'zone_id'             => 'required',
            'area_id'             => 'required',
            'source_type'             => 'required',
            // 'source_text'             => 'required',
            'onumoti_chukti_boraddo'   => 'required',
            'onumoti_chukti_boraddo_date'   => 'required',
            'dokholpotro_date'   => 'required',
            'deep_tubewell_place_name'   => 'required',
            'khotiyan_no'   => 'required',
            'dag_no'   => 'required',
            'jomir_poriman'   => 'required',
            'destination'   => 'required',
            
        ]);

        if(empty($request->source)){
           $sour['title'] = $request->source_text;
           $get_source = DeepTubewellSource::create($sour);
           $source_id = $get_source['id'];
        }else{
           $source_id = $request->source;
        }

        $data = [
            'zone_id'                             => $request->zone_id,
            'area_id'                             => $request->area_id,
            'source_type'                         => $request->source_type,
            'source'                              => $source_id,
            'onumoti_chukti_boraddo'              => $request->onumoti_chukti_boraddo,
            'onumoti_chukti_boraddo_date'         => $request->onumoti_chukti_boraddo_date,
            // 'onumoti_chukti_boraddo_attach_name'  => $request->onumoti_chukti_boraddo_attach_name,
            'dokholpotro_date'                    => $request->dokholpotro_date,
            // 'dokholpotro_attach_name'             => $request->dokholpotro_attach_name,
            'deep_tubewell_place_name'            => $request->deep_tubewell_place_name,
            'khotiyan_no'                         => $request->khotiyan_no,
            'dag_no'                              => $request->dag_no,
            'jomir_poriman'                       => $request->jomir_poriman,
            'destination'                         => $request->destination,
        ];
        // echo "<pre>";print_r($data);die();

        $chk_log = LogDetailsStore(Auth::user()->id,'deep-tubewell','deep-tubewell',1);//1=Insert,2=Update,3=Delete.
      
        try {
            if ($request->hasFile('onumoti_chukti_boraddo_attach')) {
                $fileName = $request->land_source_id .'-1'. time() . '.' . $request->file('onumoti_chukti_boraddo_attach')->getClientOriginalExtension();
                $path = 'uploads/deep-tubewell/';
                Storage::disk('public-root')->put($path . $fileName, file_get_contents($request->file('onumoti_chukti_boraddo_attach')));
                $data['onumoti_chukti_boraddo_attach'] = $path . $fileName;
            }
            if ($request->hasFile('dokholpotro_attach')) {
                $fileName = $request->land_source_id .'-2'. time() . '.' . $request->file('dokholpotro_attach')->getClientOriginalExtension();
                $path = 'uploads/deep-tubewell/';
                Storage::disk('public-root')->put($path . $fileName, file_get_contents($request->file('dokholpotro_attach')));
                $data['dokholpotro_attach'] = $path . $fileName;
            }
            if ($request->hasFile('document')) {
                //echo "b<pre>";print_r($request->document_name);die();
                $deep_tubewell_documents = array();
                foreach($request->file('document') as $key=> $document){
                    $fileName = time() . '.' . $document->getClientOriginalExtension();
                    $path = 'uploads/deep-tubewell/';
                    Storage::disk('public-root')->put($path . $fileName, file_get_contents($document));
                      $remake_doc['file_name']= $path . $fileName;
                      $remake_doc['document_name']= $request->document_name[$key];
                    $deep_tubewell_documents[] = $remake_doc;
                }
           
                $data['other_attach']=json_encode($deep_tubewell_documents);
            }

            // echo "aaaaa<pre>";print_r($data);die();
            
            DeepTubewell::create($data);
            return redirect('deep-tubewell/deep-tubewell/')->with('success', 'Deep Tubewell added successfully');
        } catch (\Exception $ex) {
           
            Log::error($ex);
            return redirect()->back()->withErrors("Something went wrong. Please try again.");
        }
        
        DeepTubewell::create($data);
        return redirect('deep-tubewell/deep-tubewell/')->with('success', 'Deep Tubewell added successfully');
        
    }
    
    public function show(DeepTubewell $deep_tubewell)
    {
        // $fileTypes      = ['' => 'File Type'] + DB::table('file_types')->whereSelectable(3)->orderBy('title', 'ASC')->pluck('title', 'id')->all();
        // $properties     = Property::where('land_id', $land->id)->get();
        return view('DeepTubewell::deep-tubewell.show', compact('deep_tubewell'));
    }

    public function edit(DeepTubewell $deep_tubewell)
    {
        
        $zones      = Zone::pluck('title', 'id');
        $areas      = Area::pluck('title', 'id');
        $source_type= DeepTubewellSourceType::pluck('title', 'id');
        $source     = DeepTubewellSource::where('id',$deep_tubewell->source)->get();
       
        return view('DeepTubewell::deep-tubewell.edit', compact('zones', 'areas', 'source_type','deep_tubewell','source'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'zone_id'             => 'required',
            'area_id'             => 'required',
            'source_type'             => 'required',
            //'source'             => 'required',
            'onumoti_chukti_boraddo'   => 'required',
            'onumoti_chukti_boraddo_date'   => 'required',
            'dokholpotro_date'   => 'required',
            'deep_tubewell_place_name'   => 'required',
            'khotiyan_no'   => 'required',
            'dag_no'   => 'required',
            'jomir_poriman'   => 'required',
            'destination'   => 'required',
        ]);

        
        if($request->source){
            $source_id = $request->source;
        }else{
            if($request->source_text!=$request->source_text_pre){
                $sour['title'] = $request->source_text;
                $get_source = DeepTubewellSource::create($sour);
                $source_id = $get_source['id'];
             }else{
                $source_id = $request->source_pre;
             }
            
        }
          
        $data = [
            'zone_id'                             => $request->zone_id,
            'area_id'                             => $request->area_id,
            'source_type'                         => $request->source_type,
            'source'                              => $source_id,
            'onumoti_chukti_boraddo'              => $request->onumoti_chukti_boraddo,
            'onumoti_chukti_boraddo_date'         => $request->onumoti_chukti_boraddo_date,
            'onumoti_chukti_boraddo_attach_name'  => $request->onumoti_chukti_boraddo_attach_name,
            'dokholpotro_date'                    => $request->dokholpotro_date,
            'dokholpotro_attach_name'             => $request->dokholpotro_attach_name,
            'deep_tubewell_place_name'            => $request->deep_tubewell_place_name,
            'khotiyan_no'                         => $request->khotiyan_no,
            'dag_no'                              => $request->dag_no,
            'jomir_poriman'                       => $request->jomir_poriman,
            'destination'                         => $request->destination,
        ];
        
        // echo "<pre>";print_r($data);die();
        $deepTubewell = DeepTubewell::where('id', $id)->first();
        try {
            if ($request->hasFile('onumoti_chukti_boraddo_attach') && isset($request->onumoti_chukti_boraddo_attach)) {
                $image = public_path($deepTubewell->onumoti_chukti_boraddo_attach); // get previous image from folder
                if (File::exists($image)) { // unlink or remove previous image from folder
                    Storage::delete($image);
                }

                $fileName = time() . '.' . $request->file('onumoti_chukti_boraddo_attach')->getClientOriginalExtension();
                $path = 'uploads/deep-tubewell/';
                Storage::disk('public-root')->put($path . $fileName, file_get_contents($request->file('onumoti_chukti_boraddo_attach')));
                $data['onumoti_chukti_boraddo_attach'] = $path . $fileName;
            }
            if ($request->hasFile('dokholpotro_attach') && isset($request->dokholpotro_attach)) {
                $image = public_path($deepTubewell->dokholpotro_attach); // get previous image from folder
                if (File::exists($image)) {
                    Storage::delete($image);
                }
                $fileName = time() . '.' . $request->file('dokholpotro_attach')->getClientOriginalExtension();
                $path = 'uploads/deep-tubewell/';
                Storage::disk('public-root')->put($path . $fileName, file_get_contents($request->file('dokholpotro_attach')));
                $data['dokholpotro_attach'] = $path . $fileName;
            }

            
            // if ($request->hasFile('document')) {
            //     //echo "b<pre>";print_r($request->document_name);die();
            //     $deep_tubewell_documents = array();
            //     foreach($request->file('document') as $key=> $document){
            //         $fileName = time() . '.' . $document->getClientOriginalExtension();
            //         $path = 'uploads/deep-tubewell/';
            //         Storage::disk('public-root')->put($path . $fileName, file_get_contents($document));
            //           $remake_doc['file_name']= $path . $fileName;
            //           $remake_doc['document_name']= $request->document_name[$key];
            //         $deep_tubewell_documents[] = $remake_doc;
            //     }
            //     // echo "<pre>";print_r($deep_tubewell_documents);die();
            //     $data['other_attach']=json_encode($deep_tubewell_documents);
            // }

            //echo "<pre>";print_r($request->document);die();
            if(!empty($request->document)){
                $deep_tubewell_documents = array();
                foreach($request->document as $key=> $document){
                    if (is_string($document)) {
                        $remake_doc['file_name']= $document;
                        $remake_doc['document_name']= $request->document_name[$key];
                        $deep_tubewell_documents[] = $remake_doc;
                    }else{
                        $fileName = time() . '.' . $document->getClientOriginalExtension();
                        $path = 'uploads/deep-tubewell/';
                        Storage::disk('public-root')->put($path . $fileName, file_get_contents($document));
                        $remake_doc['file_name']= $path . $fileName;
                        $remake_doc['document_name']= $request->document_name[$key];
                        $deep_tubewell_documents[] = $remake_doc;
                    }
                }
                // echo "<pre>";print_r($deep_tubewell_documents);die();
                $data['other_attach']=json_encode($deep_tubewell_documents);
            }

            // echo "<pre>";print_r($data);die();
            
            DeepTubewell::where('id', $id)->update($data);
            return redirect('deep-tubewell/deep-tubewell/')->with('success', 'Deep-Tubewell updated successfully');
        } catch (\Exception $ex) {
            Log::error($ex);
            return redirect()->back()->withErrors("Something went wrong. Please try again.");
        }
    }

    public function destroy(DeepTubewell $deep_tubewell)
    {
        if($deep_tubewell) {
            $deep_tubewell->delete();
            return redirect()->back()->with('success', 'Deep-Tubewell Successfully Deleted');
        } else {
            return redirect()->back()->withErrors('No Data Found');
        }

    }

    private function __filter($request)
    {
        $query                          = array();
        if ($request->zone_id != null) {
            $query['zone_id']           = $request->zone_id;
        }
        if ($request->area_id != null) {
            $query['area_id']           = $request->area_id;
        }
        if ($request->source_type != null) {
            $query['source_type']    = $request->source_type;
        }
        $getDeeptubewell   = DeepTubewell::where($query);
        ($request->deep_tubewell_place_name ? $getDeeptubewell->where('deep_tubewell_place_name', 'like', '%' . $request->deep_tubewell_place_name . '%') : null);
        // ($request->ownership_details ? $landQuery->where('ownership_details', 'like', '%' . $request->ownership_details . '%') : null);
        // (($request->filled('quantity') and $request->quantity_sign) ? $landQuery->where('quantity', "$request->quantity_sign", $request->quantity) : null);
        // ($request->current_status ? $landQuery->where('current_status', $request->current_status) : null);
        // ($request->khajna ? $landQuery->where('khajna', $request->khajna) : null);
        // ($request->namjari ? $landQuery->where('namjari', $request->namjari) : null);
        // ($request->comment ? $landQuery->where('comment', 'like', '%' . $request->comment . '%') : null);
        // ($request->filled('status') ? $landQuery->where('status', $request->status) : null);

        // if ($request->address != null) {
        //     $getDeeptubewell->where('address', 'like', "%{$request->address}%");
        // }
        // if ($request->khotian != null) {
        //     $getDeeptubewell->where('khotian', 'like', "%{$request->khotian}%");
        // }
        
        $getDeeptubewell->orderBy('created_at', 'DESC');
        
        $deepTubewells     = $getDeeptubewell->with(['zone', 'area', 'sourceType']);
        return $deepTubewells;
    }

    public function getAllSource(Request $request){
        $source = DeepTubewellSource::where('title', 'like', '%' . $request->source . '%')->get()->toArray();
        $data['sources']= $source;
        echo json_encode($data);
    }

    
}
