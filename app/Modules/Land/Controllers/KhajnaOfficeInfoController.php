<?php

namespace App\Modules\Land\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Land\Models\KhajnaOffice;
use App\Modules\Land\Models\KhajnaOfficeInfo;
use App\Modules\Land\Models\Land;
use App\Modules\Land\Models\Mowja;
use App\Modules\Land\Models\Upazila;
use Illuminate\Support\Facades\Log;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Mpdf\Mpdf;
use Maatwebsite\Excel\Facades\Excel;

class KhajnaOfficeInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $khajnaOffices = $this->__filter($request)->paginate(10);
        $lands         =    Land::all()->pluck('title', 'id');
        $upazilas      =    Upazila::all()->pluck('upazila_name', 'id');
        $moujas        =    Mowja::all()->pluck('mowja_name', 'id');
        $khajnaOff     =    KhajnaOffice::all()->pluck('office_name', 'id');

        return view('Land::khajnaOfficeInfo.index', compact('khajnaOffices','lands','upazilas','moujas','khajnaOff'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lands         =    Land::all()->pluck('title', 'id');
        $khajnaOffices =    KhajnaOffice::all()->pluck('office_name', 'id');

        return view('Land::khajnaOfficeInfo.create', compact('lands','khajnaOffices'));
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
            'land_id'                      => 'required',
            'khajna_office_id'                       => 'required',
            'open_year'                       => 'required',
            'total_bokeya'                       => 'required',
            'from_year'                       => 'required',
            'to_year'                       => 'required'
        ]);

        $data = [
            'land_id'              => $request->land_id,
            'khajna_office_id'      => $request->khajna_office_id,
            'open_year'             => $request->open_year,
            'total_bokeya'          => $request->total_bokeya,
            'from_year'             => $request->from_year,
            'to_year'               => $request->to_year,
        ];

        try {
            KhajnaOfficeInfo::create($data);
            return redirect('land/khajna-office/')->with('success', 'Khajna Office info added successfully');
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
        $khajnaOffice = KhajnaOfficeInfo::where('id', $id)->first();
        return view('Land::khajnaOfficeInfo.show', compact('khajnaOffice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $khajnaOfficeInfo = KhajnaOfficeInfo::where('id', $id)->first();

        $lands         =    Land::all()->pluck('title', 'id');
        
        $khajnaOffices =    KhajnaOffice::all()->pluck('office_name', 'id');
        
        return view('Land::khajnaOfficeInfo.edit', compact('lands','khajnaOffices','khajnaOfficeInfo'));
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
            'land_id'                      => 'required',
            'khajna_office_id'                       => 'required',
            'open_year'                       => 'required',
            'total_bokeya'                       => 'required',
            'from_year'                       => 'required',
            'to_year'                       => 'required'
        ]);

        $data = [
            'land_id'              => $request->land_id,
            'khajna_office_id'     => $request->khajna_office_id,
            'open_year'             => $request->open_year,
            'total_bokeya'          => $request->total_bokeya,
            'from_year'             => $request->from_year,
            'to_year'               => $request->to_year,
        ];

        try {
            KhajnaOfficeInfo::where('id', $id)->update($data);
            return redirect('land/khajna-office/')->with('success', 'Khajna Office info updated successfully');
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
        $khajna = KhajnaOfficeInfo::where('id',$id)->first();

        if($khajna) {
            $khajna->delete();
            return redirect()->back()->with('success', 'Khajna Office Info Successfully Deleted');
        } else {
            return redirect()->back()->withErrors('No Data Found');
        }
    }

    public function single_pdf($id)
    {
        $khajnaOfficeInfo              = KhajnaOfficeInfo::findOrFail($id);

        ini_set('memory_limit', '3072M');
        set_time_limit(300);

        $html               = view("Land::khajnaOfficeInfo.single_export_pdf", compact('khajnaOfficeInfo'));

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

        $title              = "Khajna Office Details - " . date('Y-m-d H:i:s') . '.pdf';
        $mpdf->SetProtection(array('print'));
        $mpdf->SetTitle($title);
        $mpdf->SetAuthor("SSL Wireless");
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHtmlHeader(view('Land::khajnaOfficeInfo.pdf_header'));
        $mpdf->WriteHTML($html);
        $mpdf->Output($title, 'I');
        exit;
    }

    public function get_mowja(Request $request){
        $mowjas = Mowja::where('upazila_id', $request->id)->pluck('mowja_name', 'id');
        return response()->json([
            'mowjas' => $mowjas
        ]);
    }

    public function get_khajnaOffice(Request $request){
        $khajnaoffices = KhajnaOffice::where('mowja_id', $request->mowja_id)->pluck('office_name', 'id');
        return response()->json([
            'khajnaoffices' => $khajnaoffices
        ]);
    }

    public function pdfList(Request $request)
    {
        $title              = "Khajna Office Info List Report - " . date('Y-m-d H:i:s') . '.pdf';
        $data['khajnaOffices']      = $this->__filter($request)->get();
        ini_set('memory_limit', '3072M');
        set_time_limit(300);
        $html               = view("Land::khajnaOfficeInfo.export_pdf", $data);

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
        $mpdf->SetHtmlHeader(view('Land::khajnaOfficeInfo.pdf_header',$data));
        $mpdf->SetHtmlFooter(view('Land::khajnaOfficeInfo.pdf_footer',$data));
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

            if(isset($row->mokhajna_office->office_name)){
                $khajnaOffArray  = [
                    'ভূমি অফিসের নাম'  => $row->mokhajna_office->office_name,
                ];
            }else{
                $khajnaOffArray  = [
                    'ভূমি অফিসের নাম'  => "",
                ];
            }
            

            $row['ওপেনিং কর দাবির সন']  = $row->open_year;
            $row['বকেয়ার পরিমাণ']    = $row->total_bokeya;

            if($row->status == 1)
            {
                $row['স্টেটাস'] = "YES";
            }else{
                $row['স্টেটাস'] = "NO";
            }
            
            $data[] = array_merge($landArray,$khajnaOffArray, $row->only([
               'ভূমি অফিসের নাম', 'ওপেনিং কর দাবির সন', 'বকেয়ার পরিমাণ', 'স্টেটাস'
            ]));
        }

        Excel::create('Khajna Office Info List', function ($excel) use ($data) {
            $excel->sheet('Khajna Office Info List', function ($sheet) use ($data) {
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
        $khajnaOfficeInfoQuery = KhajnaOfficeInfo::where($query);

        $khajnaOfficeInfo = $khajnaOfficeInfoQuery->with(['land','upazila','mowza','mokhajna_office']);
        return $khajnaOfficeInfo;
    }
}
