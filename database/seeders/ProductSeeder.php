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
        $products = [
            ['name' => 'Naruto Manga Vol. 1', 'image' => null, 'price' => 9.99, 'stock_quantity' => 50],
            ['name' => 'One Piece Manga Vol. 1', 'image' => null, 'price' => 9.99, 'stock_quantity' => 45],
            ['name' => 'Dragon Ball Z Manga Vol. 1', 'image' => null, 'price' => 8.99, 'stock_quantity' => 60],
            ['name' => 'Attack on Titan Manga Vol. 1', 'image' => null, 'price' => 10.99, 'stock_quantity' => 40],
            ['name' => 'My Hero Academia Manga Vol. 1', 'image' => null, 'price' => 9.99, 'stock_quantity' => 55],
            ['name' => 'Demon Slayer Manga Vol. 1', 'image' => null, 'price' => 9.99, 'stock_quantity' => 70],
            ['name' => 'Jujutsu Kaisen Manga Vol. 1', 'image' => null, 'price' => 9.99, 'stock_quantity' => 65],
            ['name' => 'Tokyo Ghoul Manga Vol. 1', 'image' => null, 'price' => 9.99, 'stock_quantity' => 35],
            ['name' => 'Death Note Manga Vol. 1', 'image' => null, 'price' => 9.99, 'stock_quantity' => 80],
            ['name' => 'Fullmetal Alchemist Manga Vol. 1', 'image' => null, 'price' => 9.99, 'stock_quantity' => 42],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}

