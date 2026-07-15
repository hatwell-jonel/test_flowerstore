<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $products = Product::all();

        $orders = [
            ['user_id' => $users[0]->id, 'product_id' => $products[0]->id, 'price' => 49.99],
            ['user_id' => $users[1]->id, 'product_id' => $products[2]->id, 'price' => 29.99],
            ['user_id' => $users[2]->id, 'product_id' => $products[1]->id, 'price' => 39.99],
            ['user_id' => $users[0]->id, 'product_id' => $products[4]->id, 'price' => 59.99],
            ['user_id' => $users[3]->id, 'product_id' => $products[3]->id, 'price' => 34.99],
            ['user_id' => $users[4]->id, 'product_id' => $products[5]->id, 'price' => 24.99],
            ['user_id' => $users[1]->id, 'product_id' => $products[6]->id, 'price' => 19.99],
            ['user_id' => $users[5]->id, 'product_id' => $products[7]->id, 'price' => 22.99],
            ['user_id' => $users[2]->id, 'product_id' => $products[8]->id, 'price' => 44.99],
            ['user_id' => $users[6]->id, 'product_id' => $products[0]->id, 'price' => 49.99],
            ['user_id' => $users[3]->id, 'product_id' => $products[9]->id, 'price' => 54.99],
            ['user_id' => $users[7]->id, 'product_id' => $products[10]->id, 'price' => 14.99],
            ['user_id' => $users[4]->id, 'product_id' => $products[11]->id, 'price' => 19.99],
            ['user_id' => $users[8]->id, 'product_id' => $products[12]->id, 'price' => 69.99],
            ['user_id' => $users[5]->id, 'product_id' => $products[13]->id, 'price' => 64.99],
            ['user_id' => $users[9]->id, 'product_id' => $products[14]->id, 'price' => 27.99],
            ['user_id' => $users[0]->id, 'product_id' => $products[2]->id, 'price' => 29.99],
            ['user_id' => $users[6]->id, 'product_id' => $products[4]->id, 'price' => 59.99],
            ['user_id' => $users[7]->id, 'product_id' => $products[1]->id, 'price' => 39.99],
            ['user_id' => $users[8]->id, 'product_id' => $products[9]->id, 'price' => 54.99],
        ];

        foreach ($orders as $order) {
            Order::create($order);
        }
    }
}
