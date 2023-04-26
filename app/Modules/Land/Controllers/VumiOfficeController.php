<?php

namespace App\Modules\Land\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Land\Models\VumiOffice;
use Illuminate\Support\Facades\Auth;
use Log;
use Maatwebsite\Excel\Facades\Excel;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Mpdf\Mpdf;

class VumiOfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $vumiOffices = $this->__filter($request)->paginate(10);
        return view('Land::vumiOffice.index', compact('vumiOffices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Land::vumiOffice.create');
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
            'office_name'     => 'required',
        ]);
        
        $data = [
            'office_name'     => $request->office_name,
            'address'         => $request->address
        ];
        
        //log Info---------
        $log_info['user_id']     = Auth::user()->id;
        $log_info['module_name'] = 'land';
        $log_info['menu_name']   = 'vumi_office';
        $log_info['operation']   = 1;
        $log_info['vumi_office_office_name'] = $request->office_name;
        $log_info['vumi_office_upazila_id']  = 0;
        $log_info['vumi_office_mowja_id']    = 0;
        $log_info['vumi_office_address']     = $request->address;
        $log_info['vumi_office_status']      = 1;
        $log_info['vumi_office_created_by']  = Auth::user()->id;
        
        try {
            $id=VumiOffice::create($data)->id;
            $log_info['vumi_office_id'] = $id;
            LogDetailsStore($log_info);

            return redirect('land/vumi_office/')->with('success', 'Vumi Office added successfully');
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
        $vumiOffice = VumiOffice::find($id);
        return view('Land::vumiOffice.show', compact('vumiOffice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vumiOffice = VumiOffice::find($id);
        return view('Land::vumiOffice.edit', compact('vumiOffice'));

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
            'office_name'     => 'required',
        ]);
        
        $data = [
            'office_name'     => $request->office_name,
            'address'         => $request->address
        ];
        
        //log Info---------
        $log_info['user_id']     = Auth::user()->id;
        $log_info['module_name'] = 'land';
        $log_info['menu_name']   = 'vumi_office';
        $log_info['operation']   = 2;
        $log_info['vumi_office_office_name'] = $request->office_name;
        $log_info['vumi_office_upazila_id']  = 0;
        $log_info['vumi_office_mowja_id']    = 0;
        $log_info['vumi_office_address']     = $request->address;
        $log_info['vumi_office_status']      = 1;
        $log_info['vumi_office_updated_by']  = Auth::user()->id;
        $log_info['vumi_office_id'] = $id;
            
        try {
            VumiOffice::where('id', $id)->update($data);
            LogDetailsStore($log_info);

            return redirect('land/vumi_office/')->with('success', 'Vumi Office added successfully');
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
    public function destroy(VumiOffice $vumiOffice)
    {
        if($vumiOffice) {
            //log Info---------
            $log_info['user_id']     = Auth::user()->id;
            $log_info['module_name'] = 'land';
            $log_info['menu_name']   = 'vumi_office';
            $log_info['operation']   =  3;
            $log_info['vumi_office_office_name'] = $vumiOffice->office_name;
            $log_info['vumi_office_upazila_id']  = 0;
            $log_info['vumi_office_mowja_id']    = 0;
            $log_info['vumi_office_address']     = $vumiOffice->address;
            $log_info['vumi_office_status']      = 1;
            $log_info['vumi_office_deleted_by']  = Auth::user()->id;
            $log_info['vumi_office_id'] = $vumiOffice->id;

            $vumiOffice->delete();
            LogDetailsStore($log_info);

            return redirect()->back()->with('success', 'Vumi Office Successfully Deleted');
        } else {
            return redirect()->back()->withErrors('No Data Found');
        }
    }

    public function single_pdf($id)
    {
        $vumiOffice              = VumiOffice::findOrFail($id);

        ini_set('memory_limit', '3072M');
        set_time_limit(300);

        $html               = view("Land::vumiOffice.single_export_pdf", compact('vumiOffice'));

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

        $title              = "Vumi Office Details - " . date('Y-m-d H:i:s') . '.pdf';
        $mpdf->SetProtection(array('print'));
        $mpdf->SetTitle($title);
        $mpdf->SetAuthor("SSL Wireless");
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHtmlHeader(view('Land::vumiOffice.pdf_header'));
        $mpdf->WriteHTML($html);
        $mpdf->Output($title, 'I');
        exit;
    }

    public function pdfList(Request $request)
    {
        $title              = "ভূমি অফিসের তালিকা Report - " . date('Y-m-d H:i:s') . '.pdf';
        $data['vumiOffices']      = $this->__filter($request)->get();
        ini_set('memory_limit', '3072M');
        set_time_limit(300);
        $html               = view("Land::vumiOffice.export_pdf", $data);

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

        $mpdf->SetProtection(array('print'));

        $mpdf->SetTitle($title);
        $mpdf->SetAuthor("SSL Wireless");
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHtmlHeader(view('Land::vumiOffice.pdf_header',$data));
        $mpdf->SetHtmlFooter(view('Land::vumiOffice.pdf_footer',$data));
        $mpdf->WriteHTML($html);
        $mpdf->Output($title, 'I');
        exit;
    }

    private function __filter($request)
    {        
        $vumiOfficeQuery = VumiOffice::where('office_name', 'like', '%' . $request->office_name . '%');

        if ($request->address != null) {
            $vumiOfficeQuery->where('address', 'like', "%{$request->address}%");
        }
        $vumiOffices = $vumiOfficeQuery;
        return $vumiOffices;
    }
}
