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
                'titre'  => 'Twilight',
                'auteur' => 'Stephenie Meyer',
                'image'  => 'https://themonitormmc.com/wp-content/uploads/2021/01/twilight.jpg',
            ],
            [
                'titre'  => "Harry Potter",
                'auteur' => 'JK Rowling',
                'image'  => 'https://media.posterstore.com/site_images/68631db092c536b9cc92b06f_775081888_WB0101-5.jpg',
            ],
            [
                'titre'  => 'Jurassic world Rebith',
                'auteur' => 'Gareth Edwards',
                'image'  => 'https://m.media-amazon.com/images/S/pv-target-images/414f6b00ca574fdc273a693daffd721abc71c5ee49b28253853916ddbd550a69.jpg',
            ],
            [
                'titre'  => 'Avatar',
                'auteur' => 'James Cameron',
                'image'  => 'https://tse2.mm.bing.net/th/id/OIP.59n-h-SQ_q3TqBkgXbsEeAHaLH?rs=1&pid=ImgDetMain&o=7&rm=3',
            ],
            [
                'titre'  => 'Les gardien de la galaxie',
                'auteur' => 'Jsp',
                'image'  => 'https://fr.web.img5.acsta.net/pictures/14/08/04/15/09/405662.jpg',
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
            ['type' => 'normal', 'prix' => 20],
            ['type' => 'vip', 'prix' => 45],
        ]);

        Siege::factory()->createMany([
            
                ['nom' => 'a1', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'a2', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'a3', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'a4', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'a5', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'a6', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'a7', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'a8', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'a9', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'a10', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'a11', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'a12', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'a13', 'prix_type' => 'normal', 'salle_id' => 1],

                ['nom' => 'b1', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'b2', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'b3', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'b4', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'b5', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'b6', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'b7', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'b8', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'b9', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'b10', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'b11', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'b12', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'b13', 'prix_type' => 'normal', 'salle_id' => 1],

                ['nom' => 'c1', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'c2', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'c3', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'c4', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'c5', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'c6', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'c7', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'c8', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'c9', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'c10', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'c11', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'c12', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'c13', 'prix_type' => 'normal', 'salle_id' => 1],

                 ['nom' => 'd1', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'd2', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'd3', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'd4', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'd5', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'd6', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'd7', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'd8', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'd9', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'd10', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'd11', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'd12', 'prix_type' => 'normal', 'salle_id' => 1],
                ['nom' => 'd13', 'prix_type' => 'normal', 'salle_id' => 1],
          
                ['nom' => 'e1', 'prix_type' => 'vip', 'salle_id' => 1],
                ['nom' => 'e2', 'prix_type' => 'vip', 'salle_id' => 1],
                ['nom' => 'e3', 'prix_type' => 'vip', 'salle_id' => 1],
                ['nom' => 'e4', 'prix_type' => 'vip', 'salle_id' => 1],
                ['nom' => 'e5', 'prix_type' => 'vip', 'salle_id' => 1],
                ['nom' => 'e6', 'prix_type' => 'vip', 'salle_id' => 1],
                ['nom' => 'e7', 'prix_type' => 'vip', 'salle_id' => 1],
                      
                ['nom' => 'f1', 'prix_type' => 'vip', 'salle_id' => 1],
                ['nom' => 'f2', 'prix_type' => 'vip', 'salle_id' => 1],
                ['nom' => 'f3', 'prix_type' => 'vip', 'salle_id' => 1],
                ['nom' => 'f4', 'prix_type' => 'vip', 'salle_id' => 1],
                ['nom' => 'f5', 'prix_type' => 'vip', 'salle_id' => 1],
                ['nom' => 'f6', 'prix_type' => 'vip', 'salle_id' => 1],
                ['nom' => 'f7', 'prix_type' => 'vip', 'salle_id' => 1],

        ]); 

        ReservationSiege::factory()->createMany([
            ['siege_nom' => 'a1', 'reservation_id' => 1],
            ['siege_nom' => 'a2', 'reservation_id' => 2],
            ['siege_nom' => 'b1', 'reservation_id' => 3],
           
        ]);    
    }
}
