<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Film;
use App\Models\Salle;

class SeanceFactory extends Factory

{
    public function definition(): array
    {
        return [
            'date' => $this->faker->date(), 
            'heure' => $this->faker->time(),     
            'salle_id' => Salle::factory(),
            'film_id' => Film::factory(),
        ];
    }
}
