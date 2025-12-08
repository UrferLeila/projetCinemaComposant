<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Film;
use App\Models\Seance;
use App\Models\Reservation;
use App\Models\Prix;
use App\Models\Salle;
use App\Models\Siege;
use App\Models\ReservationSiege;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->createMany([
            [
            'name'  => 'Alice',
            'email' => 'alice@ceff.ch',
            'password' => '1234',
            ],

            [
            'name'  => 'Bob',
            'email' => 'bob@ceff.ch',
            'password' => '1234',
            ],
        ]);

        Film::factory()->createMany([
            [
                'titre'  => 'Inception',
                'auteur' => 'Christopher Nolan',
                'image'  => 'https://example.com/images/inception.jpg',
            ],
            [
                'titre'  => 'Interstellar',
                'auteur' => 'Christopher Nolan',
                'image'  => 'https://example.com/images/interstellar.jpg',
            ],
            [
                'titre'  => 'The Dark Knight',
                'auteur' => 'Christopher Nolan',
                'image'  => 'https://example.com/images/dark-knight.jpg',
            ],
        ]);

        Salle::factory()->create([
        
            'name'  => 'salle pricipal', 

        ]);

        Seance::factory()->createMany([
            [
                'date'    => '2026-01-04',
                'heure'   => '11:30',
                'salle_id'   => 1,
                'film_id' => 1,
            ],
            [
                'date'    => '2026-01-04',
                'heure'   => '15:30',
                'salle_id'   => 1,
                'film_id' => 1,
            ],
            [
                'date'    => '2026-02-15',
                'heure'   => '13:30',
                'salle_id'   => 1,
                'film_id' => 2,
            ],
        ]);  

        Reservation::factory()->createMany([
            [
                'user_id'  => 1,
                'seance_id'  => 1, 
            ],
            [
                'user_id'  => 1,
                'seance_id'  => 2, 
            ],
            [
                'user_id'  => 2,
                'seance_id'  => 3, 
            ],
        ]);

        Prix::truncate();

        Prix::factory()->createMany([
            ['type' => 'normal', 'prix' => 10.25],
            ['type' => 'vip', 'prix' => 15.50],
        ]);

        Siege::factory()->createMany([
            ['nom' => 'a1', 'prix_type' => 'normal', 'salle_id' => 1],
            ['nom' => 'a2', 'prix_type' => 'normal', 'salle_id' => 1],
            ['nom' => 'b1', 'prix_type' => 'vip', 'salle_id' => 1],
            ['nom' => 'b2', 'prix_type' => 'vip', 'salle_id' => 1],
        ]); 

        ReservationSiege::factory()->createMany([
            ['siege_nom' => 'a1', 'reservation_id' => 1],
            ['siege_nom' => 'a2', 'reservation_id' => 2],
            ['siege_nom' => 'b1', 'reservation_id' => 3],
           
        ]);    
    }
}
