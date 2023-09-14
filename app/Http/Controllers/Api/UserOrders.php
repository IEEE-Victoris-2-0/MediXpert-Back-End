<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class UserOrders extends Controller
{
    public function orders(Request $request)
    {
        $orders = Order::where('user_id', $request->user()->id)->get();
       // dd($orders);
        return response()->json($orders);
    }

    public function orders_itmes(Request $request)
    {
        $userId = $request->user()->id;
        
        $orders = Order::where('user_id', $userId)->get();
        
        $orderItems = OrderItem::whereIn('order_id', $orders->pluck('id'))->get();
        
        return response()->json($orderItems);
    }
}
