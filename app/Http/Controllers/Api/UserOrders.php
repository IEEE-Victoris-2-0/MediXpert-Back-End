<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
class UserOrders extends Controller
{

    public function orders(Request $request)
    {
        $order = Order::where('user_id',$request->user()->get());
        return response()->json($order);
    }

}
