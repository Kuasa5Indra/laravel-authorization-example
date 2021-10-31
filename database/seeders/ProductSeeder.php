<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::insert([
            ['name' => 'Item 1', 'price' => 2000],
            ['name' => 'Item 2', 'price' => 4000],
            ['name' => 'Item 3', 'price' => 6000],
            ['name' => 'Item 4', 'price' => 8000],
            ['name' => 'Item 5', 'price' => 10000],
        ]);
    }
}
