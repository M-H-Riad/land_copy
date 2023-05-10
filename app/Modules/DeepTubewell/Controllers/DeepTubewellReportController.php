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

class DeepTubewellReportController extends Controller
{
    public function getDeeptubewellReport(Request $request)
    {
    
        $searchedData = 0;
        if($request->has('zone_id')){
            $searchedData = 1;
        }

        
        if($request->has('area_id')){
            $searchedData = 1;
        }
       
        if($request->has('deep_source_type_id')){
            $searchedData = 1;
        }
    
        if($request->has('onumoti_chukti_boraddo')){
            $searchedData = 1;
        }

        $deep_infos = $this->__deep_tubewell_report_filter($request)->paginate(10);
        $zones    = Zone::pluck('title', 'id');
        $deep_source_types    = DeepTubewellSourceType::pluck('title', 'id');
        $areas      = Area::pluck('title', 'id');
        
        return view('DeepTubewell::report.deep_tubewell-report', compact('deep_infos','searchedData','zones', 'deep_source_types', 'areas'));
    }

    private function __deep_tubewell_report_filter($request)
    {
        $query = array();
        if(isset($request->zone_id) && $request->zone_id != null){
            $query['zone_id'] = $request->zone_id;
        }

        if(isset($request->area_id) && $request->area_id != null){
            $query['area_id'] = $request->area_id;
        }

        if(isset($request->deep_source_type_id) && $request->deep_source_type_id != null){
            $query['source_type'] = $request->deep_source_type_id;
        }

        if(isset($request->onumoti_chukti_boraddo) && $request->onumoti_chukti_boraddo != null){
            $query['onumoti_chukti_boraddo'] = $request->onumoti_chukti_boraddo;
        }

        $getDeeptubewell   = DeepTubewell::where($query);
        $getDeeptubewell->orderBy('created_at', 'DESC');
        
        $deepTubewells     = $getDeeptubewell->with(['zone', 'area', 'sourceType','sources']);
        return $deepTubewells;


        // $deepTubewellQuery = DB::table('deep_tubewell')->where('zone_id', $request->zone_id)
        //                 ->where('area_id', $request->area_id)
        //                 ->where('source_type', $request->deep_source_type_id)
        //                 ->join('lands', 'lands.id', 'namjaris.land_id');
        // // $namjariQuery = Namjari::where($query)->with('land')->get();
        // return $deepTubewellQuery;
    }

    public function getDeeptubewellReportPdf(Request $request)
    {
        $title              = "Deep-Tubewell - " . date('Y-m-d H:i:s') . '.pdf';
        $data['deep_infos']      = $this->__deep_tubewell_report_filter($request)->get();
        ini_set('memory_limit', '3072M');
        set_time_limit(300);
        $html               = view("DeepTubewell::report.deep_tubewell-report-pdf", $data);

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
        $mpdf->SetHtmlHeader(view('DeepTubewell::report.deep_tubewell-report-pdf-header',$data));
        $mpdf->WriteHTML($html);
        $mpdf->Output($title, 'I');
        exit;
    }

}




