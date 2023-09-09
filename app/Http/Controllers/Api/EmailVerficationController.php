<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use App\Notifications\EmailVerficationNotification;
use App\Models\User;
use App\Http\Requests\Auth\EmailVerficationRequest;
class EmailVerficationController extends Controller
{

    private $otp; 
    public function __construct()
    {
        $this->otp = new Otp;
    }

    public function send_email_verification(Request $request)
    {
        $request->user()->notify(new EmailVerficationNotification());
        $success['success'] = true; 
        return response()->json($success,200);
    }
    public function email_verification(EmailVerficationRequest $request)
    {
        $otp2 = $this->otp->validate($request->email,$request->otp);

        if(!$otp2->status)
        {
            return response()->json(['error'=>$otp2],401);
        }

        $user = User::where('email',$request->email)->first();
        $user->update(['email_verified_at'=>now()]);
        $success['success'] = true; 
        return response()->json($success,200);
    }
}
