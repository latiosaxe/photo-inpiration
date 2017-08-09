<?php

namespace App\Http\Controllers;

use App\Photo;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function index(){
        $allPhotos = Photo::where('active', 1)->orderBy('votes', 'desc')->take(20)->get();
        $photos = $allPhotos->random(12);

        $data = [
            'photos' => $photos,
        ];

        return view('site.sections.home', $data);
    }
}
