<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = fake();
        return [
            'name' => $faker->sentence(3),
            'description' => $faker->text(),
            'image' => $faker->imageUrl(),
            'price' => $faker->randomFloat(2, 10, 100),
            'discount_price' => $faker->optional()->randomFloat(2, 5, 50),
            'quantity' => $faker->randomNumber(2),
        ];
    }
}
