<?php

namespace App\Modules\Land\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Land\Models\Area;
use App\Modules\Land\Models\KhajnaInfo;
use App\Modules\Land\Models\KhajnaOffice;
use App\Modules\Land\Models\KhajnaOfficeInfo;
use App\Modules\Land\Models\Land;
use App\Modules\Land\Models\LandSource;
use App\Modules\Land\Models\Mowja;
use App\Modules\Land\Models\Upazila;
use App\Modules\Land\Models\Zone;
use File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Mpdf\Mpdf;
use Log;

class KhajnaInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lands         =    Land::all()->pluck('title', 'id');
        $upazilas      =    Upazila::all()->pluck('upazila_name', 'id');
        $moujas        =    Area::all()->pluck('title', 'id');
        $khajnaOff     =    KhajnaOffice::all()->pluck('office_name', 'id');
        $khajnaInfos = $this->__filter($request)->paginate(10);

        return view('Land::khajnaInfo.index', compact('khajnaInfos','lands','upazilas','moujas','khajnaOff'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lands = Land::all()->pluck('title', 'id');

        return view('Land::khajnaInfo.create', compact('lands'));
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
            'land_id'                       => 'required',
            'khajna_date'                   => 'required',
            'from_year'                     => 'required',
            'mowja_id'                      => 'required',
            'khajna_office_id'              => 'required',
            'amount'                        => 'required',
            'document'                      => 'image|mimes:jpeg,png,jpg',
            'dakhila'                      => 'image|mimes:jpeg,png,jpg',
        ]);
        
        $date = explode("-", $request->khajna_date);
        $data = [
            'land_id'               => $request->land_id,
            'khajna_date'           => $request->khajna_date,
            'khajna_date_month'     => $date[1],
            'khajna_date_year'      => $date[0],
            'from_year'             => $request->from_year,
            'to_year'               => $request->to_year,
            'mowja_id'              => $request->mowja_id,
            'khajna_office_id'      => $request->khajna_office_id,
            'bokeya'                => $request->amount,
            'note'                  => $request->note,
        ];

         //log Info---------
         $log_info['user_id']     = Auth::user()->id;
         $log_info['module_name'] = 'land';
         $log_info['menu_name']   = 'khajna_info';
         $log_info['operation']   = 1;
         $log_info['khajna_infos_land_id'] = $request->land_id;
         $log_info['khajna_infos_khajna_date']  =$request->khajna_date;
         $log_info['khajna_infos_khajna_date_month']    =$date[1];
         $log_info['khajna_infos_khajna_date_year']     = $date[0];
         $log_info['khajna_infos_from_year']      =$request->from_year;
         $log_info['khajna_infos_to_year']      =$request->to_year;
         $log_info['khajna_infos_khajna_office_id'] =$request->khajna_office_id;
         $log_info['khajna_infos_upazila_id'] =0;
         $log_info['khajna_infos_mowja_id'] = $request->mowja_id;
         $log_info['khajna_infos_bokeya'] =$request->amount;
         $log_info['khajna_infos_note'] = $request->note;
         $log_info['khajna_infos_created_by']  = Auth::user()->id;
         
        try {
            if ($request->hasFile('document')) {

                $fileName = $request->land_id .'-'. time() . '.' . $request->file('document')->getClientOriginalExtension();
                $path = 'uploads/khajna-doc/';
                Storage::disk('public-root')->put($path . $fileName, file_get_contents($request->file('document')));
 
                $data['document'] = $path . $fileName;
                $log_info['khajna_infos_document']  = $path . $fileName;
            }
            if ($request->hasFile('dakhila')) {

                $fileName = $request->land_id .'-'. time() . '.' . $request->file('dakhila')->getClientOriginalExtension();
                $path = 'uploads/khajna-doc/';
                Storage::disk('public-root')->put($path . $fileName, file_get_contents($request->file('dakhila')));
 
                $data['dakhila'] = $path . $fileName;
                $log_info['khajna_infos_dakhila']  = $path . $fileName;
            }
            $id=KhajnaInfo::create($data)->id;
            $log_info['khajna_infos_id']  =$id;
            LogDetailsStore($log_info);

            return redirect('land/khajna-info/')->with('success', 'Khajna Info info added successfully');
        } catch (\Exception $ex) {
            Log::error($ex);
            return redirect()->back()->withErrors("Something went wrong. Please try again.");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $khajnaInfo = KhajnaInfo::where('id', $id)->first();
        return view('Land::khajnaInfo.show', compact('khajnaInfo'));        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $khajnaInfo = KhajnaInfo::where('id', $id)->first();
        $lands = Land::all()->pluck('title', 'id');
        return view('Land::khajnaInfo.edit', compact('khajnaInfo','lands'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'land_id'                       => 'required',
            'khajna_date'                   => 'required',
            'from_year'                     => 'required',
            'mowja_id'                      => 'required',
            'khajna_office_id'              => 'required',
            'amount'                        => 'required',
            'document'                      => 'image|mimes:jpeg,png,jpg',
            'dakhila'                      => 'image|mimes:jpeg,png,jpg',
        ]);
        $khajnaInfo_new = KhajnaInfo::where('id', $id)->first();
        $date = explode("-", $request->khajna_date);
        $data = [
            'land_id'               => $request->land_id,
            'khajna_date'           => $request->khajna_date,
            'khajna_date_month'     => $date[1],
            'khajna_date_year'      => $date[0],
            'from_year'             => $request->from_year,
            'to_year'               => $request->to_year,
            'mowja_id'              => $request->mowja_id,
            'khajna_office_id'      => $request->khajna_office_id,
            'bokeya'                => $request->amount,
            'note'                  => $request->note,
        ];

         //log Info---------
         $log_info['user_id']     = Auth::user()->id;
         $log_info['module_name'] = 'land';
         $log_info['menu_name']   = 'khajna_info';
         $log_info['operation']   = 2;
         $log_info['khajna_infos_land_id'] = $request->land_id;
         $log_info['khajna_infos_khajna_date']  =$request->khajna_date;
         $log_info['khajna_infos_khajna_date_month']    =$date[1];
         $log_info['khajna_infos_khajna_date_year']     = $date[0];
         $log_info['khajna_infos_from_year']      =$request->from_year;
         $log_info['khajna_infos_to_year']      =$request->to_year;
         $log_info['khajna_infos_khajna_office_id'] =$request->khajna_office_id;
         $log_info['khajna_infos_upazila_id'] =0;
         $log_info['khajna_infos_mowja_id'] = $request->mowja_id;
         $log_info['khajna_infos_bokeya'] =$request->amount;
         $log_info['khajna_infos_note'] = $request->note;
         $log_info['khajna_infos_updated_by']  = Auth::user()->id;
         $log_info['khajna_infos_document']  = $khajnaInfo_new->document;
         $log_info['khajna_infos_dakhila']  = $khajnaInfo_new->dakhila;
         $log_info['khajna_infos_id']  =$id;
         

        try {
            if ($request->hasFile('document') && isset($request->document)) {
                $khajnaInfo = KhajnaInfo::where('id', $id)->first();
                // Remove previous image.
                $khajnaInfoImage = public_path($khajnaInfo->document); // get previous image from folder
                if (File::exists($khajnaInfoImage)) { // unlink or remove previous image from folder
                    unlink($khajnaInfoImage);
                }

                $fileName = $request->land_id .'-'. time() . '.' . $request->file('document')->getClientOriginalExtension();
                $path = 'uploads/khajna-doc/';
                Storage::disk('public-root')->put($path . $fileName, file_get_contents($request->file('document')));
 
                $data['document'] = $path . $fileName;
                $log_info['khajna_infos_document']  = $path . $fileName;
            }
            if ($request->hasFile('dakhila') && isset($request->dakhila)) {
                $khajnaInfo = KhajnaInfo::where('id', $id)->first();
                // Remove previous image.
                $khajnaInfoImage = public_path($khajnaInfo->dakhila); // get previous image from folder
                if (File::exists($khajnaInfoImage)) { // unlink or remove previous image from folder
                    unlink($khajnaInfoImage);
                }

                $fileName = $request->land_id .'-'. time() . '.' . $request->file('dakhila')->getClientOriginalExtension();
                $path = 'uploads/khajna-doc/';
                Storage::disk('public-root')->put($path . $fileName, file_get_contents($request->file('dakhila')));
 
                $data['dakhila'] = $path . $fileName;
                $log_info['khajna_infos_dakhila']  = $path . $fileName;
            }
            KhajnaInfo::where('id', $id)->update($data);
            LogDetailsStore($log_info);
            return redirect('land/khajna-info/')->with('success', 'Khajna Info info updated successfully');
        } catch (\Exception $ex) {
            Log::error($ex);
            return redirect()->back()->withErrors("Something went wrong. Please try again.");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $khajnaInfo = KhajnaInfo::where('id',$id)->first();

        if($khajnaInfo) {
            //log Info---------
            $log_info['user_id']     = Auth::user()->id;
            $log_info['module_name'] = 'land';
            $log_info['menu_name']   = 'khajna_info';
            $log_info['operation']   = 3;
            $log_info['khajna_infos_land_id'] = $khajnaInfo->land_id;
            $log_info['khajna_infos_khajna_date']  =$khajnaInfo->khajna_date;
            $log_info['khajna_infos_khajna_date_month'] =$khajnaInfo->khajna_date_month;
            $log_info['khajna_infos_khajna_date_year']  =$khajnaInfo->khajna_date_year;
            $log_info['khajna_infos_from_year']      =$khajnaInfo->from_year;
            $log_info['khajna_infos_to_year']      =$khajnaInfo->to_year;
            $log_info['khajna_infos_khajna_office_id'] =$khajnaInfo->khajna_office_id;
            $log_info['khajna_infos_upazila_id'] =0;
            $log_info['khajna_infos_mowja_id'] = $khajnaInfo->mowja_id;
            $log_info['khajna_infos_bokeya'] =$khajnaInfo->bokeya;
            $log_info['khajna_infos_note'] = $khajnaInfo->note;
            $log_info['khajna_infos_deleted_by']  = Auth::user()->id;
            $log_info['khajna_infos_document']  = $khajnaInfo->document;
            $log_info['khajna_infos_dakhila']  = $khajnaInfo->dakhila;
            $log_info['khajna_infos_id']  =$id;
            $khajnaInfo->delete();
            LogDetailsStore($log_info);
            return redirect()->back()->with('success', 'Khajna Info Successfully Deleted');
        } else {
            return redirect()->back()->withErrors('No Data Found');
        }
    }

    public function getKhajnaOfficeInfo(Request $request){
        $khajnaOfficeInfo = KhajnaOfficeInfo::where('land_id', $request->id)->first();
        $landInfo = Land::find($request->id);
        $zoneInfo = Zone::where('id', $landInfo->zone_id)->pluck('title', 'id');

        $landSourceInfo = LandSource::find($landInfo->land_source_id);
        $landSource = [];
        $landSource['id'] = $landSourceInfo->id;
        $landSource['title'] = $landSourceInfo->title;

        $upazila = Upazila::where('id', $khajnaOfficeInfo->upazila_id)->pluck('upazila_name', 'id');
        // $mowza = Land::where('area_id', $khajnaOfficeInfo->mowja_id)->pluck('title', 'id');
        $mowza = Area::where('id',  $landInfo->area_id)->pluck('title', 'id');
        $khajnaOffice = KhajnaOffice::where('id', $khajnaOfficeInfo->khajna_office_id)->pluck('office_name', 'id');

        $bokeyaArray = KhajnaOfficeInfo::where('land_id', $request->id)->get();
        $paidArray = KhajnaInfo::where('land_id', $request->id)->get();
        $totalBokeya =0;
        foreach ($bokeyaArray as $key => $bokeya) {
            $totalBokeya += bn2en($bokeya->total_bokeya);
        }
        $totalPaid =0;
        foreach ($paidArray as $key => $paid) {
            $totalPaid += bn2en($paid->bokeya);
        }

        $bokeya = ($totalBokeya - $totalPaid);
        if($bokeya <= 0){
            $bokeya = 0;
        }

        return response()->json([
            'upazila'        => $upazila,
            'mowza'          => $mowza,
            'khajnaOffice'   => $khajnaOffice,
            'landInfo'       => $landInfo,
            'zoneInfo'       => $zoneInfo,
            'landSource'     => $landSource,
            'bokeya'         => $bokeya
        ]);
    }

    public function getPorishoditoKhajnaInfo(Request $request){
        $khajnaInfo = KhajnaInfo::where('land_id', $request->id)->latest()->first();
        $paidYear = array();

        if(isset($khajnaInfo->to_year) && $khajnaInfo->to_year != 'null'){
            $paidYear['to'] = $khajnaInfo->to_year;
        }
        else{
            $paidYear['from'] = $khajnaInfo->from_year;
        }

        return response()->json([
            'paidYear' => $paidYear
        ]);
    }

    public function single_pdf($id)
    {
        $khajnaInfo              = KhajnaInfo::findOrFail($id);

        ini_set('memory_limit', '3072M');
        set_time_limit(300);

        $html               = view("Land::khajnaInfo.single_export_pdf", compact('khajnaInfo'));

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

        $title              = "Khajna Info Details - " . date('Y-m-d H:i:s') . '.pdf';
        $mpdf->SetProtection(array('print'));
        $mpdf->SetTitle($title);
        $mpdf->SetAuthor("SSL Wireless");
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHtmlHeader(view('Land::khajnaInfo.pdf_header'));
        $mpdf->WriteHTML($html);
        $mpdf->Output($title, 'I');
        exit;
    }


    public function pdfList(Request $request)
    {
        $title              = "Khajna Info List Report - " . date('Y-m-d H:i:s') . '.pdf';
        $data['khajnaInfos']      = $this->__filter($request)->get();
        ini_set('memory_limit', '3072M');
        set_time_limit(300);
        $html               = view("Land::khajnaInfo.export_pdf", $data);

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
        $mpdf->SetHtmlHeader(view('Land::khajnaInfo.pdf_header',$data));
        $mpdf->SetHtmlFooter(view('Land::khajnaInfo.pdf_footer',$data));
        $mpdf->WriteHTML($html);
        $mpdf->Output($title, 'I');
        exit;
    }

    public function export(Request $request)
    {
        $result         = $this->__filter($request)->get();

        $data           = [];
        foreach ($result as $row) {
            if(isset($row->land->title)){
                $landArray  = [
                    'স্থাপনার নাম'   => $row->land->title,
                ];
            }else{
                $landArray  = [
                    'স্থাপনার নাম'   => "",
                ];
            }
            
            // $upazilaArray  = [
            //     'উপজেলা'   => $row->upazila->upazila_name,
            // ];
            // $mowjaArray  = [
            //     'মৌজা'   => $row->mowza->mowja_name,
            // ];

            if($row->khajna_office->office_name){
                $khajnaOffArray  = [
                    'ভূমি অফিসের নাম'  => $row->khajna_office->office_name,
                ];
            }else{
                $khajnaOffArray  = [
                    'ভূমি অফিসের নাম'  => "",
                ];
            }
            

            $row['খাজনার পরিমাণ']  = $row->bokeya;
            $row['হাল']    = $row->hal;
            $row['মন্তব্য']    = $row->note;
            
            $data[] = array_merge($landArray,$khajnaOffArray, $row->only([
                'খাজনার পরিমাণ', 'হাল', 'মন্তব্য'
            ]));
        }

        Excel::create('Khajna Info List', function ($excel) use ($data) {
            $excel->sheet('Khajna Info List', function ($sheet) use ($data) {
                $sheet->setOrientation('landscape');
                $sheet->fromArray($data);
            });
        })->export('xls');

    }


    private function __filter($request)
    {
        $query = array();
        if ($request->land_id != null) {
            $query['land_id']           = $request->land_id;
        }
        if ($request->upazila_id != null) {
            $query['upazila_id']           = $request->upazila_id;
        }
        if ($request->mowja_id != null) {
            $query['mowja_id']           = $request->mowja_id;
        }
        if ($request->khajna_office_id != null) {
            $query['khajna_office_id']           = $request->khajna_office_id;
        }
        $khajnaInfoQuery = KhajnaInfo::where($query);
        ($request->bokeya ? $khajnaInfoQuery->where('bokeya', 'like', '%' . $request->bokeya . '%') : null);
        ($request->hal ? $khajnaInfoQuery->where('hal', 'like', '%' . $request->hal . '%') : null);

        // if ($request->address != null) {
        //     $landQuery->where('address', 'like', "%{$request->address}%");
        // }

        $khajnaInfos = $khajnaInfoQuery->with(['land','upazila','mowza','khajna_office']);
        return $khajnaInfos;
    }
}
