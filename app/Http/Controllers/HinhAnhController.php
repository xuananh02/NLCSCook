<?php

namespace App\Http\Controllers;

use App\Models\HinhAnh;
use Illuminate\Http\Request;

class HinhAnhController extends Controller
{


    public function storeMul(Request $request)
    {
        $request->validate([
            'images' => 'required',
            'images.*' => 'present|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $urlImages = [];

        // dd($request->file('images'));

        $path = "images/";

        foreach ($request->file('images') as $file) {

            $nameFileArray = explode('.', $file->getClientOriginalName());
            $extentionFile = end($nameFileArray);

            $fileName = md5(microtime()) . '.' . $extentionFile;
            
            $file->storeAs($path . $fileName);

            $urlImages[] = url($path . $fileName);
        }

        return [
            'images' => $urlImages
        ];
    }

    // public function store(Request $request)
    // {
    //     $validator =
    //         $request->validate([
    //             'image' => 'required',
    //             'image.*' => 'present|image|mines:jpg',
    //         ]);

    //     $path = "images/";
    //     $file = $validator['image'];

    //     // $nameFileArray = explode('.', $file->getClientOriginName());
    //     // $extentionFile = end($nameFileArray);

    //     $source = $file->storeAs($path, md5(microtime()) . 'jpg');


    //     return response([
    //         'images' => $source
    //     ], 200);
    // }
}