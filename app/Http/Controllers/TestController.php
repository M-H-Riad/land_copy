<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Mpdf\Mpdf;

class TestController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $html = view('test.pdf-view');

        $defaultConfig = (new ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $mpdf = new mPDF([
            'tempDir' => storage_path(),
            'mode' => 'utf-8',
            'format' => 'A4',
            'fontDir' => array_merge($fontDirs, [
                public_path('fonts'),
            ]),
            'fontdata' => $fontData + [
        'solaimanlipi' => [
            'R' => "SolaimanLipi.ttf",
            'useOTL' => 0xFF,
        ],
            ],
            'default_font' => 'solaimanlipi'
        ]);

        $mpdf->SetProtection(array('print'));
        $mpdf->SetTitle("Employee Profile - WASA-PMIS");
        $mpdf->SetAuthor("SSL Wireless");
        $mpdf->SetDisplayMode('fullpage');

        $mpdf->WriteHTML($html);
        $mpdf->Output('wasa.pdf', 'I');
        exit;
    }

}
