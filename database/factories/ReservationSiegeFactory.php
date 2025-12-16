<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Siege;
use App\Models\Reservation;

class ReservationSiegeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'siege_nom' => function () {
                return Siege::inRandomOrder()->first()->nom ?? Siege::factory()->create()->nom;
            },
            'reservation_id' => function () {
                return Reservation::inRandomOrder()->first()->id ?? Reservation::factory()->create()->id;
            },
        ];
    }
}
