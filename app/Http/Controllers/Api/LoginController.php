<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use Auth;
use App\Notifications\LoginNotification;
class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $user->tokens()->delete();
            $token = $user->createToken(request()->userAgent())->plainTextToken;
            $success = [
                'token' => $token,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'success' => true,
                $user->notify(new LoginNotification)
            ];
            return response()->json($success, 200);
        }

        return response()->json(['error' => 'Email or password is incorrect.'], 400);
    }
}
