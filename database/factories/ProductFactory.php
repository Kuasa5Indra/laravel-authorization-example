<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Item '.$this->faker->randomNumber(),
            'price' => $this->faker->numberBetween(1000, 20000)
        ];
    }
}
