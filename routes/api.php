<?php
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DrugController;
use App\Http\Controllers\Api\EmailVerficationController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\PharamcyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\ForgetPasswordController;
use App\Http\Controllers\Api\ResetPasswordController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
/////////////////////////////////////////////////////////
Route::post("register",[RegisterController::class,"register"]);
Route::post("login",[LoginController::class,"login"]);
Route::post("password/forget-password",[ForgetPasswordController::class,'forgetpassword']);
Route::post("password/reset-password",[ResetPasswordController::class,'PassworReset']);
Route::middleware('auth:sanctum')->group(function () {
Route::post("email-verification",[EmailVerficationController::class,'email_verification']);
 Route::get("email-verification",[EmailVerficationController::class,'send_email_verification']);
});
///////////////////////////////////////////////////////////
Route::get("categories",[CategoryController::class,'index']);
Route::get("category/{id}",[CategoryController::class,'show']);
Route::post('add_category',[CategoryController::class,'insert']);
Route::put("edit_category/{id}",[CategoryController::class,'edit']);
Route::delete("delete_category/{id}",[CategoryController::class,'']);
//////////////////////////////////////////////////////////////
Route::get('drugs',[DrugController::class,'index']);
Route::get("drug/{id}",[DrugController::class,'show']);
Route::post('add_drug',[DrugController::class,'insert']);
Route::put("edit_drug/{id}",[DrugController::class,'edit']);
Route::delete('delete_drug/{id}',[DrugController::class,'destroy']);
///////////////////////////////////////////////////////////////
Route::get("pharamcyies",[PharamcyController::class,'index']);
Route::get('pharmacy/{id}',[PharamcyController::class,'show']);
Route::post('add_pharmacy',[PharamcyController::class,'insert']);
Route::put('edit_pharma/{id}',[PharamcyController::class,'edit']);
Route::delete('delete_pharma/{id}',[PharamcyController::class,'destroy']);
////////////////////////////////////////////////////////////////////
Route::get('home',[HomeController::class,'index']);
Route::get('drug_by_categ/{id}',[HomeController::class,'product_by_category']);


