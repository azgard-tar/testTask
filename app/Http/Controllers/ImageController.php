<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\employee;

class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public static function getImage( Request $request, employee $employee )
    {
        return ["file" => storage_path('app/') . $employee->photo];
    }

    public static function uploadImage( Request $request, employee $employee ){
        $currentEmployee = employee::findOrFail( $employee->id );
        if( $request->hasFile('photo')){
            $request->validate([
                'photo' => 'image|mimes:jpeg,png,jpg,svg|max:5120',
            ],[
                "mimes" => "Current mimes is not supported",
                "max"   => "Maximum size of file is 5mb",
                "image" => "File must be an image"
            ]);
            if( file_exists( storage_path('app/') . $currentEmployee->photo ) && $currentEmployee->photo !== 'images/no-avatar.png' )
                unlink( storage_path('app/') . $currentEmployee->photo );
            $currentEmployee->photo = $request->file('photo')->store('images');
            $currentEmployee->save();
            return ["file" => storage_path('app/') . $currentEmployee->photo];
        }
        return ['error' => 'Image was not found',"code" => 404];
    }
}
