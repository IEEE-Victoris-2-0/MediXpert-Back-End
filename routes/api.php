<?php

use App\Http\Controllers\Api\EmailVerficationController;
use App\Http\Controllers\Api\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\ForgetPasswordController;
use App\Http\Controllers\Api\ResetPasswordController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post("register",[RegisterController::class,"register"]);
Route::post("login",[LoginController::class,"login"]);
Route::post("password/forget-password",[ForgetPasswordController::class,'forgetpassword']);
Route::post("password/reset-password",[ResetPasswordController::class,'PassworReset']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post("email-verification",[EmailVerficationController::class,'email_verification']);
    Route::get("email-verification",[EmailVerficationController::class,'send_email_verification']);
});

