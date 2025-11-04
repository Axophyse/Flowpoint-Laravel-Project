<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SaleSeeder extends Seeder
{
    public function run()
    {
        $products = Product::all();

        foreach ($products as $product) {
            // Create 2-5 sales for each product
            $saleCount = rand(2, 5);

            for ($i = 0; $i < $saleCount; $i++) {
                $quantitySold = rand(1, min(5, $product->quantity));
                $unitPrice = $product->price;
                $totalAmount = $quantitySold * $unitPrice;

                Sale::create([
                    'sale_number' => Sale::generateSaleNumber(),
                    'product_id' => $product->id,
                    'quantity_sold' => $quantitySold,
                    'unit_price' => $unitPrice,
                    'total_amount' => $totalAmount,
                    'customer_name' => $this->generateCustomerName(),
                    'customer_email' => $this->generateCustomerEmail(),
                    'customer_phone' => $this->generateCustomerPhone(),
                    'payment_method' => $this->getRandomPaymentMethod(),
                    'status' => 'completed',
                    'sale_date' => Carbon::now()->subDays(rand(1, 30)),
                    'notes' => rand(0, 1) ? 'Customer was satisfied with the product.' : null,
                ]);

                // Update product quantity
                $product->quantity -= $quantitySold;
                $product->save();
            }
        }
    }

    private function generateCustomerName(): string
    {
        $firstNames = ['John', 'Jane', 'Michael', 'Sarah', 'David', 'Lisa', 'Robert', 'Emily', 'William', 'Jessica'];
        $lastNames = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Rodriguez', 'Martinez'];

        return $firstNames[array_rand($firstNames)] . ' ' . $lastNames[array_rand($lastNames)];
    }

    private function generateCustomerEmail(): string
    {
        $domains = ['gmail.com', 'yahoo.com', 'hotmail.com', 'outlook.com'];
        $name = strtolower(str_replace(' ', '.', $this->generateCustomerName()));
        return $name . '@' . $domains[array_rand($domains)];
    }

    private function generateCustomerPhone(): string
    {
        return '+1-' . rand(200, 999) . '-' . rand(200, 999) . '-' . rand(1000, 9999);
    }

    private function getRandomPaymentMethod(): string
    {
        $methods = ['cash', 'card', 'transfer', 'digital'];
        return $methods[array_rand($methods)];
    }
}
