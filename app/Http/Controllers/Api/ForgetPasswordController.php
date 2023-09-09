<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notifications\RestPasswordNotification;
use App\Models\User;
use App\Http\Requests\Auth\ForgetPasswordRequest;
class ForgetPasswordController extends Controller
{
    public function forgetpassword(ForgetPasswordRequest $request)
    {
        $input = $request->only('email');
        $user = User::where('email',$input)->first();
        $user->notify(new RestPasswordNotification());
        $success['success'] = true; 
        return response()->json($success,200);
    }
}
