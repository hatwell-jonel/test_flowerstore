<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('product:id,product_name,price')->paginate(7);
        $grandTotal = Order::sum('price');

        return response()->json(array_merge($orders->toArray(), [
            'grand_total' => (float) $grandTotal,
        ]));
    }
}
