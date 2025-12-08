<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Prix>
 */
class PrixFactory extends Factory
{
    public function definition(): array
    {
        $types = ['normal', 'vip'];

        return [
            'type' => $this->faker->unique()->randomElement($types),
            'prix' => $this->faker->numberBetween(5, 30),
        ];
    }
}
