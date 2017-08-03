<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Vote;
use App\Photo;

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
//                $uid = strrev(base_convert(time(),10,26));


                


                $photoData = [
                    'uid' => $request->get('photo_id'),
                    'title' => $request->get('title', ''),
                    'description' => $request->input('description', ''),
                    'photo' => $request->input('photo', ''),
                    'votes' => 1,
                    'category' => $request->input('category', ''),
                    'user_name' => $request->input('user_name', ''),
                    'user_nickname' => $request->input('user_nickname', ''),
                    'user_location' => $request->input('user_location', ''),
                    'user_profile' => $request->input('user_profile', ''),
                ];
                $newphoto = Photo::create($photoData);
            }else{
                Photo::where('uid','=', $request->get('photo_id'))->first()->increment('votes');
            }
            
            $status = 200;
        }catch(\Exception $e){
            $data->message = $e->getMessage();
        }
        return response()->json($data, $status);
    }
}
