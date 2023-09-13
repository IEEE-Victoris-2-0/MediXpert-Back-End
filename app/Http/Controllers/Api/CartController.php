<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Drug;
use illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addtocart(Request $request)
    {
        $drug_id = $request->input('drug_id');
        $qty = $request->input('qty');
        $user = $request->user();

        $drug = Drug::find($drug_id);

        if (!$drug) {
            return response()->json(['status' => 'Drug not found'], 404);
        }

        $existingCartItem = Cart::where('drug_id', $drug_id)
                                ->where('user_id', $user->id)
                                ->first();

        if ($existingCartItem) {
            return response()->json(['status' => 'already in cart'], 409);
        }

        $cartItem = new Cart();
        $cartItem->user_id = $user->id;
        $cartItem->drug_id = $drug_id;
        $cartItem->qty = $qty;
        $cartItem->save();

        return response()->json(['status' => 'added to cart'], 201);
    }

    public function viewCart(Request $request)
{
    $user = $request->user();
    $cart = Cart::where('user_id', $user->id)->get();
    
    if (!$cart) {
        return response()->json(['status' => 'Your cart is empty']);
    }
    $array = [
        'user'=>$user,
        "cartitems"=>$cart,
    ];
    return response($array,201);
}
public function removeFromCart(Request $request)
{
    if (!$user = $request->user()) {
        return response()->json(['status' => 'Please log in to complete'], 401);
    }
    Cart::where('id', $request->input('item_id'))?->delete();

    return response()->json(['status' => 'Drug Deleted Successfully']);
}
}
