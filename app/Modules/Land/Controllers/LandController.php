<?php

namespace App\Modules\Land\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Land\Models\Area;
use App\Modules\Land\Models\Land;
use App\Modules\Land\Models\Zila;
use App\Modules\Land\Models\Thana;
use App\Modules\Land\Models\LandSource;
use App\Modules\Land\Models\Property;
use App\Modules\Land\Models\Zone;
use Excel;
use File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Mpdf\Mpdf;

class LandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $areas      = Area::pluck('title', 'id');
        $zones      = Zone::pluck('title', 'id');
        $zilas      = Zila::pluck('title', 'id');
        $sources    = LandSource::pluck('title', 'id');
        $lands      = $this->__filter($request)->paginate(10);

        return view('Land::land.index', compact('areas', 'zones', 'sources', 'lands', 'zilas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $zones      = Zone::pluck('title', 'id');
        $zilas      = Zila::pluck('title', 'id');
        $areas      = Area::where('zone_id', '1')->pluck('title', 'id');
        $sources    = LandSource::pluck('title', 'id');

        return view('Land::land.create', compact('zones', 'areas', 'sources', 'zilas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valid = $this->validate($request, [
            'title'             => 'required',
            'zila_id'           => 'required',
            'thana_id'           => 'required',
            'zone_id'           => 'required',
            'area_id'           => 'required',
            'land_source_id'    => 'required',
            'address'           => 'required',
            'dag_no'            => 'required',
            'khotian'           => 'required',
            // 'quantity'          => 'required',
            // 'khajna_land'       => 'required',
            // 'ownership_details' => 'required',
            'current_status'    => 'required',
            // 'khajna'            => 'required',
            // 'namjari'           => 'required',
            // 'coordinates' => 'required',
            // 'comment' => 'required',
            // 'document' => 'file|mimes:jpeg,bmp,png,gif,pdf,doc|max:2048',
        ]);

        $data = [
            'title'             => $request->title,
            'zone_id'           => $request->zone_id,
            'zila_id'           => $request->zila_id,
            'thana_id'           => $request->thana_id,
            'area_id'           => $request->area_id,
            'land_source_id'    => $request->land_source_id,
            'address'           => $request->address,
            'dag_no'            => $request->dag_no,
            'khotian'           => $request->khotian,
            'quantity'          => $request->quantity,
            'khajna_land'       => $request->khajna_land,
            'ownership_details' => $request->ownership_details,
            'current_status'    => $request->current_status,
            // 'khajna'            => $request->khajna,
            // 'namjari'           => $request->namjari,
            'coordinates'       => $request->coordinates,
            'comment'           => $request->comment,
            'doc_name_1'        => $request->doc_name_1,
            'doc_name_2'        => $request->doc_name_2,
            'doc_name_3'        => $request->doc_name_3,
            'doc_name_4'        => $request->doc_name_4,
            'doc_name_5'        => $request->doc_name_5,
            'status'            => 1
        ];

        try {
            if ($request->hasFile('doc_1')) {
                $fileName = $request->land_source_id .'-1'. time() . '.' . $request->file('doc_1')->getClientOriginalExtension();
                $path = 'uploads/land-document/';
                Storage::disk('public-root')->put($path . $fileName, file_get_contents($request->file('doc_1')));
                $data['doc_1'] = $path . $fileName;
            }
            if ($request->hasFile('doc_2')) {
                $fileName = $request->land_source_id .'-2'. time() . '.' . $request->file('doc_2')->getClientOriginalExtension();
                $path = 'uploads/land-document/';
                Storage::disk('public-root')->put($path . $fileName, file_get_contents($request->file('doc_2')));
                $data['doc_2'] = $path . $fileName;
            }
            if ($request->hasFile('doc_3')) {
                $fileName = $request->land_source_id .'-3'. time() . '.' . $request->file('doc_3')->getClientOriginalExtension();
                $path = 'uploads/land-document/';
                Storage::disk('public-root')->put($path . $fileName, file_get_contents($request->file('doc_3')));
                $data['doc_3'] = $path . $fileName;
            }
            if ($request->hasFile('doc_4')) {
                $fileName = $request->land_source_id .'-4'. time() . '.' . $request->file('doc_4')->getClientOriginalExtension();
                $path = 'uploads/land-document/';
                Storage::disk('public-root')->put($path . $fileName, file_get_contents($request->file('doc_4')));
                $data['doc_4'] = $path . $fileName;
            }
            if ($request->hasFile('doc_5')) {
                $fileName = $request->land_source_id .'-5'. time() . '.' . $request->file('doc_5')->getClientOriginalExtension();
                $path = 'uploads/land-document/';
                Storage::disk('public-root')->put($path . $fileName, file_get_contents($request->file('doc_5')));
                $data['doc_5'] = $path . $fileName;
            }
// dd($data);
            Land::create($data);
            return redirect('land/land/')->with('success', 'Land added successfully');
        } catch (\Exception $ex) {
            dd($ex);
            Log::error($ex);
            return redirect()->back()->withErrors("Something went wrong. Please try again.");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Modules\Land\Models\Land $land
     * @return \Illuminate\Http\Response
     */
    public function show(Land $land)
    {
        $fileTypes      = ['' => 'File Type'] + DB::table('file_types')->whereSelectable(3)->orderBy('title', 'ASC')->pluck('title', 'id')->all();
        $properties     = Property::where('land_id', $land->id)->get();
        return view('Land::land.show', compact('land', 'fileTypes', 'properties'));

    }

    public function single_pdf($id)
    {
        $land               = Land::findOrFail($id);

        ini_set('memory_limit', '3072M');
        set_time_limit(300);

        $html               = view("Land::land.single_export_pdf", compact('land'));

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

        $title              = "Land Details - " . date('Y-m-d H:i:s') . '.pdf';
        $mpdf->SetProtection(array('print'));
        $mpdf->SetTitle($title);
        $mpdf->SetAuthor("SSL Wireless");
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHtmlHeader(view('Land::land.pdf_header'));
        $mpdf->WriteHTML($html);
        $mpdf->Output($title, 'I');
        exit;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Modules\Land\Models\Land $land
     * @return \Illuminate\Http\Response
     */
    public function edit(Land $land)
    {
        $zones      = Zone::pluck('title', 'id');
        $zilas      = Zila::pluck('title', 'id');
        $thanas      = Thana::pluck('title', 'id');
        $areas      = Area::pluck('title', 'id');
        $sources    = LandSource::pluck('title', 'id');

        return view('Land::land.edit', compact('zones', 'areas', 'sources', 'land', 'thanas', 'zilas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Modules\Land\Models\Land $land
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'title'             => 'required',
            'zila_id'           => 'required',
            'thana_id'           => 'required',
            'zone_id'           => 'required',
            'area_id'           => 'required',
            'land_source_id'    => 'required',
            'address'           => 'required',
            'dag_no'            => 'required',
            'khotian'           => 'required',
            // 'quantity'          => 'numeric',
            // 'khajna_land'       => 'numeric',
            // 'ownership_details' => 'required',
            'current_status'    => 'required',
            // 'khajna'            => 'required',
            // 'namjari'           => 'required',
        ]);

        $data = [
            'title'             => $request->title,
            'zila_id'           => $request->zila_id,
            'thana_id'           => $request->thana_id,
            'zone_id'           => $request->zone_id,
            'area_id'           => $request->area_id,
            'land_source_id'    => $request->land_source_id,
            'address'           => $request->address,
            'dag_no'            => $request->dag_no,
            'khotian'           => $request->khotian,
            'quantity'          => $request->quantity,
            'khajna_land'       => $request->khajna_land,
            'ownership_details' => $request->ownership_details,
            'current_status'    => $request->current_status,
            // 'khajna'            => $request->khajna,
            // 'namjari'           => $request->namjari,
            'coordinates'       => $request->coordinates,
            'comment'           => $request->comment,
            'status'            => $request->status,
            'doc_name_1'        => $request->doc_name_1,
            'doc_name_2'        => $request->doc_name_2,
            'doc_name_3'        => $request->doc_name_3,
            'doc_name_4'        => $request->doc_name_4,
            'doc_name_5'        => $request->doc_name_5,
        ];

        $land = Land::where('id', $id)->first();
        try {
            if ($request->hasFile('doc_1') && isset($request->doc_1)) {
                // Remove previous image.
                $image = public_path($land->doc_1); // get previous image from folder
                if (File::exists($image)) { // unlink or remove previous image from folder
                    // unlink($image);
                    Storage::delete($image);
                }

                $fileName = '1-'. time() . '.' . $request->file('doc_1')->getClientOriginalExtension();
                $path = 'uploads/land-document/';
                Storage::disk('public-root')->put($path . $fileName, file_get_contents($request->file('doc_1')));
                $data['doc_1'] = $path . $fileName;
            }
            if ($request->hasFile('doc_2') && isset($request->doc_2)) {
                // Remove previous image.
                $image = public_path($land->doc_2); // get previous image from folder
                if (File::exists($image)) { // unlink or remove previous image from folder
                    // unlink($image);
                    Storage::delete($image);
                }

                $fileName = '2-'. time() . '.' . $request->file('doc_2')->getClientOriginalExtension();
                $path = 'uploads/land-document/';
                Storage::disk('public-root')->put($path . $fileName, file_get_contents($request->file('doc_2')));
                $data['doc_2'] = $path . $fileName;
            }
            if ($request->hasFile('doc_3') && isset($request->doc_3)) {
                // Remove previous image.
                $image = public_path($land->doc_3); // get previous image from folder
                if (File::exists($image)) { // unlink or remove previous image from folder
                    // unlink($image);
                    Storage::delete($image);
                }

                $fileName = '3-'. time() . '.' . $request->file('doc_3')->getClientOriginalExtension();
                $path = 'uploads/land-document/';
                Storage::disk('public-root')->put($path . $fileName, file_get_contents($request->file('doc_3')));
                $data['doc_3'] = $path . $fileName;
            }
            if ($request->hasFile('doc_4') && isset($request->doc_4)) {
                // Remove previous image.
                $image = public_path($land->doc_4); // get previous image from folder
                if (File::exists($image)) { // unlink or remove previous image from folder
                    // unlink($image);
                    Storage::delete($image);
                }

                $fileName = '4-'. time() . '.' . $request->file('doc_4')->getClientOriginalExtension();
                $path = 'uploads/land-document/';
                Storage::disk('public-root')->put($path . $fileName, file_get_contents($request->file('doc_4')));
                $data['doc_4'] = $path . $fileName;
            }
            if ($request->hasFile('doc_5') && isset($request->doc_5)) {
                // Remove previous image.
                $image = public_path($land->doc_5); // get previous image from folder
                if (File::exists($image)) { // unlink or remove previous image from folder
                    // unlink($image);
                    Storage::delete($image);
                }

                $fileName = '5-'. time() . '.' . $request->file('doc_5')->getClientOriginalExtension();
                $path = 'uploads/land-document/';
                Storage::disk('public-root')->put($path . $fileName, file_get_contents($request->file('doc_5')));
                $data['doc_5'] = $path . $fileName;
            }

            Land::where('id', $id)->update($data);
            return redirect('land/land/')->with('success', 'Land updated successfully');
        } catch (\Exception $ex) {
            Log::error($ex);
            return redirect()->back()->withErrors("Something went wrong. Please try again.");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Modules\Land\Models\Land $land
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Land $land)
    {
        if($land) {
            $land->delete();
            return redirect()->back()->with('success', 'Land Successfully Deleted');
        } else {
            return redirect()->back()->withErrors('No Data Found');
        }

    }

    public function pdf(Request $request)
    {
        $title              = "Land List Report - " . date('Y-m-d H:i:s') . '.pdf';
        $data['lands']      = $this->__filter($request)->get();
        if(isset($request->zone_id))
        {
            $zone           = Zone::where('id',$request->zone_id)->select('title')->first();
            $data['zone']   =  $zone;
            $title          = $zone->title." - Land List Report - " . date('Y-m-d H:i:s') . '.pdf';

        }
        ini_set('memory_limit', '3072M');
        set_time_limit(300);
        $html               = view("Land::land.export_pdf", $data);

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
        $mpdf->SetHtmlHeader(view('Land::land.pdf_header',$data));
        $mpdf->SetHtmlFooter(view('Land::land.pdf_footer',$data));
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
                'area'      => $row->area->title,
                'source'    => $row->source->title,
            ];
            $data[]         = array_merge($dataArray, $row->only([
                'title', 'address', 'khotian', 'quantity', 'ownership_details', 'current_status', 'khajna', 'namjari', 'comment',
            ]));
        }

        Excel::create('Land List', function ($excel) use ($data) {
            $excel->sheet('Land List', function ($sheet) use ($data) {
                $sheet->setOrientation('landscape');
                $sheet->fromArray($data);
            });
        })->export('xls');

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
        if ($request->source_id != null) {
            $query['land_source_id']    = $request->source_id;
        }
        $landQuery                      = Land::where($query);
        ($request->title ? $landQuery->where('title', 'like', '%' . $request->title . '%') : null);
        ($request->ownership_details ? $landQuery->where('ownership_details', 'like', '%' . $request->ownership_details . '%') : null);
        (($request->filled('quantity') and $request->quantity_sign) ? $landQuery->where('quantity', "$request->quantity_sign", $request->quantity) : null);
        ($request->current_status ? $landQuery->where('current_status', $request->current_status) : null);
        ($request->khajna ? $landQuery->where('khajna', $request->khajna) : null);
        ($request->namjari ? $landQuery->where('namjari', $request->namjari) : null);
        ($request->comment ? $landQuery->where('comment', 'like', '%' . $request->comment . '%') : null);
        ($request->filled('status') ? $landQuery->where('status', $request->status) : null);

        if ($request->address != null) {
            $landQuery->where('address', 'like', "%{$request->address}%");
        }
        if ($request->khotian != null) {
            $landQuery->where('khotian', 'like', "%{$request->khotian}%");
        }
        if ($request->orderby != null) {
            $landQuery->orderBy('title', $request->orderby);
        }else{
            $landQuery->orderBy('created_at', 'DESC');
        }
        $lands                          = $landQuery->with(['zone', 'area', 'source']);
        return $lands;
    }
}
