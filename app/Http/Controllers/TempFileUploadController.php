<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TempFileUploadController extends Controller
{
    public function __invoke(Request $request)
    {
        if ($request->hasFile('image')) {
            $request->validate([
                'images.*' => 'mimes:png,jpg,jpeg|max:5000'
            ],[
                'images.*.mimes' => "The file you're uploading should be one of the following formats: .jpg, .png or .jpeg."
            ]);
            
            // Define path for storing temp images, get file and create unique filename
            $path = storage_path('app/public/tmp/uploads');
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Store image to specified path
            $file->move($path, $filename);

            return ['name' => $filename];
        }
    }
}
