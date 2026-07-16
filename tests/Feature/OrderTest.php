<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_orders()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['product_name' => 'Test Rose', 'price' => 25.00]);
        Order::create(['product_id' => $product->id, 'user_id' => $user->id, 'price' => 25.00]);

        $response = $this->getJson('/api/v1/orders');

        $response->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonFragment(['price' => '25.00']);
    }

    public function test_returns_orders_with_product_relationship()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['product_name' => 'Lily']);
        Order::create(['product_id' => $product->id, 'user_id' => $user->id, 'price' => 15.00]);

        $response = $this->getJson('/api/v1/orders');

        $response->assertOk()
            ->assertJsonFragment(['product_name' => 'Lily']);
    }
}
