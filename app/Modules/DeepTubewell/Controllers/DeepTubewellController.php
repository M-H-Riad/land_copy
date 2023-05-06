<?php

namespace App\Modules\DeepTubewell\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Land\Models\Area;
use App\Modules\DeepTubewell\Models\DeepTubewell;
use App\Modules\DeepTubewell\Models\DeepTubewellSource;
use App\Modules\DeepTubewell\Models\DeepTubewellSourceType;
use App\Modules\Land\Models\Zone;
use File;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Validation\Rule;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Mpdf\Mpdf;

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
            'onumoti_chukti_boraddo_attach_name'  => $request->onumoti_chukti_boraddo_attach_name,
            'dokholpotro_date'                    => $request->dokholpotro_date,
            'dokholpotro_attach_name'             => $request->dokholpotro_attach_name,
            'deep_tubewell_place_name'            => $request->deep_tubewell_place_name,
            'khotiyan_no'                         => $request->khotiyan_no,
            'dag_no'                              => $request->dag_no,
            'jomir_poriman'                       => $request->jomir_poriman,
            'destination'                         => $request->destination,
        ];
   
        $log_info['user_id']     = Auth::user()->id;
        $log_info['module_name'] = 'deep-tubewell';
        $log_info['menu_name']   = 'deep-tubewell';
        $log_info['operation']   =  1;
        $log_info['deep_tubewell_zone_id']=$request->zone_id;
        $log_info['deep_tubewell_area_id']=$request->area_id;
        $log_info['deep_tubewell_source_type']=$request->zone_id;
        $log_info['deep_tubewell_source']=$source_id;
        $log_info['deep_tubewell_onumoti_chukti_boraddo']=$request->onumoti_chukti_boraddo;
        $log_info['deep_tubewell_onumoti_chukti_boraddo_date']=$request->onumoti_chukti_boraddo_date;
        $log_info['deep_tubewell_onumoti_chukti_boraddo_attach_name']=$request->onumoti_chukti_boraddo_attach_name;
        $log_info['deep_tubewell_dokholpotro_date']=$request->dokholpotro_date;
        $log_info['deep_tubewell_dokholpotro_attach_name']=$request->dokholpotro_attach_name;
        $log_info['deep_tubewell_deep_tubewell_place_name']=$request->deep_tubewell_place_name;
        $log_info['deep_tubewell_khotiyan_no']=$request->khotiyan_no;
        $log_info['deep_tubewell_dag_no']=$request->dag_no;
        $log_info['deep_tubewell_jomir_poriman']=$request->jomir_poriman;
        $log_info['deep_tubewell_destination']=$request->destination;
       

        try {
            if ($request->hasFile('onumoti_chukti_boraddo_attach')) {
                $fileName = $request->land_source_id .'-1'. time() . '.' . $request->file('onumoti_chukti_boraddo_attach')->getClientOriginalExtension();
                $path = 'uploads/deep-tubewell/';
                Storage::disk('public-root')->put($path . $fileName, file_get_contents($request->file('onumoti_chukti_boraddo_attach')));
                $data['onumoti_chukti_boraddo_attach'] = $path . $fileName;
                $log_info['deep_tubewell_onumoti_chukti_boraddo_attach']=$path.$fileName;
            }
            if ($request->hasFile('dokholpotro_attach')) {
                $fileName = $request->land_source_id .'-2'. time() . '.' . $request->file('dokholpotro_attach')->getClientOriginalExtension();
                $path = 'uploads/deep-tubewell/';
                Storage::disk('public-root')->put($path . $fileName, file_get_contents($request->file('dokholpotro_attach')));
                $data['dokholpotro_attach'] = $path.$fileName;
                $log_info['deep_tubewell_dokholpotro_attach']=$path.$fileName;
            }
            if ($request->hasFile('document')) {
                //echo "b<pre>";print_r($request->document_name);die();
                $deep_tubewell_documents = array();
                $i=0;
                foreach($request->file('document') as $key=> $document){
                    $fileName = $i.time() . '.' . $document->getClientOriginalExtension();
                    $path = 'uploads/deep-tubewell/';
                    Storage::disk('public-root')->put($path . $fileName, file_get_contents($document));
                      $remake_doc['file_name']= $path . $fileName;
                      $remake_doc['document_name']= $request->document_name[$key];
                    $deep_tubewell_documents[] = $remake_doc;
                    $i++;
                }
           
                $data['other_attach']=json_encode($deep_tubewell_documents);
                $log_info['deep_tubewell_other_attach']=json_encode($deep_tubewell_documents);
            }

            //  echo "aaaaa<pre>";print_r($data);die();
            
            $id=DeepTubewell::create($data)->id;
            $log_info['deep_tubewell_id']=$id;
            LogDetailsStore($log_info);
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

        $deep_tubewell=DeepTubewell::find($id);
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
        
        $log_info['user_id']     = Auth::user()->id;
        $log_info['module_name'] = 'deep-tubewell';
        $log_info['menu_name']   = 'deep-tubewell';
        $log_info['operation']   =  2;
        $log_info['deep_tubewell_zone_id']=$request->zone_id;
        $log_info['deep_tubewell_area_id']=$request->area_id;
        $log_info['deep_tubewell_source_type']=$request->zone_id;
        $log_info['deep_tubewell_source']=$source_id;
        $log_info['deep_tubewell_onumoti_chukti_boraddo']=$request->onumoti_chukti_boraddo;
        $log_info['deep_tubewell_onumoti_chukti_boraddo_date']=$request->onumoti_chukti_boraddo_date;
        $log_info['deep_tubewell_onumoti_chukti_boraddo_attach_name']=$request->onumoti_chukti_boraddo_attach_name;
        $log_info['deep_tubewell_dokholpotro_date']=$request->dokholpotro_date;
        $log_info['deep_tubewell_dokholpotro_attach_name']=$request->dokholpotro_attach_name;
        $log_info['deep_tubewell_deep_tubewell_place_name']=$request->deep_tubewell_place_name;
        $log_info['deep_tubewell_khotiyan_no']=$request->khotiyan_no;
        $log_info['deep_tubewell_dag_no']=$request->dag_no;
        $log_info['deep_tubewell_jomir_poriman']=$request->jomir_poriman;
        $log_info['deep_tubewell_destination']=$request->destination;
        $log_info['deep_tubewell_onumoti_chukti_boraddo_attach']=$deep_tubewell->onumoti_chukti_boraddo_attach;
        $log_info['deep_tubewell_dokholpotro_attach']=$deep_tubewell->dokholpotro_attach;
        $log_info['deep_tubewell_other_attach']=$deep_tubewell->other_attach;

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
                $log_info['deep_tubewell_onumoti_chukti_boraddo_attach']=$path.$fileName;
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
                $log_info['deep_tubewell_dokholpotro_attach']=$path.$fileName;
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
                $i=0;
                foreach($request->document as $key=> $document){
                    if (is_string($document)) {
                        $remake_doc['file_name']= $document;
                        $remake_doc['document_name']= $request->document_name[$key];
                        $deep_tubewell_documents[] = $remake_doc;
                    }else{
                        $fileName = $i.time() . '.' . $document->getClientOriginalExtension();
                        $path = 'uploads/deep-tubewell/';
                        Storage::disk('public-root')->put($path . $fileName, file_get_contents($document));
                        $remake_doc['file_name']= $path . $fileName;
                        $remake_doc['document_name']= $request->document_name[$key];
                        $deep_tubewell_documents[] = $remake_doc;
                    }
                $i++;
                }
                // echo "<pre>";print_r($deep_tubewell_documents);die();
                $data['other_attach']=json_encode($deep_tubewell_documents);
                $log_info['deep_tubewell_other_attach']=json_encode($deep_tubewell_documents);
            }

            // echo "<pre>";print_r($data);die();
            
            DeepTubewell::where('id', $id)->update($data);
            $log_info['deep_tubewell_id']=$id;
            LogDetailsStore($log_info);
            return redirect('deep-tubewell/deep-tubewell/')->with('success', 'Deep-Tubewell updated successfully');
        } catch (\Exception $ex) {
            Log::error($ex);
            return redirect()->back()->withErrors("Something went wrong. Please try again.");
        }
    }

    public function destroy(DeepTubewell $deep_tubewell)
    {
        if($deep_tubewell) {
            $log_info['user_id']     = Auth::user()->id;
            $log_info['module_name'] = 'deep-tubewell';
            $log_info['menu_name']   = 'deep-tubewell';
            $log_info['operation']   =  3;
            $log_info['deep_tubewell_zone_id']=$deep_tubewell->zone_id;
            $log_info['deep_tubewell_area_id']=$deep_tubewell->area_id;
            $log_info['deep_tubewell_source_type']=$deep_tubewell->zone_id;
            $log_info['deep_tubewell_source']=$deep_tubewell->source;
            $log_info['deep_tubewell_onumoti_chukti_boraddo']=$deep_tubewell->onumoti_chukti_boraddo;
            $log_info['deep_tubewell_onumoti_chukti_boraddo_date']=$deep_tubewell->onumoti_chukti_boraddo_date;
            $log_info['deep_tubewell_onumoti_chukti_boraddo_attach_name']=$deep_tubewell->onumoti_chukti_boraddo_attach_name;
            $log_info['deep_tubewell_dokholpotro_date']=$deep_tubewell->dokholpotro_date;
            $log_info['deep_tubewell_dokholpotro_attach_name']=$deep_tubewell->dokholpotro_attach_name;
            $log_info['deep_tubewell_deep_tubewell_place_name']=$deep_tubewell->deep_tubewell_place_name;
            $log_info['deep_tubewell_khotiyan_no']=$deep_tubewell->khotiyan_no;
            $log_info['deep_tubewell_dag_no']=$deep_tubewell->dag_no;
            $log_info['deep_tubewell_jomir_poriman']=$deep_tubewell->jomir_poriman;
            $log_info['deep_tubewell_destination']=$deep_tubewell->destination;
            $log_info['deep_tubewell_onumoti_chukti_boraddo_attach']=$deep_tubewell->onumoti_chukti_boraddo_attach;
            $log_info['deep_tubewell_dokholpotro_attach']=$deep_tubewell->dokholpotro_attach;
            $log_info['deep_tubewell_other_attach']=$deep_tubewell->other_attach;

            $deep_tubewell->delete();
            $log_info['deep_tubewell_id']=$deep_tubewell->id;
            LogDetailsStore($log_info);
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

    public function single_pdf($id)
    {
        $deepTubewell      = DeepTubewell::findOrFail($id);

        ini_set('memory_limit', '3072M');
        set_time_limit(300);

        $html               = view("DeepTubewell::deep-tubewell.single_export_pdf", compact('deepTubewell'));

        $defaultConfig      = (new ConfigVariables())->getDefaults();
        $fontDirs           = $defaultConfig['fontDir'];
        $defaultFontConfig  = (new FontVariables())->getDefaults();
        $fontData           = $defaultFontConfig['fontdata'];

        $mpdf               = new mPDF([
            'pagenumPrefix' => 'Page ',
            'nbpgPrefix'    => ' of ',
            'nbpgSuffix'    => '',
            'margin_top'    => '45',
            'tempDir'       => storage_path(),
            'mode'          => 'utf-8',
            'format'        => 'A4',
            'fontDir'       => array_merge($fontDirs, [
                public_path('fonts'),
            ]),
            'fontdata'      => $fontData + [
                    'solaimanlipi'  => [
                        'R'         => "SolaimanLipi.ttf",
                        'useOTL'    => 0xFF,
                    ],
                ],
            'default_font'  => 'solaimanlipi'
        ]);

        $title              = "deep-tubewell Details - " . date('Y-m-d H:i:s') . '.pdf';
        $mpdf->SetProtection(array('print'));
        $mpdf->SetTitle($title);
        $mpdf->SetAuthor("SSL Wireless");
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHtmlHeader(view('DeepTubewell::deep-tubewell.pdf_header'));
        $mpdf->WriteHTML($html);
        $mpdf->Output($title, 'I');
        exit;
    }

    public function pdf(Request $request)
    {

        $title              = "deep-tubewell List Report - " . date('Y-m-d H:i:s') . '.pdf';
        $data['deep_tubewells']      = $this->__filter($request)->get();
        
        if(isset($request->zone_id))
        {
            $zone           = Zone::where('id',$request->zone_id)->select('title')->first();
            $data['zone']   =  $zone;
            $title          = $zone->title." - deep-tubewell List Report - " . date('Y-m-d H:i:s') . '.pdf';

        }
        ini_set('memory_limit', '3072M');
        set_time_limit(300);
        $html               = view("DeepTubewell::deep-tubewell.export_pdf", $data);

        $defaultConfig      = (new ConfigVariables())->getDefaults();
        $fontDirs           = $defaultConfig['fontDir'];
        $defaultFontConfig  = (new FontVariables())->getDefaults();
        $fontData           = $defaultFontConfig['fontdata'];

        $mpdf               = new mPDF([
            'pagenumPrefix' => 'Page ',
            'nbpgPrefix'    => ' of ',
            'nbpgSuffix'    => '',
            'margin_top'    => '45',
            'tempDir'       => storage_path(),
            'mode'          => 'utf-8',
            'format'        => 'A4-L',
            'fontDir'       => array_merge($fontDirs, [
                public_path('fonts'),
            ]),
            'fontdata'      => $fontData + [
                    'solaimanlipi'  => [
                        'R'         => "SolaimanLipi.ttf",
                        'useOTL'    => 0xFF,
                    ],
                ],
            'default_font'  => 'solaimanlipi'
        ]);

        $mpdf->SetProtection(array('print'));

        $mpdf->SetTitle($title);
        $mpdf->SetAuthor("SSL Wireless");
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHtmlHeader(view('DeepTubewell::deep-tubewell.pdf_header',$data));
        $mpdf->SetHtmlFooter(view('DeepTubewell::deep-tubewell.pdf_footer',$data));
        $mpdf->WriteHTML($html);
        $mpdf->Output($title, 'I');
        exit;
    }

    public function export(Request $request)
    {
        $result         = $this->__filter($request)->get();

        $data           = [];
        foreach ($result as $row) {
            $dataArray  = [
                'zone'      => $row->zone->title,
                'sourceType'=> $row->sourceType->title,
                'source'    => $row->sources->title,
            ];
            $data[]         = array_merge($dataArray, $row->only([
                'onumoti_chukti_boraddo', 'onumoti_chukti_boraddo_date', 'dokholpotro_date', 'deep_tubewell_place_name', 'khotiyan_no', 'dag_no', 'jomir_poriman', 'destination',
            ]));
        }

        Excel::create('Deep-tubewell List', function ($excel) use ($data) {
            $excel->sheet('Deep-tubewell List', function ($sheet) use ($data) {
                $sheet->setOrientation('landscape');
                $sheet->fromArray($data);
            });
        })->export('xls');

    }

    
}
