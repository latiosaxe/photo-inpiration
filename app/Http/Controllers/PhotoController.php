<?php

namespace App\Http\Controllers;

use App\Photo;
use App\Color;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function index(){
        $allPhotos = Photo::where('active', 1)->orderBy('votes', 'desc')->take(27)->get();
        $photos = $allPhotos->random(27);
//        $photos = $allPhotos->random(18);
        $data = [
            'photos' => $photos,

        ];
        return view('site.sections.home', $data);


//        $this->searchByColor();
    }

    public function searchByColor($color){
        $rgb = $color;
        $colors = explode("-", $rgb);
        $rangeValue = 25;

        $redMIN = 0;
        $greenMIN = 0;
        $blueMIN = 0;

        $redMAX = 255;
        $greenMAX = 255;
        $blueMAX = 255;

        if($colors[0] - $rangeValue > 0){
            $redMIN = $colors[0] - $rangeValue;
        }
        if($colors[1] - $rangeValue > 0){
            $greenMIN = $colors[1] - $rangeValue;
        }
        if($colors[2] - $rangeValue > 0){
            $blueMIN = $colors[2] - $rangeValue;
        }

        if($colors[0] + $rangeValue < 255){
            $redMAX = $colors[0] + $rangeValue;
        }
        if($colors[1] + $rangeValue < 255){
            $greenMAX = $colors[1] + $rangeValue;
        }
        if($colors[2] + $rangeValue < 255){
            $blueMAX = $colors[2] + $rangeValue;
        }

        $images = Color::where('from', 'average')
            ->whereBetween('red', [ $redMIN, $redMAX])
            ->whereBetween('green', [ $greenMIN, $greenMAX])
            ->whereBetween('blue', [ $blueMIN, $blueMAX])
            ->orderBy('votes')
            ->get();

        //            ->inRandomOrder()

        $photos = array();
        foreach ($images as $image){
            $single = Photo::where('uid', $image->photo_id)->first();
            if($single){
                $photos[] = $single;
            }
        }

        $data = [
            'color' => $color,
            'photos' => $photos,
            'keyword' => 'Color',
        ];

        return view('site.sections.own_search', $data);
    }
}
