<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    // Display all media files
    public function index()
    {
        $media_files = Media::all();  // Fetch all media files
        return view('media.index', compact('media_files'));
    }

    // Store a new media file
    public function store(Request $request)
    {
        if ($request->hasFile('file_upload')) {
            $file = $request->file('file_upload');
            $originalName = $file->getClientOriginalName();
    
            // Check if a file with the same original name already exists in the database
            $existingMedia = Media::where('file_name', $originalName)->first();
            if ($existingMedia) {
                return redirect()->route('media.index')->with('msg', 'This photo has already been uploaded.');
            }
    
            // Save the file using original name
            $file->move(public_path('lib/products'), $originalName);
    
            // Save to DB
            Media::create([
                'file_name' => $originalName,
                'file_type' => $file->getClientOriginalExtension(),
            ]);
    
            return redirect()->route('media.index')->with('msg', 'Photo has been uploaded.');
        }
    
        return redirect()->route('media.index')->with('msg', 'No file uploaded.');
    }
    

    // Delete a media file
    public function destroy($id)
    {
        $media = Media::findOrFail($id);

        // Delete the file from public/lib/images
        $filePath = public_path('lib/procucts/' . $media->file_name);
        if (file_exists($filePath)) {
     
        }

        // Delete the record from the database
        $media->delete();

        return redirect()->route('media.index')->with('msg', 'Photo has been deleted.');
    }
}
