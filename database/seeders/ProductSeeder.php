<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Available images in public/assets/products/
        $availableImages = ['products/ada8799d-5997-5e25-98fc-c8b7af523671.jpg', 'products/9319a7ba-7002-59d4-a381-b3349f038e86.jpg', 'products/9319a7ba-7002-59d4-a381-b3349f038e86 (1).jpg', 'products/a95546d1-d028-5f2b-a9fe-c5b55c4592db.jpg', 'products/0b226c450798410ac541646c86ec31afd840e5beab817a5d84fa821e7db61981ec84c3b4a3f072a7a2e1899c9fb06c6e964db3ac70d7f02bcd1659e51bec2379ebd3b09af77c9eadcfb197c0a80625d64321f853e435a630551c4f8753bf24a8.jpeg'];

        $products = [
            ['name' => 'Naruto Manga Vol. 1', 'image' => $availableImages[0], 'price' => 9.99, 'stock_quantity' => 50],
            ['name' => 'One Piece Manga Vol. 1', 'image' => $availableImages[1], 'price' => 9.99, 'stock_quantity' => 45],
            ['name' => 'Dragon Ball Z Manga Vol. 1', 'image' => $availableImages[2], 'price' => 8.99, 'stock_quantity' => 60],
            ['name' => 'Attack on Titan Manga Vol. 1', 'image' => $availableImages[3], 'price' => 10.99, 'stock_quantity' => 40],
            ['name' => 'My Hero Academia Manga Vol. 1', 'image' => $availableImages[4], 'price' => 9.99, 'stock_quantity' => 55],
            ['name' => 'Demon Slayer Manga Vol. 1', 'image' => $availableImages[0], 'price' => 9.99, 'stock_quantity' => 70],
            ['name' => 'Jujutsu Kaisen Manga Vol. 1', 'image' => $availableImages[1], 'price' => 9.99, 'stock_quantity' => 65],
            ['name' => 'Tokyo Ghoul Manga Vol. 1', 'image' => $availableImages[2], 'price' => 9.99, 'stock_quantity' => 35],
            ['name' => 'Death Note Manga Vol. 1', 'image' => $availableImages[3], 'price' => 9.99, 'stock_quantity' => 80],
            ['name' => 'Fullmetal Alchemist Manga Vol. 1', 'image' => $availableImages[4], 'price' => 9.99, 'stock_quantity' => 42],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        $this->command->info('✓ Created ' . count($products) . ' products with images');
    }
}
