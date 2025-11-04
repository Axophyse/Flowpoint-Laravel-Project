<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'name' => 'Laptop',
                'price' => 999.99,
                'quantity' => 15,
                'category' => 'Electronics',
                'description' => 'High-performance laptop with SSD storage and dedicated graphics card.',
                'created_date' => Carbon::now()->subDays(10),
            ],
            [
                'name' => 'Smartphone',
                'price' => 699.99,
                'quantity' => 25,
                'category' => 'Electronics',
                'description' => 'Latest smartphone with high-resolution camera and long battery life.',
                'created_date' => Carbon::now()->subDays(5),
            ],
            [
                'name' => 'Desk Chair',
                'price' => 199.99,
                'quantity' => 30,
                'category' => 'Furniture',
                'description' => 'Ergonomic office chair with lumbar support and adjustable height.',
                'created_date' => Carbon::now()->subDays(15),
            ],
            [
                'name' => 'Coffee Mug',
                'price' => 12.99,
                'quantity' => 100,
                'category' => 'Kitchen',
                'description' => 'Ceramic coffee mug with comfortable handle and 12oz capacity.',
                'created_date' => Carbon::now()->subDays(3),
            ],
            [
                'name' => 'Notebook',
                'price' => 8.99,
                'quantity' => 50,
                'category' => 'Office',
                'description' => 'Spiral-bound notebook with 100 pages of lined paper.',
                'created_date' => Carbon::now()->subDays(7),
            ],
            [
                'name' => 'Headphones',
                'price' => 149.99,
                'quantity' => 20,
                'category' => 'Electronics',
                'description' => 'Wireless over-ear headphones with noise cancellation.',
                'created_date' => Carbon::now()->subDays(2),
            ],
            [
                'name' => 'Desk Lamp',
                'price' => 39.99,
                'quantity' => 35,
                'category' => 'Furniture',
                'description' => 'LED desk lamp with adjustable brightness and color temperature.',
                'created_date' => Carbon::now()->subDays(12),
            ],
            [
                'name' => 'Water Bottle',
                'price' => 24.99,
                'quantity' => 80,
                'category' => 'Kitchen',
                'description' => 'Insulated stainless steel water bottle, keeps drinks cold for 24 hours.',
                'created_date' => Carbon::now()->subDays(1),
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
