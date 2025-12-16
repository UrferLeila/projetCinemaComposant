<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Seance;
use App\Models\User;

class ReservationFactory extends Factory
{
    public function definition(): array
    {
         return [
            'user_id' => User::factory(),
            'seance_id' => Seance::factory(),
        ];
    }
}
