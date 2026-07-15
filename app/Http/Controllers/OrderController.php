<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('product:id,product_name,price')->get();

        return response()->json($orders);
    }
}
