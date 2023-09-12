<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
class LoginController extends Controller
{

    public function login(LoginRequest $request)
    {
        $request->authenticate();


        $token = $request->user()->createToken('authtoken');

       return response()->json(
           [
               'message'=>'Logged in',
               'data'=> [
                   'user'=> $request->user(),
                   'token'=> $token->plainTextToken
               ]
           ]
        );
    }
}
