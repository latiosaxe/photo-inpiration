<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use \Auth;

use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function login(){
        return view('site.auth.login');
    }
    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
    public function authenticate(Request $request){
        $username = $request->input('username', '');
        $password = $request->input('password', '');

        if (Auth::attempt(['username' => $username, 'password' => $password])) {
            return response()->json(['message' => 'ok']);
//            return redirect()->intended('dashboard');
        }
        return response()->json(['message' => 'ko'], 400);
    }

    public function createUser(Request $request){
        $status = 400;
        $data = (object)['message' => ''];

        $username = $request->input('username', '');
        $password = $request->input('password', '');
        $email = $request->input('email', '');

        try {
            $user = User::where('name','=', $username)->first();
            if ($user === null) {
                $userData = [
                    'username' => $username,
                    'slug' => str_slug($username),
                    'email' => $email,
                    'password' => bcrypt($password),
                ];
                $newUser = User::create($userData);
            }

            $status = 200;
        }catch(\Exception $e){
            $data->message = $e->getMessage();
        }
        return response()->json($data, $status);
    }
}
