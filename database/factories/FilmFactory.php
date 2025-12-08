<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Film;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Film>
 */
class FilmFactory extends Factory
{
    protected $model = Film::class;

    public function definition(): array
    {
        return [
            'titre' => $this->faker->sentence(3), // random title
            'auteur' => $this->faker->name(),     // random author/director
            'image' => $this->faker->imageUrl(),  // random image URL
        ];
    }
}
