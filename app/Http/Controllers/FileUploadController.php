<?php

namespace App\Http\Controllers;

use App\Models\FileUpload;
use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    //
    public function index() 
    {
        $fileUplaods = FileUpload::get();
        return view('fileupload.index', ['fileUploads' => $fileUplaods]);
    }
 
    public function multipleUpload(Request $request) 
    {
        $this->validate($request, [
            'fileuploads' => 'required',
            'fileuploads.*' => 'mimes:doc,pdf,docx,pptx,zip,jpeg,png,xlsx',
        ]);
 
        $files = $request->file('fileuploads');
        foreach($files as $file){
            $fileUpload = new FileUpload;
            $fileUpload->filename = $file->getClientOriginalName();
            $fileUpload->filepath = $file->store('fileuploads');
            $fileUpload->type= $file->getClientOriginalExtension();
            $fileUpload->save();
        }   
 
        return redirect()->route('fileupload.index')->with('success','Files uploaded successfully!');
    }
}