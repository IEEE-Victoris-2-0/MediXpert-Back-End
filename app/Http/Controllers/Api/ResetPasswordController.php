<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Hash; 
use Ichtrojan\Otp\Otp;
class ResetPasswordController extends Controller
{
    private $otp;

    public function __construct()
    {
        $this->otp = new Otp;
    }


    public function PassworReset(ResetPasswordRequest $request)
    {
    $otp2 = $this->otp->validate($request->email, $request->otp);

    if (!$otp2->status)
    {    
        return response()->json(['error'=>$otp2],401);   
    }

    $user = User::where('email',$request->email)->first();
    $user->update(['password'=>Hash::make($request->password)]);
    $user->tokens()->delete();
    $success['success'] = true; 

    return response()->json($success,200);
}
}