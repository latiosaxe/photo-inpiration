<?php

namespace App\Http\Controllers\Profile;

use \Auth;
use App\Photo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller{

    public function profile(){
        $user = Auth::user();
        $galleries = $user->galleries;

//        Photo::where('gallery_id', $gallery->id)->get();

        foreach ($galleries as $gallery){
//            dd($gallery->photos[0]->photo->photo);
            $gallery->photos = count($gallery->photos);
            $gallery->cover = '';
        }

        $data = [
            'user' => $user,
            'galleries' => $galleries,
        ];

        return view('site.profile.index', $data);
    }
}
