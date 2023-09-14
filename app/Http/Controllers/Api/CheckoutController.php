<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Drug;
use App\Models\Order;
use App\Models\OrderItem;

class CheckoutController extends Controller
{
    public function placeOrder(Request $request)
    {
        $user = $request->user();
        $cartItems = Cart::where('user_id', $user->id)->get();
        
        foreach($cartItems as $item)
        {    
            if(!Drug::where('id', $item->drug_id)->where('qty', '>=', $item->qty)->exists())
            {
                $removeItem = Cart::where('user_id', $user->id)->where('drug_id', $item->drug_id);
                $removeItem->delete();
            }
        }

        $order = new Order();
        $order->user_id = $user;
        $order->fname = $request->input('fname');     
        $order->lname = $request->input('lname');     
        $order->phone = $request->input('phone');     
        $order->address = $request->input('address');     
        $order->state = $request->input('state');     
        $order->city = $request->input('city');     
        $order->order_status = $request->input('order_status');     
        $order->tracking_no = 'Medixpert'.rand(1111,9999); 
        $order->save();
        $cartItems = Cart::where('user_id', $user->id)->get();

        foreach($cartItems as $item)
        {
          $order_items = OrderItem::create([
                "order_id" => $order->id,
                "drug_id" => $item->drug_id,
                "qty" => $item->qty,
            ])->get();
        }
        
        $drug = Drug::where('id',$item->drug_id)->first();
        $drug->qty -= $item->qty;

        $array = [
            "cart_items" => $cartItems,
            'order_details' => $order,
            'order_items'=>$order_items , 
        ];
        Cart::destroy($cartItems);
        return response($array, 201);
    }
}