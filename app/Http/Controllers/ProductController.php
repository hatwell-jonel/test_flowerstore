<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if (!$request->boolean('include_disabled')) {
            $query->where('status', 'enabled');
        }

        if (in_array($request->sort, ['product_name', 'price', 'status'])) {
            $direction = $request->direction === 'desc' ? 'desc' : 'asc';
            $query->orderBy($request->sort, $direction);
        }

        return response()->json($query->paginate(7));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_description' => 'required|string',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        $data['status'] = 'enabled';

        $product = Product::create($data);

        return response()->json($product, 201);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'product_name' => 'sometimes|string|max:255',
            'product_description' => 'sometimes|string',
            'quantity' => 'sometimes|integer|min:0',
            'price' => 'sometimes|numeric|min:0',
        ]);

        $product->update($data);

        return response()->json($product);
    }

    public function toggleStatus($id)
    {
        $product = Product::findOrFail($id);

        $product->status = $product->status === 'enabled' ? 'disabled' : 'enabled';
        $product->save();

        return response()->json($product);
    }
}
