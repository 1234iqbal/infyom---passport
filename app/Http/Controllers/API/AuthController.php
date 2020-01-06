<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|max:55',
            'name'  => 'required',
            'password' => 'required|confirmed'
        ]);

        $validatedData['password'] = bcrypt($request->password);

        $user = User::create($validatedData);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response([ 'user' => $user, 'access_token'=>$accessToken ]);
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'required|max:55',
            'password' => 'required'
        ]);

        if( !Auth::attempt($loginData)) {
            return response(['message' => 'invalid credentials']);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        $refreshToken = '';

        return response([ 'user' => auth()->user(), 'access_token'=>$accessToken , 'refreshToken' => $refreshToken]);

    }

    public function loginApi(Request $request) {
        $http = new \GuzzleHttp\Client();
        return ;
    }
}
