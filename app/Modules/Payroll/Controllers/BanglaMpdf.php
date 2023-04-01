<?php
/**
 * Created by PhpStorm.
 * User: anowar
 * Date: 2/1/18
 * Time: 12:34 PM
 */

namespace App\Modules\Payroll\Controllers;


use Mpdf\Mpdf;

class BanglaMpdf extends Mpdf
{
    public function __construct(array $config = [])
    {

        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults(); // extendable default Configs
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults(); // extendable default Fonts
        $fontData = $defaultFontConfig['fontdata'];

        $configBanla = [
            'tempDir'       => storage_path(),
            'fontDir' => array_merge($fontDirs, [
                public_path('fonts'), // to find /public/fonts/SolaimanLipi.ttf
            ]),
            'fontdata' => $fontData + [
                    'solaimanlipi' => [
                        'R' => "SolaimanLipi.ttf",
                        'useOTL' => 0xFF,
                    ],
                    'nikosh' => [
                        'R' => "Nikosh.ttf",
                        'useOTL' => 0xFF,
                    ],
                    //... you can add more custom font here
                ],
            'default_font' => 'solaimanlipi', // default font is not mandatory, you can use in css font
        ];
        $config = array_merge($config, $configBanla);
        parent::__construct($config);
    }
}