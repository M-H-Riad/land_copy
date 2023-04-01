<?php

namespace App\Modules\Land\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Land\Models\KhajnaOfficeInfo;
use App\Modules\Land\Models\Land;
use App\Modules\Land\Models\Zone;
use App\Modules\Land\Models\Zila;
use App\Modules\Land\Models\Thana;
use App\Modules\Land\Models\Area;
use App\Modules\Land\Models\Namjari;
use Illuminate\Support\Facades\Log;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Mpdf\Mpdf;
use Maatwebsite\Excel\Facades\Excel;

class NamjariController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lands = Land::all()->pluck('title', 'id');
        $zones      = Zone::pluck('title', 'id');

        $namjaries = $this->__filter($request)->paginate(10);
        return view('Land::namjari.index', compact('namjaries','lands', 'zones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lands = Land::all()->pluck('title', 'id');
        return view('Land::namjari.create', compact('lands'));
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
            'status'                       => 'required',
            'jomir_sreny'                 => 'required_if:status,1',
            // 'namjari_date'                 => 'required_if:status,1',
            'namjari_khotian_no'           => 'required_if:status,1',
            'namjarir_dag_no'              => 'required_if:status,1',
            // 'ongsho_onujaie__jomir_poriman'=> 'required_if:status,1',
            // 'ongsho_onujaie_jomir_akok'    => 'required_if:status,1'
        ]);

        $data = [
            'land_id'                      => $request->land_id,
            'mowja_id'                      => $request->mowja_id,
            'zone_id'                      => $request->zone_id,
            'status'                       => $request->status,
            'jomir_sreny'                  => $request->jomir_sreny,
            'jomir_sreny_details'          => $request->jomir_sreny_details,
            'namjari_date'                 => $request->namjari_date,
            'purchase_date'                => $request->purchase_date,
            'namjari_khotian_no'           => $request->namjari_khotian_no,
            'namjarir_pore_khotian_no'     => 0,
            'namjarir_dag_no'              => $request->namjarir_dag_no,
            'oi_dage_mot_jomi'             => $request->oi_dage_mot_jomi,
            'jomir_unit'                   => $request->jomir_unit,
            'dager_moddhe_khotianer_ongsho'=> $request->dager_moddhe_khotianer_ongsho,
            'ongsho_onujaie__jomir_poriman'=> $request->ongsho_onujaie__jomir_poriman,
            'ongsho_onujaie_jomir_akok'    => $request->ongsho_onujaie_jomir_akok,
            'namjari_jot_no'               => $request->namjari_jot_no,
            'namjari_jl_no'                => $request->namjari_jl_no,
            'note'                         => $request->note
        ];

        try {
            Namjari::create($data);
            return redirect('land/namjari/')->with('success', 'Namjari added successfully');
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
        $namjari = Namjari::where('id', $id)->first();
        return view('Land::namjari.show', compact('namjari', 'fileTypes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lands = Land::all()->pluck('title', 'id');
        $namjari = Namjari::where('id', $id)->first();

        return view('Land::namjari.edit', compact('lands','namjari'));
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
            'status'                       => 'required',
            'jomir_sreny'                  => 'required_if:status,1',
            // 'namjari_date'                 => 'required_if:status,1',
            'namjari_khotian_no'           => 'required_if:status,1',
            'namjarir_dag_no'              => 'required_if:status,1',
            // 'ongsho_onujaie__jomir_poriman'=> 'required_if:status,1',
            // 'ongsho_onujaie_jomir_akok'    => 'required_if:status,1'
        ]);

        if($request->status == 1){

            $data = [
                'land_id'                      => $request->land_id,
                'mowja_id'                      => $request->mowja_id,
                'zone_id'                      => $request->zone_id,
                'status'                       => $request->status,
                'jomir_sreny'                  => $request->jomir_sreny,
                'jomir_sreny_details'          => $request->jomir_sreny_details,
                'namjari_date'                 => $request->namjari_date,
                'purchase_date'                => $request->purchase_date,
                'namjari_khotian_no'           => $request->namjari_khotian_no,
                'namjarir_pore_khotian_no'     => $request->namjarir_pore_khotian_no,
                'namjarir_dag_no'              => $request->namjarir_dag_no,
                'oi_dage_mot_jomi'             => $request->oi_dage_mot_jomi,
                'jomir_unit'                   => $request->jomir_unit,
                'dager_moddhe_khotianer_ongsho'=> $request->dager_moddhe_khotianer_ongsho,
                'ongsho_onujaie__jomir_poriman'=> $request->ongsho_onujaie__jomir_poriman,
                'ongsho_onujaie_jomir_akok'    => $request->ongsho_onujaie_jomir_akok,
                'namjari_jot_no'               => $request->namjari_jot_no,
                'namjari_jl_no'                => $request->namjari_jl_no,
                'note'                         => $request->note
            ];
        }else{
            $data = [
                'land_id'                      => $request->land_id,
                'mowja_id'                      => $request->mowja_id,
                'zone_id'                      => $request->zone_id,
                'status'                       => $request->status,
                'jomir_sreny'                  => null,
                'namjari_date'                 => null,
                'purchase_date'                => null,
                'namjari_khotian_no'           => null,
                'namjarir_pore_khotian_no'     => null,
                'namjarir_dag_no'              => null,
                'oi_dage_mot_jomi'             => null,
                'jomir_unit'                   => null,
                'dager_moddhe_khotianer_ongsho'=> null,
                'ongsho_onujaie__jomir_poriman'=> null,
                'ongsho_onujaie_jomir_akok'    => null,
                'namjari_jot_no'               => null,
                'namjari_jl_no'                => null,
                'note'                         => null
            ];
        }

        try {
            Namjari::where('id', $id)->update($data);
            return redirect('land/namjari/')->with('success', 'Namjari updated successfully');
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
    public function destroy(Namjari $namjari)
    {
        if($namjari) {
            $namjari->delete();
            return redirect()->back()->with('success', 'namjari Successfully Deleted');
        } else {
            return redirect()->back()->withErrors('No Data Found');
        }
    }

    public function single_pdf($id)
    {
        $namjari               = Namjari::findOrFail($id);

        $khajnaOfficeInfoQuery = KhajnaOfficeInfo::where('land_id', $namjari->land_id);

        $khajnaOfficeInfo = $khajnaOfficeInfoQuery->with(['land','upazila','mowza','mokhajna_office'])->first();

        ini_set('memory_limit', '3072M');
        set_time_limit(300);

        $html               = view("Land::namjari.single_export_pdf", compact('namjari','khajnaOfficeInfo'));

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

        $title              = "Namjari Details - " . date('Y-m-d H:i:s') . '.pdf';
        $mpdf->SetProtection(array('print'));
        $mpdf->SetTitle($title);
        $mpdf->SetAuthor("SSL Wireless");
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHtmlHeader(view('Land::namjari.pdf_header'));
        $mpdf->WriteHTML($html);
        $mpdf->Output($title, 'I');
        exit;
    }


    
    public function pdfList(Request $request)
    {
        $title              = "Namjari List Report - " . date('Y-m-d H:i:s') . '.pdf';
        $data['namjaries']      = $this->__filter($request)->get();
        ini_set('memory_limit', '3072M');
        set_time_limit(300);
        $html               = view("Land::namjari.export_pdf", $data);

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
        $mpdf->SetHtmlHeader(view('Land::namjari.pdf_header',$data));
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
                $dataArray  = [
                    'স্থাপনার নাম'      => $row->land->title,
                ];
            }else{
                $dataArray  = [
                    'স্থাপনার নাম'      => "",
                ];
            }
            
            if($row->jomir_sreny == 1)
            {
                $row['জমির শ্রেণী'] = "অকৃষি";
            }else{
                $row['জমির শ্রেণী'] = "কৃষি";
            }
            if($row->status == 1)
            {
                $row['স্টেটাস'] = "YES";
            }else{
                $row['স্টেটাস'] = "NO";
            }

            $jomir_unit = $this->getJomirUnit($row->jomir_unit);
            $ongsho_onujaie_jomir_akok = $this->getOngshoOnujaieJomirAkok($row->ongsho_onujaie_jomir_akok);

            $row['নামজারি তারিখ'] = en2bn($row->namjari_date);
            // $row['প্রাপ্তির তারিখ'] = en2bn($row->purchase_date);
            $row['নামজারির খতিয়ান নং'] = $row->namjari_khotian_no;
            $row['নামজারির পর প্রাপ্ত খতিয়ান নং'] = $row->namjarir_pore_khotian_no;
            $row['নামজারিকৃত দাগ নং'] = $row->namjarir_dag_no;
            $row['ওই দাগে মোট জমির পরিমান'] = $row->oi_dage_mot_jomi." ".$jomir_unit;
            $row['দাগের মধ্যে অত্র খতিয়ানের অংশ'] = $row->dager_moddhe_khotianer_ongsho;
            $row['অংশ অনুযায়ীই জমির পরিমান'] = $row->ongsho_onujaie__jomir_poriman." ".$ongsho_onujaie_jomir_akok;
            $row['নামজারির জোত নং'] = $row->namjari_jot_no;
            $row['নামজারির জে এল নং'] = $row->namjari_jl_no;
            $row['মন্তব্য'] = $row->note;


            $data[] = array_merge($dataArray, $row->only([
                'স্টেটাস','জমির শ্রেণী','নামজারি তারিখ', 'নামজারির খতিয়ান নং', 'নামজারির পর প্রাপ্ত খতিয়ান নং', 'নামজারিকৃত দাগ নং',
                 'ওই দাগে মোট জমির পরিমান','দাগের মধ্যে অত্র খতিয়ানের অংশ', 'অংশ অনুযায়ীই জমির পরিমান', 'নামজারির জোত নং', 'নামজারির জে এল নং', 'মন্তব্য',
            ]));
        }

        Excel::create('Namjari List', function ($excel) use ($data) {
            $excel->sheet('Namjari List', function ($sheet) use ($data) {
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
        if ($request->zone_id != null) {
            $query['zone_id']           = $request->zone_id;
        }
        $namjariQuery                      = Namjari::where($query);

        ($request->filled('jomir_sreny') ? $namjariQuery->where('jomir_sreny', $request->jomir_sreny) : null);
        ($request->namjari_khotian_no ? $namjariQuery->where('namjari_khotian_no', 'like', '%' .  $request->namjari_khotian_no . '%') : null);
        ($request->namjarir_pore_khotian_no ? $namjariQuery->where('namjarir_pore_khotian_no', 'like', '%' .  $request->namjarir_pore_khotian_no . '%') : null);
        ($request->namjarir_dag_no ? $namjariQuery->where('namjarir_dag_no', 'like', '%' .  $request->namjarir_dag_no . '%') : null);
        ($request->namjari_jot_no ? $namjariQuery->where('namjari_jot_no', 'like', '%' .  $request->namjari_jot_no . '%') : null);
        ($request->namjari_jl_no ? $namjariQuery->where('namjari_jl_no', 'like', '%' .  $request->namjari_jl_no . '%') : null);
        ($request->filled('status') ? $namjariQuery->where('status', $request->status) : null);

        $namjari = $namjariQuery->with(['land']);
        return $namjari;
    }

    private function getOngshoOnujaieJomirAkok($jomir_akok){
        if($jomir_akok == 1)
        {
            return "শতাংশ";
        }
        elseif($jomir_akok == 2)
        {
            return "অযুতাংশ";
        }
        elseif($jomir_akok == 3)
        {
            return "একর";
        }
        elseif($jomir_akok == 4)
        {
            return "কাঠা";
        }
        elseif($jomir_akok == 5)
        {
            return "বিঘা";
        }
    }
    private function getJomirUnit($jomir_akok){
        if($jomir_akok == 1)
        {
            return "শতাংশ";
        }
        elseif($jomir_akok == 2)
        {
            return "অযুতাংশ";
        }
        elseif($jomir_akok == 3)
        {
            return "একর";
        }
        elseif($jomir_akok == 4)
        {
            return "কাঠা";
        }
        elseif($jomir_akok == 5)
        {
            return "বিঘা";
        }
    }

    public function getLandInfo(Request $request){
        $landInfo = Land::find($request->id);
        $zoneInfo = Zone::where('id',$landInfo->zone_id)->pluck('title', 'id');
        $mowza = Area::where('id',  $landInfo->area_id)->pluck('title', 'id');
        $zila = Zila::where('id',  $landInfo->zila_id)->pluck('title', 'id');
        $thana = Thana::where('id',  $landInfo->thana_id)->pluck('title', 'id');
        
        return response()->json([
            'mowza'          => $mowza,
            'zoneInfo'       => $zoneInfo,
            'zila'       => $zila,
            'thana'       => $thana,
        ]);
    }

}
