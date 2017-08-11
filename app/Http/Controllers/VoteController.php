<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Vote;
use App\Photo;
use App\Color;

//require_once 'vendor/autoload.php';
use ColorThief\ColorThief;

class VoteController extends Controller
{
    public function store(Request $request){
        $status = 400;
        $data = (object)['message' => ''];

        $ip = $_SERVER['REMOTE_ADDR'];
//        $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}"));
        $details = '';

        try {
            $voteData = [
                'photo_id' => $request->get('photo_id'),
                'ip' => $ip,
//                'region' => $details->city,
                'region' => $details,
            ];
            $vote = Vote::create($voteData);
            $photoId = $request->input('photo_id', '');


            $photo = Photo::where('uid','=', $request->get('photo_id'))->first();
            if ($photo === null) {
                $colors = $this->getImageColor($request->input('photo', ''));
                $result = array();
                foreach ($colors['palette'] as $singleColor) {
                    $element = (object) array('red' => $singleColor[0], 'green' => $singleColor[1], 'blue' => $singleColor[2]);
                    $result[] = $element;
                }
                $photoData = [
                    'uid' => $photoId,
                    'title' => $request->get('title', ''),
                    'description' => $request->input('description', ''),
                    'photo' => $request->input('photo', ''),
                    'votes' => 1,
                    'category' => $request->input('category', ''),
                    'user_name' => $request->input('user_name', ''),
                    'user_nickname' => $request->input('user_nickname', ''),
                    'user_location' => $request->input('user_location', ''),
                    'user_profile' => $request->input('user_profile', ''),
                    'average_color' => 'rgb('.$colors['domain'][0].', '.$colors['domain'][1].', '.$colors['domain'][2].')',
                    'palette_color' => json_encode($result),
                ];
                $newphoto = Photo::create($photoData);

                $colorData = [
                    'photo_id' => $photoId,
                    'red' => $colors['domain'][0],
                    'green' => $colors['domain'][1],
                    'blue' => $colors['domain'][2],
                ];
                $newColor = Color::create($colorData);
            }else{
                Photo::where('uid','=', $request->get('photo_id'))->first()->increment('votes');
            }
            
            $status = 200;
        }catch(\Exception $e){
            $data->message = $e->getMessage();
        }
        return response()->json($data, $status);
    }

    public function rgb($value){
        return 'rgb('.$value[0].', '.$value[1].', '.$value[2].')';
    }

    public function getImageColor($image){
        $content = file_get_contents($image);
//        dd($content);
//        $dominantColor = ColorThief::getColor($content);

        $dominantColor = ColorThief::getColor($content);
        $palette = ColorThief::getPalette($content, 9);

        $data['domain'] = $dominantColor;
        $data['palette'] = $palette;

        return $data;
//        dd(  );
    }
}
