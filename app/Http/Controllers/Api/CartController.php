<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Drug;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{
    public function addtocart(Request $request)
    {
        $drug_id = $request->input('drug_id');
        $qty = $request->input('qty');
        $user = $request->user();

        if (!$user) {
            throw ValidationException::withMessages(['status' => 'login to complete']);
        }

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

    public function viwecart(Request $request)
    {
        $cart = Cart::where('user_id',$request->user()->id());
        return response($cart,201);
    }
}
