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
        // dd($request->image);
        $image = $request->image;

        list($type, $image) = explode(';', $image);
        list(, $image)      = explode(',', $image);
        // dd($type);
        $image = base64_decode($image);
        $image_name = time() . '.png';
        // dd($image_name);
        $path = public_path('images/' . $image_name);

        file_put_contents($path, $image);

        // return response()->json(['status' => true]);

        // if ($request->has('image')) {
        //     $imageName =  time() . '.' . $request->image->extension();
        //     ImageIntervention::make($request->image)->resize(300, 300)->save('images/' . $imageName);
        // } else {
        //     $imageName = null;
        // }

        Image::create([
            'image' => $image_name,
        ]);
    }
}
