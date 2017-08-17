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


        $limitTemporalMIN = 0;
        $limitTemporalMAX = 235;

        $redMIN = $limitTemporalMIN;
        $greenMIN = $limitTemporalMIN;
        $blueMIN = $limitTemporalMIN;

        $redMAX = $limitTemporalMAX;
        $greenMAX = $limitTemporalMAX;
        $blueMAX = $limitTemporalMAX;

        if($colors[0] - $rangeValue > 0){
            $redMIN = $colors[0] - $rangeValue;
        }
        if($colors[1] - $rangeValue > 0){
            $greenMIN = $colors[1] - $rangeValue;
        }
        if($colors[2] - $rangeValue > 0){
            $blueMIN = $colors[2] - $rangeValue;
        }

        if($colors[0] + $rangeValue < 235){
            $redMAX = $colors[0] + $rangeValue;
        }
        if($colors[1] + $rangeValue < 235){
            $greenMAX = $colors[1] + $rangeValue;
        }
        if($colors[2] + $rangeValue < 235){
            $blueMAX = $colors[2] + $rangeValue;
        }

        $images = Color::where('from', 'average')
            ->whereBetween('red', [ $redMIN, $redMAX])
            ->whereBetween('green', [ $greenMIN, $greenMAX])
            ->whereBetween('blue', [ $blueMIN, $blueMAX])
            ->inRandomOrder()
            ->get();



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
