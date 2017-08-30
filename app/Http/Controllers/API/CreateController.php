<?php

namespace App\Http\Controllers\API;

use \Auth;
use App\Gallery;
use App\Follow;
use App\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CreateController extends Controller
{
    public function createGallery(Request $request){
        $status = 400;
        $data = (object)['message' => ''];
        try {
            $user = Auth::user();
            if($user) {
                $name = $request->get('name', '');
                $slug = str_slug($name);
                $galleries = $user->galleries;
                $can_create = true;
                foreach ($galleries as $gal){
                    if($gal->slug == $slug){
                        $can_create = false;
                    }
                }
                if( $can_create ){
                    $galleryData = [
                        'user_id' => Auth::user()->id,
                        'name' => $request->get('name', ''),
                        'slug' => str_slug($request->get('name', '')),
                        'description' => $request->input('description', ''),
                        'ip' => $_SERVER['REMOTE_ADDR'],
                        'active' => 1,
                    ];
                    $newGallery = Gallery::create($galleryData);
                    $status = 200;
                }else{

                }
            }
        }catch(\Exception $e){
            $data->message = $e->getMessage();
        }
        return response()->json($data, $status);
    }
    public function createComment(Request $request){
//        dd ($request->get('comment-image'));


        $status = 400;
        $data = (object)['message' => ''];
        try {
            $user = Auth::user();
            if($user) {
                $commentData = [
                    'user_id' => Auth::user()->id,
                    'content_id' => $request->input('content_id', ''),
                    'text' => $request->get('text', ''),
                    'ip' => $_SERVER['REMOTE_ADDR'],
                    'replay_id' => $request->get('replay_id', ''),
                    'active' => 1,
                ];
                $newComment = Comment::create($commentData);
                $status = 200;
            }
        }catch(\Exception $e){
            $data->message = $e->getMessage();
        }
        return response()->json($data, $status);
    }

    public function followUser(Request $request){
        $status = 400;
        $data = (object)['message' => ''];
        try {
            $user = Auth::user();
            if($user) {
                $from = Auth::user()->id;
                $to = $request->get('user_id', '');
                $checkFollow = Follow::where('user_id_from','=', $from)
                    ->where('user_id_to', '=', $to)
                    ->first();
                if($checkFollow){
//                    $checkFollow->active = 0;
//                    $checkFollow->save();

                    $checkFollow->delete();
                }else{
                    $followData = [
                        'user_id_from' => $from,
                        'user_id_to' => $to,
                        'active' => 1,
                    ];
                    $newFollow = Follow::create($followData);
                }
                $status = 200;
            }
        }catch(\Exception $e){
            $data->message = $e->getMessage();
        }
        return response()->json($data, $status);
    }
}
