<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as ImageIntervention;

class ImageController extends Controller
{
    public function imageCreate()
    {
        return view('Uploadimage');
    }
    public function modal()
    {
        return view('modal');
    }

    public function ImageUpload(Request $request)
    {
        // $image = $request->image;
        // list($type, $image) = explode(';', $image);
        // list(, $image)      = explode(',', $image);
        // $image = base64_decode($image);
        $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->image));
        $image_name = time() . '.png';

        $path = public_path('images/' . $image_name);

        file_put_contents($path, $image);

        Image::create([
            'image' => $image_name,
        ]);
        // return response()->json(['status' => true]);
    }
}
