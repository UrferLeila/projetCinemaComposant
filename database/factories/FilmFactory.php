<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Film;

class FilmFactory extends Factory
{
    protected $model = Film::class;

    public function definition(): array
    {
        return [
            'titre' => $this->faker->sentence(3), 
            'auteur' => $this->faker->name(),     
            'image' => $this->faker->imageUrl(),  
        ];
    }
}
