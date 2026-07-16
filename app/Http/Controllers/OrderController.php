<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('product:id,product_name,price');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('product', function ($q) use ($search) {
                $q->where('product_name', 'like', "%{$search}%");
            });
        }

        if (in_array($request->sort, ['product_name', 'price'])) {
            $direction = $request->direction === 'desc' ? 'desc' : 'asc';

            if ($request->sort === 'product_name') {
                $query->join('products', 'orders.product_id', '=', 'products.id')
                    ->orderBy('products.product_name', $direction)
                    ->select('orders.*');
            } else {
                $query->orderBy($request->sort, $direction);
            }
        }

        $orders = $query->paginate(7);
        $grandTotal = Order::sum('price');

        return response()->json(array_merge($orders->toArray(), [
            'grand_total' => (float) $grandTotal,
        ]));
    }
}
