<?php

namespace App\Http\Controllers;

use App\Photo;
use App\Color;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function index(){
        $allPhotos = Photo::where('active', 1)->orderBy('votes', 'desc')->take(20)->get();
        $photos = $allPhotos->random(8);
//        $photos = $allPhotos->random(18);
        $data = [
            'photos' => $photos,

        ];
        return view('site.sections.home', $data);


//        $this->searchByColor();
    }

    public function searchByColor(Request $request){
        $rgba = $request->get('color');
        $colors = explode(",", $rgba);
        $rangeValue = 40;

        $images = Color::whereBetween('red', [ $colors[0] - $rangeValue, $colors[0] + $rangeValue])
            ->whereBetween('green', [ $colors[1] - $rangeValue, $colors[1] + $rangeValue])
            ->whereBetween('blue', [ $colors[1] - $rangeValue, $colors[1] + $rangeValue])
            ->get();



        
        foreach ($images as $image){
            dd($image->photo_id);
        }


//        return view('site.sections.own_search', $data);
    }
}
