<?php

namespace App\Modules\EmployeeProfile\Controllers;

use App\EmployeeProfile\Model\EmployeeDocument;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
//use File;
use Auth;
class EmployeeDocumentController extends Controller
{

    public function uploadPhoto(Request $request) {
        if(!Auth::user()->can('manage_photo_section')){
            abort(403);
        }
        $this->validate($request,[
            'photo' => 'image|mimes:jpeg,bmp,png,gif|max:1024|dimensions:min_width=100,min_height=200',
            'signature' => 'image|mimes:jpeg,bmp,png,gif|max:512|dimensions:min_width=50,min_height=50',
        ]);
        if ($request->hasFile('photo')) {
            $fileName = $request->employee_id . time() . '.' . $request->file('photo')->getClientOriginalExtension();
            $path = 'uploads/photos/';
            Storage::disk('public-root')->put($path . $fileName, file_get_contents($request->file('photo')));
            EmployeeDocument::create([
                'employee_id' => $request->employee_id,
                'file_type_id' => 1,
                'file_path' => $path . $fileName,
            ]);
        }

        if ($request->hasFile('signature')) {
            $fileNameSignature = $request->employee_id . time() . '.' . $request->file('signature')->getClientOriginalExtension();
            $signaturePath = 'uploads/signatures/';
            Storage::disk('public-root')->put($signaturePath . $fileNameSignature, file_get_contents($request->file('signature')));
            EmployeeDocument::create([
                'employee_id' => $request->employee_id,
                'file_type_id' => 2,
                'file_path' => $signaturePath . $fileNameSignature,
            ]);
        }
        if($request->filled('type')){
            return redirect()->route('employee-profile.show', $request->employee_id."?type=pension")->with('success', "Picture has been uploaded!");
        } else {

            return redirect()->route('employee-profile.show', $request->employee_id)->with('success', "Picture has been uploaded!");
        }
    }

    public function store(Request $request)
    {

        if(!Auth::user()->can('manage_document')){
            abort(403);
        }
        $this->validate($request,[
//            'document' => 'file|mimes:jpeg,bmp,png,gif,pdf,doc|max:2048',
            'file_type_id'  => 'required',
            'document'      => 'required|file',
        ]);

        if ($request->hasFile('document')) {

            $fileName   = $request->employee_id .'-'. $request->file_type_id .'-'. time() . '.' . $request->file('document')->getClientOriginalExtension();
            $path       = 'uploads/files/';
            Storage::disk('public-root')->put($path . $fileName, file_get_contents($request->file('document')));

            EmployeeDocument::create([
                'employee_id'   => $request->employee_id,
                'file_type_id'  => $request->file_type_id,
                'file_path'     => $path . $fileName,
            ]);
        }
        if($request->filled('type')){
            return redirect()->route('employee-profile.show', [$request->employee_id,'type=pension#document'])->with('success', "File has been uploaded!");

        } else {
            return redirect()->route('employee-profile.show', [$request->employee_id,'#document'])->with('success', "File has been uploaded!");

        }
    }
}
