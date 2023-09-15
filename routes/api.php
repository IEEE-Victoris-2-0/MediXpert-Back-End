<?php
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\DrugController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\PharamcyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\NewPasswordController;
use App\Http\Controllers\Api\EmailVerificationController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\UserOrders;
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
/////////////////////////////////////////////////////////
Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);
Route::post('logout',[LogoutController::class,'logout'])->middleware('auth:sanctum');
Route::post('email/verification-notification', [EmailVerificationController::class, 'sendVerificationEmail'])->middleware('auth:sanctum');
Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify')->middleware('auth:sanctum');
Route::post('forgot-password', [NewPasswordController::class, 'forgotPassword']);
Route::post('reset-password', [NewPasswordController::class, 'reset']);
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
/////////////////////////////////////////////////////////////////////
Route::post('add-to-cart',[CartController::class,'addtocart'])->middleware('auth:api');
Route::delete('removefromcart',[CartController::class,'removeFromCart'])->middleware('auth:api');
Route::post('update_cart',[CartController::class,'UpdateCart'])->middleware('auth:api');

Route::middleware(['auth:api'])->group(function(){
Route::get('cart',[CartController::class,'viewCart']);
Route::post('place-order',[CheckoutController::class,'PlaceOrder']);
Route::get('myorders',[UserOrders::class,'orders']);
Route::get('orders_itmes',[UserOrders::class,'orders_itmes']);
});
/////////////////////////////////////////////////////////////
Route::post('order/{id}',[UserOrders::class,'OrderDashboard']);
Route::post('updateorderstatus/{id}',[UserOrders::class,'UpdateOrderStatus']);


 

