<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Notifications\EmailVerficationNotification;
class RegisterController extends Controller
{
    public function register(RegistrationRequest $request)
    {
        $validatedData = $request->validated();
        
        // Check if email has been used before
        $existingEmailUser = User::where('email', $validatedData['email'])
                                ->first();
        
        if ($existingEmailUser) {
            $error = [
                'message' => 'Email has been used before.',
            ];
            
            return response()->json($error, 400);
        }
        
        // Check if phone number has been used before
        $existingPhoneUser = User::where('phone', $validatedData['phone'])
                                ->first();
        
        if ($existingPhoneUser) {
            $error = [
                'message' => 'Phone number has been used before.',
            ];
            
            return response()->json($error, 400);
        }

        // Create new user
        $validatedData['password'] = Hash::make($validatedData['password']);
        $user = User::create($validatedData);
        
        // Generate token
        $token = $user->createToken('user', ['app:all'])->plainTextToken;
        
        $success = [
            'token' => $token,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'success' => true,
            $user->notify( new EmailVerficationNotification())
        ];
        
        return response()->json($success, 200);
    }
}
