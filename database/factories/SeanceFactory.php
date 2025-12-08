<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Film;
use App\Models\Salle;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Seance>
 */
class SeanceFactory extends Factory

{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'date' => $this->faker->date(), 
            'heure' => $this->faker->time(),     
            'salle_id' => \App\Models\Salle::factory(),
            'film_id' => \App\Models\Film::factory(),
        ];
    }
}
