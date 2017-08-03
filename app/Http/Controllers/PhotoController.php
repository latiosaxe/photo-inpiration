<?php

namespace App\Http\Controllers;

use App\Photo;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function index(){
        $photos = Photo::where('active', 1)->orderBy('votes', 'desc')->take(6)->get();

        $data = [
            'photos' => $photos,
        ];

        return view('site.sections.home', $data);
    }
}
