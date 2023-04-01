<?php

namespace App\Modules\Land\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Land\Models\Land;
use App\Modules\Land\Models\KhajnaInfo;
use App\Modules\Land\Models\KhajnaOffice;
use App\Modules\Land\Models\KhajnaOfficeInfo;
use App\Modules\Land\Models\Namjari;
use App\Modules\Land\Models\Zone;
use App\Modules\Land\Models\Area;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Mpdf\Mpdf;
use DB;

class LandReportController extends Controller
{
    // First report starts..............
    public function getKhajnaPaymentReport(Request $request)
    {
        $searchedData = 0;
        if($request->has('land_id')){
            $searchedData = 1;
        }
        
        $lands        = $this->__filter($request)->paginate(10);
        $landArr      = Land::all()->pluck('title', 'id');
        return view('Land::report.khajna-pay-report', compact('lands','landArr','from_year','to_year', 'searchedData'));
    }

    public function khajnaPaymentReportPdfList(Request $request)
    {
        $title              = "স্থাপনা হিসেবে খাজনা পরিশোধের তথ্য - " . date('Y-m-d H:i:s') . '.pdf';
        $data['lands']      = $this->__filter($request)->get();
        ini_set('memory_limit', '3072M');
        set_time_limit(300);
        $html               = view("Land::report.export_pdf", $data);

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
        $mpdf->SetHtmlHeader(view('Land::report.pdf_header',$data));
        $mpdf->WriteHTML($html);
        $mpdf->Output($title, 'I');
        exit;
    }

    public function khajnaPaymentReportExport(Request $request)
    {
        ob_start();

        $lands        = $this->__filter($request)->get();
        
        /*print block*/

        ?>
        <style>
            @page {
            margin-left: 2cm;
                        margin-right: 2cm;
                        margin-top: 2cm;
                        margin-bottom: 2cm;
                    }

                    table {
            page-break-inside: auto
                    }

                    tr {
            page-break-inside: avoid;
                        page-break-after: auto
                    }

                    .tbl {
            border-collapse: collapse !important;
                        width: 100%;
                    }

                    .tbl2 {
            border-collapse: collapse !important;
                        width: 50%;
                    }

                    table.tbl thead tr th, table.tbl2 thead tr th {
            border: 1px solid #000;
                        text-align: center !important;
                        font-weight: normal;
                    }

                    table thead tr th,table tbody tr td, table tfoot tr td {
            /*padding-left: 10px !important;*/
            border: 1px solid #ccc;
                        text-align: center !important;
                        font-weight: normal;
                        vertical-align: middle;
                    }

                    table.tbl thead tr th, table.tbl2 thead tr th {
            text-align: center !important;
                    }

                    table.tbl td a {
            text-decoration: none;
                        color: #000000;
                        background: none;
                    }

        </style>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>স্থাপনার নাম</th>
                    <th>জোন</th>
                    <th>মৌজা</th>
                    <th>দাগ নং</th>
                    <th>খতিয়ান নং</th>
                    <th>জমির পরিমান (একর)</th>
                    <th>খাজনা পরিশোধের তারিখ</th>
                    <th>দাবির সন</th>
                    <th>খাজনার পরিমাণ</th>
                    <th>বকেয়া</th>
                </tr>
            </thead>
            <tbody>
                <?php 

                $i = 1; $grandTotal = 0; $BokeyaGrandTotal = 0;
                foreach($lands as $land)
                {
                
                    $khajnaQuery = KhajnaInfo::where('land_id', $land->id);
                    $khajnaInfos = $khajnaQuery->get();

                    //Bokeya calculation.........
                    $bokeyaArray = KhajnaOfficeInfo::where('land_id', $land->id)->get();
                    $paidArray = KhajnaInfo::where('land_id', $land->id)->get();
                    $totalBokeya =0;
                    $totalPaid =0;
                    foreach ($bokeyaArray as $key => $bokeya) {
                        $totalBokeya += bn2en($bokeya->total_bokeya);
                    }
                    foreach ($paidArray as $key => $paid) {
                        $totalPaid += bn2en($paid->bokeya);
                    }
                    $bokeya = ($totalBokeya - $totalPaid);
        
                    if(count($khajnaInfos) > 0)
                    { ?>
        
                        <tr>
                            <td><?php echo $i++;  ?></td>
                            <td><?php echo $land->title;   ?></td>
                            <td><?php echo $land->zone->title; ?></td>
                            <td><?php echo $land->area->title; ?></td>
                            <td><?php echo $land->dag_no; ?></td>
                            <td><?php echo $land->khotian; ?></td>
                            <td><?php echo $land->quantity; ?></td>
                            
                            <td>
                                <?php 
                                    if(count($khajnaInfos) > 0)
                                    {
                                        foreach($khajnaInfos as $khajna)
                                        {                                      
                                            echo $khajna->khajna_date; 
                                ?>
                                            <hr>                                    
                                <?php } ?>
                                    <b>-</b>
                            <?php } ?>
                            </td>
                            <td style="width: 250px;">
                                <?php if(count($khajnaInfos) > 0){
                                        foreach($khajnaInfos as $khajna){                                       
                                            echo $khajna->from_year; 
                                            if($khajna->to_year != 'null'){ echo "to ".$khajna->to_year; } ?>
                                            <hr>                                    
                                        <?php } ?>
                                    <span>পরিশোধিত খাজনার পরিমাণ</span>
                                <?php } ?>
                            </td>
                            <td>
                            <?php if(count($khajnaInfos) > 0){
                                    $subTotal= 0; 
                                    foreach($khajnaInfos as $khajna){                                      
                                        echo $khajna->bokeya;
                                        $subTotal += bn2en($khajna->bokeya); ?>
                                        <hr>                                    
                                    <?php } ?>
                                        <b><?php echo en2bn($subTotal); ?></b>
                                        <?php $grandTotal += $subTotal; ?>
                                <?php } ?>
                            </td>
                            <td>
                            <?php foreach($khajnaInfos as $khajna){ ?>
                                    - <hr>
                                <?php }
                                if ($bokeya > 0){  ?>
                                    <b><?php echo en2bn($bokeya); ?></b>
                                    <?php $BokeyaGrandTotal += bn2en($bokeya);
                                }else{  ?>
                                    <b>০</b>
                                <?php }    ?>
                            </td>
                        </tr>
                        <?php
                    }  
                }       ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td colspan="4" style="text-align:right;"> <b>মোট : </b></td>
                    <td><b><?php echo en2bn($grandTotal); ?></b></td>
                    <td><b><?php echo en2bn($BokeyaGrandTotal); ?></b></td>
                </tr>
            </tbody>
        </table>

        <!--print block-->

        <?php
            $html = ob_get_contents();

            $path = public_path() . '/excel/';

            ob_clean();
            foreach (glob($path."*.xls") as $filename)
            { 
                @unlink($filename);
            }
            //html to xls convert
            $name=time();
            $name= 'khajna_pay'. '_' . "$name".".xls";
            $create_new_excel = fopen($path . $name, 'w');
            $is_created = fwrite($create_new_excel,$html);
            echo "$html";

            header('Content-Type: ".xls"');
            header('Content-Disposition: attachment; filename="'.$name.'"');
            header("Content-Transfer-Encoding: binary");
            header('Expires: 0');
            header('Pragma: no-cache');
            header("Content-Length: ".strlen($is_created));
            exit($is_created);

    }

    private function __filter($request)
    {
        $query = array();
        if($request->land_id != null){
            $query['id'] = $request->land_id;
        }
        
        $landQuery = Land::where($query);
        $lands = $landQuery;
        return $lands;
    }
    // First report ends.............................

    // Fourth report starts...................
    public function getKhajnaVumiOfficeReport(Request $request)
    {
        $searchedData = 0;
        if($request->has('vumi_office_id')){
            $searchedData = 1;
        }
        
        $vumiOffices = $this->__vumi_office_report_filter($request)->paginate(10);
        $vumiOfficeArr = KhajnaOffice::all()->pluck('office_name','id');
        return view('Land::report.vumi-office-khajna-pay-report', compact('vumiOffices','searchedData','vumiOfficeArr'));
    }

    private function __vumi_office_report_filter($request)
    {
        $query = array();
        if($request->vumi_office_id != null){
            $query['id'] = $request->vumi_office_id;
        }
        
        $vumiQuery = KhajnaOffice::where($query);        
        $vumiOffices = $vumiQuery;
        return $vumiOffices;
    }

    
    public function khajnaPayVumiOfficeReportPdfList(Request $request)
    {
        $title              = "ভূমি অফিস হিসেবে খাজনা পরিশোধের তথ্য - " . date('Y-m-d H:i:s') . '.pdf';
        $data['vumiOffices']      = $this->__vumi_office_report_filter($request)->get();
        ini_set('memory_limit', '3072M');
        set_time_limit(300);
        $html               = view("Land::report.vumi-office-khajna-pay-report-pdf", $data);

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
        $mpdf->SetHtmlHeader(view('Land::report.vumi-office-khajna-pay-pdf-header',$data));
        $mpdf->WriteHTML($html);
        $mpdf->Output($title, 'I');
        exit;
    }

    public function vumiOfficekhajnaPayReportExport(Request $request){
        ob_start();

        $vumiOffices = $this->__vumi_office_report_filter($request)->get();

        /*print block*/

        ?>
        <style>
            @page {
            margin-left: 2cm;
                        margin-right: 2cm;
                        margin-top: 2cm;
                        margin-bottom: 2cm;
                    }

                    table {
            page-break-inside: auto
                    }

                    tr {
            page-break-inside: avoid;
                        page-break-after: auto
                    }

                    .tbl {
            border-collapse: collapse !important;
                        width: 100%;
                    }

                    .tbl2 {
            border-collapse: collapse !important;
                        width: 50%;
                    }

                    table.tbl thead tr th, table.tbl2 thead tr th {
            border: 1px solid #000;
                        text-align: center !important;
                        font-weight: normal;
                    }

                    table thead tr th,table tbody tr td, table tfoot tr td {
            /*padding-left: 10px !important;*/
            border: 1px solid #ccc;
                        text-align: center !important;
                        font-weight: normal;
                        vertical-align: middle;
                    }

                    table.tbl thead tr th, table.tbl2 thead tr th {
            text-align: center !important;
                    }

                    table.tbl td a {
            text-decoration: none;
                        color: #000000;
                        background: none;
                    }

        </style>

        <table>
            <thead>
                <tr>
                    <th>ভূমি অফিস হিসেবে খাজনা পরিশোধের তথ্য | Dhaka WASA</th>
                </tr>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <th>ID</th>
                    <th>ভূমি অফিসের নাম</th>
                    <th>স্থাপনার নাম</th>
                    <th>জোন</th>
                    <th>মৌজা</th>
                    <th>দাগ নং</th>
                    <th>খতিয়ান নং</th>
                    <th>জমির পরিমান (একর)</th>
                    <th>খাজনা পরিশোধের তারিখ</th>
                    <th>দাবির সন</th>
                    <th>মোট খাজনার পরিমাণ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(count($vumiOffices) > 0){
                    $i = 1; $grandTotal = 0;
                    foreach($vumiOffices as $vumiOffice){
                        $vumiOfficeLandIds = KhajnaOfficeInfo::where('khajna_office_id', $vumiOffice->id)->pluck('land_id');
                        $landQuery = Land::whereIn('id', $vumiOfficeLandIds);                                    
                        $lands = $landQuery->get();
                        $landIds = $landQuery->pluck('id');
                        
                        if(count($lands) > 0){
                            $khajnaQuery = KhajnaInfo::whereIn('land_id', $landIds);
                            $khajnaInfos = $khajnaQuery->get();
                                
                                if(count($khajnaInfos) > 0){ ?>
                                    <tr style="border: 1px solid black;">
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $vumiOffice->office_name; ?></td>
                                    <td>
                                    <?php if(count($khajnaInfos) > 0){ ?>
                                            <table class="sub-table">
                                            <?php foreach($khajnaInfos as $khajna){ ?>
                                                <?php foreach($lands as $land){ ?>
                                                    <?php if ($khajna->land_id == $land->id){ ?>
                                                            <tr style="border-bottom: 1px solid black;">
                                                                <td><span><?php echo $land->title; ?></span></td>
                                                            </tr>
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            </table>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if(count($khajnaInfos) > 0){ ?>
                                            <table class="sub-table">
                                            <?php foreach($khajnaInfos as $khajna){ ?>
                                                    <?php foreach($lands as $land){ ?>
                                                        <?php if ($khajna->land_id == $land->id){ ?>
                                                            <tr>
                                                                <td>
                                                                <?php if ($land->zone){ ?>
                                                                        <?php echo $land->zone->title; ?>
                                                                    <?php } ?>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            </table>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if(count($khajnaInfos) > 0){ ?>
                                            <table class="sub-table">
                                                <?php foreach($khajnaInfos as $khajna){ ?>
                                                    <?php foreach($lands as $land){ ?>
                                                        <?php if ($khajna->land_id == $land->id){ ?>
                                                            <tr>
                                                                <td>
                                                                <?php if (isset($land->area)){ ?>
                                                                        <?php echo $land->area->title; ?>
                                                                    <?php } ?>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            </table>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if(count($khajnaInfos) > 0){ ?>
                                            <table class="sub-table">
                                                <?php foreach($khajnaInfos as $khajna){ ?>
                                                    <?php foreach($lands as $land){ ?>
                                                        <?php if ($khajna->land_id == $land->id){ ?>
                                                            <tr>
                                                                <td><?php echo $land->dag_no; ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            </table>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if(count($khajnaInfos) > 0){ ?>
                                            <table class="sub-table">
                                                <?php foreach($khajnaInfos as $khajna){ ?>
                                                    <?php foreach($lands as $land){ ?>
                                                        <?php if ($khajna->land_id == $land->id){ ?>
                                                            <tr>
                                                                <td><?php echo $land->khotian; ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            </table>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if(count($khajnaInfos) > 0){ ?>
                                            <table class="sub-table">
                                                <?php foreach($khajnaInfos as $khajna){ ?>
                                                    <?php foreach($lands as $land){ ?>
                                                        <?php if ($khajna->land_id == $land->id){ ?>
                                                            <tr>
                                                                <td><?php echo $land->quantity; ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            </table>
                                        <?php } ?>
                                    </td>
                                    
                                    <td>
                                        <?php if(count($khajnaInfos) > 0){ ?>
                                        <table class="sub-table">
                                            <?php foreach($khajnaInfos as $khajna){ ?>
                                                <?php foreach($lands as $land){ ?>
                                                    <?php if ($khajna->land_id == $land->id){ ?>
                                                        <tr>
                                                            <td><?php echo  en2bn($khajna->khajna_date); ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                <?php } ?>
                                            <?php } ?>
                                        </table>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if(count($khajnaInfos) > 0){ ?>
                                        <table class="sub-table">
                                            <?php foreach($khajnaInfos as $khajna){ ?>
                                                <?php foreach($lands as $land){ ?>
                                                    <?php if ($khajna->land_id == $land->id){ ?>
                                                        <tr>
                                                            <td><?php echo en2bn($khajna->from_year); ?> <?php if($khajna->to_year != 'null'){ echo "to ".en2bn($khajna->to_year); } ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                <?php } ?>
                                            <?php } ?>
                                            <tr>
                                                <td><b>পরিশোধিত মোট খাজনার পরিমাণ</b></td>
                                            </tr>
                                        </table>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if(count($khajnaInfos) > 0){ ?>
                                        <?php $subTotal = 0; ?>
                                        <table class="sub-table">
                                            <?php foreach($khajnaInfos as $khajna){ ?>
                                                <?php foreach($lands as $land){ ?>
                                                    <?php if ($khajna->land_id == $land->id){ ?>
                                                        <tr>
                                                            <td><?php echo en2bn($khajna->bokeya); ?></td>
                                                            <?php $subTotal += bn2en($khajna->bokeya); ?>
                                                        </tr>
                                                    <?php } ?>
                                                <?php } ?>
                                            <?php } ?>
                                            <tr>
                                                <td><b><?php echo en2bn($subTotal); ?></b></td>
                                                <?php $grandTotal += bn2en($subTotal); ?>
                                            </tr>
                                        </table>
                                        <?php } ?>
                                    </td>
                                </tr>
                             <?php }
                        }
                    } ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td colspan="4" class="text-center"> <b>মোট খাজনার পরিমাণ: </b></td>
                        <td><b><?php echo en2bn($grandTotal); ?></b></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!--print block-->

        <?php
            $html = ob_get_contents();

            $path = public_path() . '/excel/';

            ob_clean();
            foreach (glob($path."*.xls") as $filename)
            { 
                @unlink($filename);
            }
            //html to xls convert
            $name=time();
            $name= 'vumi_office_khajna_pay'. '_' . "$name".".xls";
            $create_new_excel = fopen($path . $name, 'w');
            $is_created = fwrite($create_new_excel,$html);
            echo $html;

            header('Content-Type: ".xls"');
            header('Content-Disposition: attachment; filename="'.$name.'"');
            header("Content-Transfer-Encoding: binary");
            header('Expires: 0');
            header('Pragma: no-cache');
            header("Content-Length: ".strlen($html));
            exit($html);
    }
    // Fourth report ends........................

    //Second report starts........................
    public function getYearlyKhajnaPayReport(Request $request){
        $searchedData = 0;
        if($request->has('year')){
            $searchedData = 1;
        }        
        $khajnaPayYears = $this->__yearly_khajna_pay_report_filter($request)->select('khajna_date_year as year')->groupBy('khajna_date_year')->paginate(10);

        return view('Land::report.yearly-khajna-pay-report', compact('khajnaPayYears','searchedData'));
    }

    private function __yearly_khajna_pay_report_filter($request)
    {
        $query = array();        
        if(isset($request->year) && $request->year != null){
            $query['khajna_date_year'] = $request->year;
        }

        $KhajnaQuery = KhajnaInfo::where($query);
        $khajnaPayYears = $KhajnaQuery;
        return $khajnaPayYears;
    }

    public function yearlyKhajnaPayReportPdfList(Request $request)
    {
        $title              = "বাৎসরিক খাজনা পরিশোধের তথ্য - " . date('Y-m-d H:i:s') . '.pdf';
        $data['khajnaPayYears']      = $this->__yearly_khajna_pay_report_filter($request)->select('khajna_date_year as year')->groupBy('khajna_date_year')->get();
        ini_set('memory_limit', '3072M');
        set_time_limit(300);
        $html               = view("Land::report.yearly-khajna-pay-report-pdf", $data);

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
        $mpdf->SetHtmlHeader(view('Land::report.yearly-khajna-pay-pdf-header',$data));
        $mpdf->WriteHTML($html);
        $mpdf->Output($title, 'I');
        exit;
    }

    public function yearlykhajnaPayReportExport(Request $request){
        ob_start();

        $khajnaPayYears = $this->__yearly_khajna_pay_report_filter($request)->select('khajna_date_year as year')->groupBy('khajna_date_year')->get();
        
        /*print block*/

        ?>
        <style>
            @page {
            margin-left: 2cm;
                        margin-right: 2cm;
                        margin-top: 2cm;
                        margin-bottom: 2cm;
                    }

                    table {
            page-break-inside: auto
                    }

                    tr {
            page-break-inside: avoid;
                        page-break-after: auto
                    }

                    .tbl {
            border-collapse: collapse !important;
                        width: 100%;
                    }

                    .tbl2 {
            border-collapse: collapse !important;
                        width: 50%;
                    }

                    table.tbl thead tr th, table.tbl2 thead tr th {
            border: 1px solid #000;
                        text-align: center !important;
                        font-weight: normal;
                    }

                    table thead tr th,table tbody tr td, table tfoot tr td {
            /*padding-left: 10px !important;*/
            border: 1px solid #ccc;
                        text-align: center !important;
                        font-weight: normal;
                        vertical-align: middle;
                    }

                    table.tbl thead tr th, table.tbl2 thead tr th {
            text-align: center !important;
                    }

                    table.tbl td a {
            text-decoration: none;
                        color: #000000;
                        background: none;
                    }

        </style>

        <table>
            <thead>
                <tr>
                    <th>বাৎসরিক খাজনা পরিশোধের তথ্য | Dhaka WASA</th>
                </tr>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <th>ID</th>
                    <th>খাজনা পরিশোধের সন</th>
                    <th>স্থাপনার নাম</th>
                    <th>জোন</th>
                    <th>মৌজা</th>
                    <th>দাগ নং</th>
                    <th>খতিয়ান নং</th>
                    <th>জমির পরিমান (একর)</th>
                    <th>মোট খাজনার পরিমাণ</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if(count($khajnaPayYears) > 0){
                        $i = 1; $grandTotal = 0;
                        foreach($khajnaPayYears as $year)
                        {
                            $subTotal= 0;
                            $khajnaInfoLandId = KhajnaInfo::where('khajna_date_year', $year->year)->pluck('land_id');

                            $landQuery = Land::whereIn('id', $khajnaInfoLandId);
                            $lands = $landQuery->get();

                            if(count($lands) > 0){  ?>
                                <tr>
                                    <td><?php echo $i++;  ?></td>
                                    <td><?php echo $year->year;  ?></td>
                                    <td>
                                    <?php
                                        foreach($lands as $land){
                                         echo $land->title;  ?> <hr>
                                        <?php } ?>
                                        <b>-</b>
                                    </td>
                                    <td>
                                    <?php
                                        foreach($lands as $land){
                                         echo $land->zone->title;  ?> <hr>
                                        <?php } ?>
                                        <b>-</b>
                                    </td>
                                    <td>
                                        <?php
                                        foreach($lands as $land){
                                         echo $land->area->title;  ?> <hr>
                                        <?php } ?>
                                        <b>-</b>
                                    </td>
                                    <td>
                                        <?php
                                        foreach($lands as $land){
                                         echo $land->dag_no;  ?> <hr>
                                        <?php } ?>
                                        <b>-</b>
                                    </td>
                                    <td>
                                        <?php
                                        foreach($lands as $land){
                                        echo $land->khotian;  ?> <hr>
                                        <?php } ?>
                                        <b>-</b>
                                    </td>
                                    <td>
                                        <?php
                                        foreach($lands as $land){
                                         echo $land->quantity;  ?> <hr>
                                        <?php } ?>
                                        <span><b>পরিশোধিত মোট খাজনার পরিমাণ</b></span>
                                    </td>
                                    
                                    <td>
                                        <?php
                                        foreach($lands as $land){
                                            // $totalYearlyKhajna = KhajnaInfo::where('khajna_date_year', $year->year)
                                            //     ->where('land_id', $land->id)->sum('bokeya');
                                            $totalYearlyKhajnaArray = KhajnaInfo::where('khajna_date_year', $year->year)
                                                            ->where('land_id', $land->id)->get();
                                            $totalYearlyKhajna =0;
                                            foreach ($totalYearlyKhajnaArray as $key => $khajna) {
                                                $totalYearlyKhajna += bn2en($khajna->bokeya);
                                            }

                                        echo en2bn($totalYearlyKhajna);
                                        $subTotal += bn2en($totalYearlyKhajna); ?>
                                        <hr>
                                        <?php } ?>

                                        <b><?php echo en2bn($subTotal); ?></b>
                                        <?php $grandTotal += $subTotal; ?>
                                    </td>
                                </tr>
                     <?php  } 
                        } ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-right"> <b>মোট : </b></td>
                            <td><b><?php echo en2bn($grandTotal);  ?></b></td>
                        </tr>
              <?php } ?>
                
            </tbody>
        </table>

        <!--print block-->

        <?php
            $html = ob_get_contents();

            $path = public_path() . '/excel/';

            ob_clean();
            foreach (glob($path."*.xls") as $filename)
            { 
                @unlink($filename);
            }
            //html to xls convert
            $name=time();
            $name= 'yearly_khajna_pay'. '_' . "$name".".xls";
            $create_new_excel = fopen($path . $name, 'w');
            $is_created = fwrite($create_new_excel,$html);
            echo "$html";

            header('Content-Type: ".xls"');
            header('Content-Disposition: attachment; filename="'.$name.'"');
            header("Content-Transfer-Encoding: binary");
            header('Expires: 0');
            header('Pragma: no-cache');
            header("Content-Length: ".strlen($html));
            // exit($is_created);
            exit($html);
   
    }
    //Second report ends.......................

    //Third report starts............................
    public function getKhajnaBokeyaReport(Request $request)
    {
        $searchedData = 0;
        if($request->has('land_id')){
            $searchedData = 1;
        }

        $lands        = $this->__khajna_bokeya_filter($request)->get();
        $landArr      = Land::all()->pluck('title', 'id');
        return view('Land::report.bokeya-khajna-report', compact('lands','landArr', 'searchedData'));
    }

    private function __khajna_bokeya_filter($request)
    {
        $query = array();
        if($request->land_id != null){
            $query['id'] = $request->land_id;
        }
        
        $landQuery = Land::where($query);
        $lands = $landQuery;
        return $lands;
    }

    public function khajnaBokeyaReportPdfList(Request $request)
    {
        $title              = "স্থাপনা হিসেবে খাজনা বকেয়ার তথ্য - " . date('Y-m-d H:i:s') . '.pdf';
        $data['lands']      = $this->__filter($request)->get();
        ini_set('memory_limit', '3072M');
        set_time_limit(300);
        $html               = view("Land::report.bokeya_khajna_pdf", $data);

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
        $mpdf->SetHtmlHeader(view('Land::report.bokeya_khajna_pdf_header',$data));
        $mpdf->WriteHTML($html);
        $mpdf->Output($title, 'I');
        exit;
    }

    public function khajnaBokeyaReportExport(Request $request){
        ob_start();

        $lands        = $this->__khajna_bokeya_filter($request)->get();

       /*print block*/

        ?>
        <style>
            @page {
            margin-left: 2cm;
                        margin-right: 2cm;
                        margin-top: 2cm;
                        margin-bottom: 2cm;
                    }

                    table {
            page-break-inside: auto
                    }

                    tr {
            page-break-inside: avoid;
                        page-break-after: auto
                    }

                    .tbl {
            border-collapse: collapse !important;
                        width: 100%;
                    }

                    .tbl2 {
            border-collapse: collapse !important;
                        width: 50%;
                    }

                    table.tbl thead tr th, table.tbl2 thead tr th {
            border: 1px solid #808080;
                        text-align: center !important;
                        font-weight: normal;
                    }

                    table thead tr th,table tbody tr td, table tfoot tr td {
            /*padding-left: 10px !important;*/
            border: 1px solid #808080;
                        text-align: center !important;
                        font-weight: normal;
                        vertical-align: middle;
                    }

                    table.tbl thead tr th, table.tbl2 thead tr th {
            text-align: center !important;
                    }

                    table.tbl td a {
            text-decoration: none;
                        color: #808080;
                        background: none;
                    }

        </style>

        <table>
            <thead>
                <tr>
                    <td></td>
                    <th>স্থাপনা হিসেবে খাজনা বকেয়ার তথ্য | Dhaka WASA </th>
                </tr>
                <tr>
                    <th></th>
                </tr>
                <tr>
                    <th>ID</th>
                    <th>স্থাপনার নাম</th>
                    <th>জোন</th>
                    <th>মৌজা</th>
                    <th>দাগ নং</th>
                    <th>খতিয়ান নং</th>
                    <th>জমির পরিমান (একর)</th>
                    <th>খাজনাকৃত জমির পরিমান (একর)</th>
                    <th>পরিশোধিত খাজনার পরিমাণ</th>
                    <th>মোট বকেয়া</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(count($lands) > 0){
                    $i = 1; $totalLand = 0; $totalKhajnaLand = 0; $totalKhajnaPaid = 0; $grandTotalBokeya = 0;
                    foreach($lands as $land){
                        // $khajnaPaid = KhajnaInfo::where('land_id', $land->id)->sum('bokeya');

                        // //Bokeya calculation.........
                        // $totalBokeya = KhajnaOfficeInfo::where('land_id', $land->id)->sum('total_bokeya');
                        // $bokeya = ($totalBokeya - $khajnaPaid);

                        //Bokeya calculation.........
                        $bokeyaArray = KhajnaOfficeInfo::where('land_id', $land->id)->get();
                        $paidArray = KhajnaInfo::where('land_id', $land->id)->get();
                        $totalBokeya =0;
                        $totalPaid =0;
                        foreach ($bokeyaArray as $key => $bokeya) {
                            $totalBokeya += bn2en($bokeya->total_bokeya);
                        }
                        foreach ($paidArray as $key => $paid) {
                            $totalPaid += bn2en($paid->bokeya);
                        }
                        $bokeya = ($totalBokeya - $totalPaid);

                        if(count($totalPaid) > 0){  ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $land->title; ?></td>
                                <td><?php echo $land->zone->title; ?></td>
                                <td><?php echo $land->area->title; ?></td>
                                <td><?php echo $land->dag_no; ?></td>
                                <td><?php echo $land->khotian; ?></td>
                                <td>
                                    <?php echo $land->quantity; ?>
                                    <?php $totalLand += $land->quantity; ?>
                                </td>
                                <td>
                                    <?php echo $land->khajna_land; ?>
                                    <?php $totalKhajnaLand += $land->khajna_land; ?>
                                </td>
                                
                                
                                <td>
                                    <?php echo en2bn($totalPaid); ?>
                                    <?php $totalKhajnaPaid += $totalPaid; ?>
                                </td>
                                <td>                                      
                                    <?php echo en2bn($bokeya); ?>
                                    <?php $grandTotalBokeya += $bokeya; ?>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td colspan="2" style="text-align:center"> <b>মোট : </b></td>
                        <td><b><?php echo en2bn($totalLand); ?></b></td>
                        <td><b><?php echo en2bn($totalKhajnaLand); ?></b></td>
                        <td><b><?php echo en2bn($totalKhajnaPaid); ?></b></td>
                        <td><b><?php echo en2bn($grandTotalBokeya); ?></b></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!--print block-->

        <?php
            $html = ob_get_contents();

            $path = public_path() . '/excel/';

            ob_clean();
            foreach (glob($path."*.xls") as $filename)
            { 
                @unlink($filename);
            }
            //html to xls convert
            $name=time();
            $name= 'bokeya_khajna'. '_' . "$name".".xls";
            $create_new_excel = fopen($path . $name, 'w');
            $is_created = fwrite($create_new_excel,$html);
            echo "$html";

            header('Content-Type: ".xls"');
            header('Content-Disposition: attachment; filename="'.$name.'"');
            header("Content-Transfer-Encoding: binary");
            header('Expires: 0');
            header('Pragma: no-cache');
            header("Content-Length: ".strlen($html));
            exit($html);
    }

    //Third report ends.................

    //Fifth report starts...............

    public function getZoneKhajnaReport(Request $request){
        $searchedData = 0;
        if($request->has('zone_id')){
            $searchedData = 1;
        }

        $status = 1;
        if($request->has('status') && $request->status == 0){
            $status = 0;
        }

        $zones = $this->__zone_khajna_pay_report_filter($request)->paginate(10);
        $zoneArr = Zone::pluck('title', 'id');

        return view('Land::report.zone-khajna-pay-report', compact('zones','searchedData','zoneArr','status'));
    }

    private function __zone_khajna_pay_report_filter($request)
    {
        $query = array();        
        if(isset($request->zone_id) && $request->zone_id != null){
            $query['id'] = $request->zone_id;
        }

        $zoneQuery = Zone::where($query);
        $zones = $zoneQuery;
        return $zones;
    }

    public function zoneKhajnaReportPdfList(Request $request)
    {
        $title              = "জোন হিসেবে খাজনার তথ্য - " . date('Y-m-d H:i:s') . '.pdf';
        $data['zones']      = $this->__zone_khajna_pay_report_filter($request)->get();
        ini_set('memory_limit', '3072M');
        set_time_limit(300);
        $html               = view("Land::report.zone-khajna-report-pdf", $data);

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
        $mpdf->SetHtmlHeader(view('Land::report.zone-khajna-pdf-header',$data));
        $mpdf->WriteHTML($html);
        $mpdf->Output($title, 'I');
        exit;
    }

    public function zoneKhajnaReportExport(Request $request){
       ob_start();

       $zones = $this->__zone_khajna_pay_report_filter($request)->get();

       /*print block*/

       ?>
       <style>
           @page {
           margin-left: 2cm;
                       margin-right: 2cm;
                       margin-top: 2cm;
                       margin-bottom: 2cm;
                   }

                   table {
           page-break-inside: auto
                   }

                   tr {
           page-break-inside: avoid;
                       page-break-after: auto
                   }

                   .tbl {
           border-collapse: collapse !important;
                       width: 100%;
                   }

                   .tbl2 {
           border-collapse: collapse !important;
                       width: 50%;
                   }

                   table.tbl thead tr th, table.tbl2 thead tr th {
           border: 1px solid #000;
                       text-align: center !important;
                       font-weight: normal;
                   }

                   table thead tr th,table tbody tr td, table tfoot tr td {
           /*padding-left: 10px !important;*/
           border: 1px solid #ccc;
                       text-align: center !important;
                       font-weight: normal;
                       vertical-align: middle;
                   }

                   table.tbl thead tr th, table.tbl2 thead tr th {
           text-align: center !important;
                   }

                   table.tbl td a {
           text-decoration: none;
                       color: #000000;
                       background: none;
                   }

       </style>

        <table>
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th><b>জোন হিসেবে খাজনার তথ্য | Dhaka WASA</b></th>
                </tr>
                <tr>
                    <th></th>
                </tr>
                <tr>
                    <th>ID</th>
                    <th>জোন</th>
                    <th>স্থাপনার নাম</th>
                    <th>মৌজা</th>
                    <th>দাগ নং</th>
                    <th>খতিয়ান নং</th>
                    <th>জমির পরিমান (একর)</th>
                    <th>খাজনাকৃত জমির পরিমান (একর)</th>
                    <th>মোট খাজনার পরিমাণ</th>
                    <th>মোট বকেয়া</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(count($zones) > 0){
                    $i = 1; $grandTotalPaid = 0; $grandTotalBokeya = 0;
                    foreach($zones as $zone){
                        $subTotalPaid= 0;
                        $subTotalBokeya= 0;
                        $lands = Land::where('zone_id', $zone->id)->get();
                        if(count($lands) > 0){  ?>
                            <tr style="border: 1px solid black;">
                                <td><?php $i++; ?></td>
                                <td><?php $zone->title or ''; ?></td>
                                <td>
                                    <table>
                                    <?php foreach($lands as $land){ ?>
                                            <tr>
                                                <td style="white-space: nowrap;"><?php echo $land->title; ?></td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                </td>
                                <td>
                                    <table>
                                        <?php foreach($lands as $land){ ?>
                                            <tr>
                                            <?php if (isset($land->area)){ ?>
                                                    <td style="white-space: nowrap;">
                                                        <?php echo $land->area->title; ?>
                                                    </td>
                                                <?php }else{ ?>
                                                    <td>-</td> 
                                                <?php } ?>
                                                
                                            </tr>
                                        <?php } ?>
                                    </table>
                                </td>
                                <td>
                                    <table>
                                        <?php foreach($lands as $land){ ?>
                                            <tr>
                                                <td style="white-space: nowrap;"> <?php echo $land->dag_no; ?> </td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                </td>
                                <td>
                                    <table>
                                        <?php foreach($lands as $land){ ?>
                                            <tr>
                                                <td style="white-space: nowrap;"><?php echo $land->khotian; ?></td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                </td>
                                <td>
                                    <table>
                                        <?php foreach($lands as $land){ ?>
                                            <tr>
                                                <td style="white-space: nowrap;"><?php echo $land->quantity; ?></td>
                                                <?php $subTotalQuantity += bn2en($land->quantity); ?>
                                            </tr>
                                        <?php } ?>
                                        <?php $grandTotalQuantity += $subTotalQuantity; ?>
                                    </table>
                                </td>
                                <td>
                                    <table>
                                        <?php foreach($lands as $land){ ?>
                                            <tr>
                                                <td style="white-space: nowrap;"><?php echo $land->khajna_land; ?></td>
                                                <?php $subTotalLand += bn2en($land->khajna_land); ?>
                                            </tr>
                                        <?php } ?>
                                        <?php $grandTotalLand += $subTotalLand; ?>
                                    </table>
                                </td>
                                
                                <td>
                                    <table>
                                        <?php foreach($lands as $land){ ?>
                                            <?php
                                                $totalKhajnaPaid = KhajnaInfo::where('land_id', $land->id)->sum('bokeya');
                                            ?>
                                            <tr>
                                                <td style="white-space: nowrap;"><?php echo $totalKhajnaPaid; ?></td>
                                                <?php $subTotalPaid += $totalKhajnaPaid; ?>
                                            </tr>
                                        <?php } ?>
                                        <?php $grandTotalPaid += $subTotalPaid; ?>
                                    </table>
                                </td>
                                <td>
                                    <table>
                                        <?php foreach($lands as $land){ ?>
                                            <?php
                                                //Bokeya calculation.........
                                                $totalBokeya = KhajnaOfficeInfo::where('land_id', $land->id)->sum('total_bokeya');
                                                $totalPaid = KhajnaInfo::where('land_id', $land->id)->sum('bokeya');
                                                $bokeya = ($totalBokeya - $totalPaid);
                                            ?>
                                            <tr>
                                                <td style="white-space: nowrap;"><?php echo $bokeya; ?></td>
                                                <?php $subTotalBokeya += $bokeya; ?>
                                            </tr>
                                        <?php } ?>
                                        <?php $grandTotalBokeya += $subTotalBokeya; ?>
                                    </table>
                                </td>
                            </tr>
                        <?php } ?> 
                    <?php } ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td colspan="2" class="text-right"> <b>মোট : </b></td>
                        <td><b><?php echo en2bn($grandTotalQuantity); ?> (একর)</b></td>
                        <td><b><?php echo en2bn($grandTotalLand); ?> (একর)</b></td>
                        <td><b><?php echo en2bn($grandTotalPaid); ?></b></td>
                        <td><b><?php echo en2bn($grandTotalBokeya); ?></b></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!--print block-->

        <?php
            $html = ob_get_contents();

            $path = public_path() . '/excel/';

            ob_clean();
            foreach (glob($path."*.xls") as $filename)
            { 
                @unlink($filename);
            }
            //html to xls convert
            $name=time();
            $name= 'zone_khajna'. '_' . "$name".".xls";
            $create_new_excel = fopen($path . $name, 'w');
            $is_created = fwrite($create_new_excel,$html);
            echo "$html";

            header('Content-Type: ".xls"');
            header('Content-Disposition: attachment; filename="'.$name.'"');
            header("Content-Transfer-Encoding: binary");
            header('Expires: 0');
            header('Pragma: no-cache');
            header("Content-Length: ".strlen($html));
            exit($html);
    }
    //Fifth report ends...............


    //Sixth report starts...............

    public function getNamjariReportByKhotian(Request $request)
    {
        // dd($request->all());
        $searchedData = 0;
        if($request->has('namjari_khotian_no')){
            $searchedData = 1;
        }

        $namjaries = $this->__khotian_namjari_report_filter($request)->paginate(10);
        $namjari  = Namjari::where('namjari_khotian_no', $request->namjari_khotian_no)->first();
        $khotians = Namjari::pluck('namjari_khotian_no', 'namjari_khotian_no');
        $areas      = Area::pluck('title', 'id');
        
        return view('Land::report.khotian_namjari-report', compact('namjaries','searchedData','khotians', 'namjari', 'areas'));
    }

    public function exportNamjariReportByKhotianPdf(Request $request)
    {
        $data['namjari']  = Namjari::where('namjari_khotian_no', $request->namjari_khotian_no)->first();
        $title              = "খতিয়ান নং অনুযায়ী নামজারি তথ্য - " . date('Y-m-d H:i:s') . '.pdf';
        $data['namjaries']      = $this->__khotian_namjari_report_filter($request)->get();
        ini_set('memory_limit', '3072M');
        set_time_limit(300);
        $html               = view("Land::report.khotian_namjari-report-pdf", $data);

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
        $mpdf->SetHtmlHeader(view('Land::report.khotian_namjari-pdf-header',$data));
        $mpdf->WriteHTML($html);
        $mpdf->Output($title, 'I');
        exit;
    }

    private function __khotian_namjari_report_filter($request)
    {
        $query = array();
        if(isset($request->namjari_khotian_no) && $request->namjari_khotian_no != null){
            $query['namjari_khotian_no'] = $request->namjari_khotian_no;
        }

        if(isset($request->area) && $request->area != null){
            $query['area_id'] = $request->area;
        }

        $namjariQuery = DB::table('namjaris')->where('namjari_khotian_no', $request->namjari_khotian_no)
                        ->where('area_id', $request->area)
                        ->join('lands', 'lands.id', 'namjaris.land_id');
        // $namjariQuery = Namjari::where($query)->with('land')->get();
        return $namjariQuery;
    }
    //Sixth report ends...............
}
