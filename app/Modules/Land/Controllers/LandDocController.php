<?php

namespace App\Modules\Land\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Land\Models\LandDoc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class LandDocController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'document'      => 'file|mimes:jpeg,bmp,png,gif,pdf,doc|max:5120',
            'file_title'    => 'required',
        ]);

        if ($request->hasFile('document')) {

            $fileName   = $request->land_id .'-'. $request->file_type_id .'-'. time() . '.' . $request->file('document')->getClientOriginalExtension();
            $path       = 'uploads/files/';
            Storage::disk('public-root')->put($path . $fileName, file_get_contents($request->file('document')));

            LandDoc::create([
                'land_id'       => $request->land_id,
                'file_type_id'  => $request->file_type_id,
                'file_title'    => $request->file_title,
                'file_path'     => $path . $fileName,
            ]);
        }

        return redirect()->back()->with('success', "File has been uploaded!");
    }
    public function update(Request $request,$id)
    {
        $this->validate($request,[
            'document'      => 'file|mimes:jpeg,bmp,png,gif,pdf,doc|max:5120',
            'file_title'    => 'required',
        ]);
        $landDoc                =  LandDoc::findOrFail($id);
        $landDoc->file_title    = $request->file_title;
        $landDoc->file_type_id  = $request->file_type_id;

        if ($request->hasFile('document')) {
            $oldFileExists      = Storage::disk('public-root')->exists($landDoc->file_path);
            if($oldFileExists){
                Storage::disk('public-root')->delete($landDoc->file_path);
            }
            $fileName = $landDoc->land_id .'-'. $request->file_type_id .'-'. time() . '.' . $request->file('document')->getClientOriginalExtension();
            $path = 'uploads/files/';
            Storage::disk('public-root')->put($path . $fileName, file_get_contents($request->file('document')));
            $landDoc->file_path = $path . $fileName;
        }
        $landDoc->save();
        return redirect()->back()->with('success', "Document successfully updated!");
    }
    public function delete($id)
    {
        $landDoc                = LandDoc::findOrFail($id);
        if(Storage::disk('public-root')->exists($landDoc->file_path)){
            Storage::disk('public-root')->delete($landDoc->file_path);
        }
        $landDoc->delete();
        return redirect()->back()->with('success', "Document successfully deleted");
    }
}
