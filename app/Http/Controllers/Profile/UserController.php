<?php

namespace App\Http\Controllers\Profile;

use \Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function profile(){
        $username = Auth::user()->username;

        $data = [
            'username' => $username,
        ];
        return view('site.profile.index', $data);
    }
}
