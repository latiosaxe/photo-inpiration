<?php

namespace App\Http\Controllers\Profile;

use \Auth;
use App\Photo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function profile(){
        $user = Auth::user();

        $galleries = array();
        foreach ($user->galleries as $gallery){
            $user->galleries->photos = Photo::where('gallery_id', $gallery->id)->get();
        }

        $data = [
            'user' => $user,
            'galleries' => $galleries,
        ];

        return view('site.profile.index', $data);
    }
}
