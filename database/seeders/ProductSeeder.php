<?php

// database/seeders/ProductSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'id' => 1,
                'name' => "beyboy t-shirt",
                'description' => 'Comfortable cotton T-shirt for daily wear.',
                'stock' => 10,
                'size' => 'M, L, XL',
                'price' => 45,
                'old_price' => 55.9,
                'category_id' => 1, // T-Shirt
                'image' => "image/t1.jpg",
                'hover_image' => "image/t1-h.jpg",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => "beyboy t-shirt",
                'description' => 'Comfortable cotton T-shirt for daily wear.',
                'stock' => 10,
                'size' => 'M, L, XL',
                'price' => 120,
                'old_price' => 140,
                'category_id' => 1, // T-Shirt
                'image' => "image/t2.jpg",
                'hover_image' => "image/t.jpg",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => "beyboy t-shirt",
                'description' => 'Comfortable cotton T-shirt for daily wear.',
                'stock' => 10,
                'size' => 'M, L, XL',
                'price' => 75,
                'old_price' => 100,
                'category_id' => 1, // T-Shirt
                'image' => "image/t3.jpg",
                'hover_image' => "image/t.jpg",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'name' => "beyboy t-shirt",
                'description' => 'Comfortable cotton T-shirt for daily wear.',
                'stock' => 10,
                'size' => 'M, L, XL',
                'price' => 89,
                'old_price' => 99,
                'category_id' => 1, // T-Shirt
                'image' => "image/t4.jpg",
                'hover_image' => "image/t4-h.jpg",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'name' => "beyboy t-shirt",
                'description' => 'Comfortable cotton T-shirt for daily wear.',
                'stock' => 10,
                'size' => 'M, L, XL',
                'price' => 89,
                'old_price' => 99,
                'category_id' => 1, // T-Shirt
                'image' => "image/t5.jpg",
                'hover_image' => "image/t5-h.jpg",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'name' => "beyboy t-shirt",
                'description' => 'Comfortable cotton T-shirt for daily wear.',
                'stock' => 10,
                'size' => 'M, L, XL',
                'price' => 89,
                'old_price' => 99,
                'category_id' => 1, // T-Shirt
                'image' => "image/t6.jpg",
                'hover_image' => "image/t6-h.jpg",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 10,
                'name' => "beyboy hoodie",
                'description' => 'Comfortable cotton T-shirt for daily wear.',
                'stock' => 10,
                'size' => 'M, L, XL',
                'price' => 89,
                'old_price' => 99,
                'category_id' => 2, // Hoodies
                'image' => "image/h1.jpg",
                'hover_image' => "image/h1-h.jpg",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 11,
                'name' => "beyboy hoodie",
                'description' => 'Comfortable cotton T-shirt for daily wear.',
                'stock' => 10,
                'size' => 'M, L, XL',
                'price' => 89,
                'old_price' => 99,
                'category_id' => 2, // Hoodies
                'image' => "image/h3.jpg",
                'hover_image' => "image/h3-h.jpg",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 12,
                'name' => "beyboy hoodie",
                'description' => 'Comfortable cotton T-shirt for daily wear.',
                'stock' => 10,
                'size' => 'M, L, XL',
                'price' => 89,
                'old_price' => 99,
                'category_id' => 2, // Hoodies
                'image' => "image/h5.jpg",
                'hover_image' => "image/h5-h.jpg",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 13,
                'name' => "beyboy hoodie",
                'description' => 'Comfortable cotton T-shirt for daily wear.',
                'stock' => 10,
                'size' => 'M, L, XL',
                'price' => 89,
                'old_price' => 99,
                'category_id' => 2, // Hoodies
                'image' => "image/h4.jpg",
                'hover_image' => "image/h4-h.jpg",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 14,
                'name' => "beyboy pants",
                'description' => 'Comfortable cotton T-shirt for daily wear.',
                'stock' => 10,
                'size' => 'M, L, XL',
                'price' => 89,
                'old_price' => 99,
                'category_id' => 3, // Pants
                'image' => "image/pa1.jpg",
                'hover_image' => "image/pa1-h.jpg",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 15,
                'name' => "accessory item",
                'description' => 'Comfortable cotton T-shirt for daily wear.',
                'stock' => 10,
                'size' => 'M, L, XL',
                'price' => 89,
                'old_price' => 99,
                'category_id' => 4, // Accessories
                'image' => "image/a.jpg",
                'hover_image' => "image/a.jpg",
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('products')->insert($products);
    }
}
