<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NumberFeature>
 */
class NumberFeatureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'target' => $this->faker->numberBetween(1,100),
            'upper_limit' => $this->faker->numberBetween(1,100),
            'lower_limit' => $this->faker->numberBetween(2,99),
            'description' => $this->faker->paragraph()
        ];
    }
}
