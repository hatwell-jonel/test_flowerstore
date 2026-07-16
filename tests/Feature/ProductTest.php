<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_enabled_products()
    {
        Product::factory()->create(['product_name' => 'Enabled Product', 'status' => 'enabled', 'quantity' => 10, 'price' => 9.99]);
        Product::factory()->create(['product_name' => 'Disabled Product', 'status' => 'disabled', 'quantity' => 5, 'price' => 4.99]);

        $response = $this->getJson('/api/v1/products');

        $response->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonFragment(['product_name' => 'Enabled Product'])
            ->assertJsonMissing(['product_name' => 'Disabled Product']);
    }

    public function test_can_list_all_products_including_disabled()
    {
        Product::factory()->create(['product_name' => 'Enabled Product', 'status' => 'enabled']);
        Product::factory()->create(['product_name' => 'Disabled Product', 'status' => 'disabled']);

        $response = $this->getJson('/api/v1/products?include_disabled=true');

        $response->assertOk()
            ->assertJsonCount(2, 'data');
    }

    public function test_can_create_product()
    {
        $data = [
            'product_name' => 'New Flower',
            'product_description' => 'A beautiful new flower',
            'quantity' => 100,
            'price' => 19.99,
        ];

        $response = $this->postJson('/api/v1/products', $data);

        $response->assertCreated()
            ->assertJsonFragment(['product_name' => 'New Flower'])
            ->assertJsonFragment(['status' => 'enabled']);

        $this->assertDatabaseHas('products', ['product_name' => 'New Flower']);
    }

    public function test_create_product_validates_required_fields()
    {
        $response = $this->postJson('/api/v1/products', []);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['product_name', 'product_description', 'quantity', 'price']);
    }

    public function test_can_update_product()
    {
        $product = Product::factory()->create(['product_name' => 'Old Name', 'price' => 10.00]);

        $response = $this->putJson("/api/v1/products/{$product->id}", [
            'product_name' => 'Updated Name',
            'price' => 15.00,
        ]);

        $response->assertOk()
            ->assertJsonFragment(['product_name' => 'Updated Name']);

        $this->assertDatabaseHas('products', ['id' => $product->id, 'product_name' => 'Updated Name', 'price' => 15.00]);
    }

    public function test_update_product_validates_fields()
    {
        $product = Product::factory()->create();

        $response = $this->putJson("/api/v1/products/{$product->id}", [
            'quantity' => -1,
            'price' => -5,
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['quantity', 'price']);
    }

    public function test_can_toggle_product_status()
    {
        $product = Product::factory()->create(['status' => 'enabled']);

        $response = $this->patchJson("/api/v1/products/{$product->id}/toggle-status");

        $response->assertOk()
            ->assertJsonFragment(['status' => 'disabled']);

        $this->assertDatabaseHas('products', ['id' => $product->id, 'status' => 'disabled']);
    }

    public function test_toggle_status_twice_returns_to_enabled()
    {
        $product = Product::factory()->create(['status' => 'enabled']);

        $this->patchJson("/api/v1/products/{$product->id}/toggle-status");
        $response = $this->patchJson("/api/v1/products/{$product->id}/toggle-status");

        $response->assertOk()
            ->assertJsonFragment(['status' => 'enabled']);
    }

    public function test_returns_404_for_nonexistent_product()
    {
        $response = $this->putJson('/api/v1/products/999', ['product_name' => 'Ghost']);

        $response->assertNotFound();
    }
}
