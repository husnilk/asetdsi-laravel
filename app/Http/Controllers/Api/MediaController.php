<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
      
        if ($request->photo) {

            $file = cloudinary()->upload($request->file('photo')->getRealPath())->getSecurePath();
         
        } else {

            $file = "https://res.cloudinary.com/nishia/image/upload/v1663485047/default-image_yasmsd.jpg";

        }

        $response = new \stdClass();
        return response()->json([
            'photo_name' =>  $file,
            'success' => true,
            'message' => 'Success',
        ]);
    }
}
