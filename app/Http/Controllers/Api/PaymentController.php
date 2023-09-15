<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
class PaymentController extends Controller
{
    public function payment(Request $request)
    {
        $payment = $request->user();
        return response()->json([
            'payLink' => $payment->charge(12.99, 'Action Figure')
        ]);
    }
}
