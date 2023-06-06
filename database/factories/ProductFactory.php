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
        $category_id = fake()->numberBetween(1, 2);
        $brand_id = fake()->numberBetween(1, 2);

        return [
            'category_id' => $category_id,
            'brand_id' => $brand_id,
            'name' => $this->faker->product($category_id, $brand_id),
            'description' => $this->faker->description($category_id, $brand_id),
            'price' => fake()->numberBetween(1_000, 5_000)
        ];
    }
}
