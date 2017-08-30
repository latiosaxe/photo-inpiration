<?php

namespace App\Http\Controllers\Profile;

use App\Gallery;
use \Auth;
use App\Photo;
use App\User;
use App\Follow;
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
    public function gallery($id){
        $user = Auth::user();
        $gallery = Gallery::find($id);
        $follows = Follow::all();
        $users = User::where('id', '!=', Auth::id())->get();

        if($gallery->user_id == $user->id){
            $data = [
                'user' => $user,
                'users' => $users,
                'gallery' => $gallery,
            ];

            return view('site.profile.gallery', $data);
        }else{
            return redirect('/profile');
        }
    }
}
