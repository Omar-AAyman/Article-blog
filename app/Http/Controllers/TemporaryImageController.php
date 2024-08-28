<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TemporaryImage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class TemporaryImageController extends Controller
{

    public function upload(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = $image->getClientOriginalName();
            $folder = uniqid('image-', true);
            $image->storeAs('images/tmp/' . $folder, $fileName);
            
            TemporaryImage::create([
                'folder' => $folder,
                'file' => $fileName,
            ]);
            return $folder;
        };
        return '';
    }

    public function delete()
    {
        $temporaryImage = TemporaryImage::Where('folder', request()->getContent())->first();
        if ($temporaryImage) {
            Storage::deleteDirectory('images/tmp/' . $temporaryImage->folder);
            $temporaryImage->delete();
        };
        return response()->noContent();
    }
}
