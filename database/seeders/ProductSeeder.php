<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['product_name' => 'Red Rose', 'product_description' => 'Classic long-stem red roses, perfect for romance.', 'quantity' => 50, 'price' => 49.99],
            ['product_name' => 'White Lily', 'product_description' => 'Elegant white lilies with a sweet fragrance.', 'quantity' => 30, 'price' => 39.99],
            ['product_name' => 'Sunflower Bouquet', 'product_description' => 'Bright and cheerful sunflowers.', 'quantity' => 40, 'price' => 29.99],
            ['product_name' => 'Pink Tulip', 'product_description' => 'Soft pink tulips in a bundle of 12.', 'quantity' => 35, 'price' => 34.99],
            ['product_name' => 'Purple Orchid', 'product_description' => 'Exotic purple orchid in a ceramic pot.', 'quantity' => 15, 'price' => 59.99],
            ['product_name' => 'Mixed Daisy', 'product_description' => 'Colorful mixed daisies for any occasion.', 'quantity' => 45, 'price' => 24.99],
            ['product_name' => 'Lavender Bundle', 'product_description' => 'Dried lavender bundle for a calming aroma.', 'quantity' => 25, 'price' => 19.99],
            ['product_name' => 'Yellow Chrysanthemum', 'product_description' => 'Bright yellow chrysanthemums.', 'quantity' => 40, 'price' => 22.99],
            ['product_name' => 'Blue Hydrangea', 'product_description' => 'Full blue hydrangea blooms.', 'quantity' => 20, 'price' => 44.99],
            ['product_name' => 'Peony Pink', 'product_description' => 'Lush pink peonies, garden fresh.', 'quantity' => 25, 'price' => 54.99],
            ['product_name' => 'Baby Breath Bunch', 'product_description' => 'Delicate baby breath flowers for accents.', 'quantity' => 60, 'price' => 14.99],
            ['product_name' => 'Carnation Collection', 'product_description' => 'Assorted carnations in vibrant colors.', 'quantity' => 50, 'price' => 19.99],
            ['product_name' => 'Tropical Bird', 'product_description' => 'Exotic bird of paradise flowers.', 'quantity' => 10, 'price' => 69.99],
            ['product_name' => 'Cherry Blossom', 'product_description' => 'Pink cherry blossom branches.', 'quantity' => 20, 'price' => 64.99],
            ['product_name' => 'Wildflower Mix', 'product_description' => 'A rustic mix of wildflowers.', 'quantity' => 35, 'price' => 27.99],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
