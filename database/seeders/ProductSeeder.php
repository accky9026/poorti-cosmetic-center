<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => 'Radiant Glow Face Cream', 'category' => 'Skincare', 'brand' => 'Lakme', 'price' => 349, 'discount_price' => 299, 'stock' => 40, 'description' => 'Lightweight daily moisturizer for a natural glow, suitable for all skin types.', 'is_featured' => true],
            ['name' => 'Matte Finish Liquid Lipstick', 'category' => 'Makeup', 'brand' => 'Maybelline', 'price' => 449, 'discount_price' => 399, 'stock' => 60, 'description' => 'Long-lasting, transfer-proof matte lipstick available in 12 shades.', 'is_featured' => true],
            ['name' => 'Herbal Anti-Dandruff Shampoo', 'category' => 'Haircare', 'brand' => 'Himalaya', 'price' => 199, 'discount_price' => null, 'stock' => 80, 'description' => 'Gentle herbal shampoo that controls dandruff and nourishes the scalp.', 'is_featured' => false],
            ['name' => 'Rose Water Toner', 'category' => 'Skincare', 'brand' => 'Biotique', 'price' => 149, 'discount_price' => 129, 'stock' => 100, 'description' => 'Pure rose water toner that refreshes and tightens pores.', 'is_featured' => false],
            ['name' => 'Eau De Parfum - Blossom', 'category' => 'Fragrance', 'brand' => 'Nykaa', 'price' => 899, 'discount_price' => 749, 'stock' => 25, 'description' => 'Floral fruity fragrance with 8-hour long-lasting effect.', 'is_featured' => true],
            ['name' => 'Kajal Waterproof Twin Pack', 'category' => 'Makeup', 'brand' => 'Lakme', 'price' => 129, 'discount_price' => null, 'stock' => 90, 'description' => 'Smudge-proof, waterproof kohl kajal, pack of 2.', 'is_featured' => false],
            ['name' => 'Aloe Vera Gel', 'category' => 'Skincare', 'brand' => 'Patanjali', 'price' => 99, 'discount_price' => 85, 'stock' => 120, 'description' => '99% pure aloe vera gel for skin & hair care.', 'is_featured' => false],
            ['name' => 'Argan Hair Serum', 'category' => 'Haircare', 'brand' => 'WOW', 'price' => 349, 'discount_price' => 299, 'stock' => 55, 'description' => 'Smoothens frizzy hair and adds shine with argan oil.', 'is_featured' => true],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
