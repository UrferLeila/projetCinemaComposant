<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Prix;
use App\Models\Salle;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Siege>
 */
class SiegeFactory extends Factory
{
    public function definition(): array
    {
        $prix = Prix::inRandomOrder()->first() ?? Prix::factory()->create();
        $salle = Salle::inRandomOrder()->first() ?? Salle::factory()->create();

        return [
            'nom' => $this->faker->unique()->word, // string PK
            'prix_type' => $prix->type,
            'salle_id' => $salle->id,
        ];
    }
}
