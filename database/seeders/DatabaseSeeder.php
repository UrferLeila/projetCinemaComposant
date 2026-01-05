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
                'name'  => 'Admin',
                'email' => 'admin@ceff.ch',
                'password' => bcrypt('1234'), 
            ],
            [
                'name'  => 'Alice',
                'email' => 'alice@ceff.ch',
                'password' => bcrypt('1234'), 
            ],
            [
                'name'  => 'Bob',
                'email' => 'bob@ceff.ch',
                'password' => bcrypt('1234'), 
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
                'image'  => 'https://play-lh.googleusercontent.com/hoXWWwTBGZIdrOklQPlgtAXBtI5TDA3GqDuH-cdsABxNTM-wMVFzl8vRwctkUPs05h9iIRN-Oa68Foh_RQ',
            ],
            [
                'titre'  => 'Avatar',
                'auteur' => 'James Cameron',
                'image'  => 'https://tse2.mm.bing.net/th/id/OIP.59n-h-SQ_q3TqBkgXbsEeAHaLH?rs=1&pid=ImgDetMain&o=7&rm=3',
            ],
            [
                'titre'  => 'Demon Slayer',
                'auteur' => 'Koyoharu Gotōge',
                'image'  => 'https://media.pathe.fr/movie/alex/HO00009211/poster/lg/11/movie&uuid=D34717F6-0CFD-4D39-AC34-D50AAAE4714B',
            ],
        ]);

        Salle::factory()->create([
            'name'  => 'salle pricipal', 
        ]);

        Seance::factory()->createMany([
            [
                'date'    => '2026-01-04',
                'heure'   => '11:30',
                'salle_id' => 1,
                'film_id' => 1,
            ],
            [
                'date'    => '2026-01-04',
                'heure'   => '15:30',
                'salle_id' => 1,
                'film_id' => 1,
            ],
            [
                'date'    => '2026-01-06',
                'heure'   => '18:00',
                'salle_id' => 1,
                'film_id' => 1,
            ],

            [
                'date'    => '2026-02-15',
                'heure'   => '13:30',
                'salle_id' => 1,
                'film_id' => 2,
            ],
            [
                'date'    => '2026-02-15',
                'heure'   => '17:00',
                'salle_id' => 1,
                'film_id' => 2,
            ],
            [
                'date'    => '2026-02-17',
                'heure'   => '20:00',
                'salle_id' => 1,
                'film_id' => 2,
            ],

            [
                'date'    => '2026-03-10',
                'heure'   => '12:45',
                'salle_id' => 1,
                'film_id' => 3,
            ],
            [
                'date'    => '2026-03-10',
                'heure'   => '16:15',
                'salle_id' => 1,
                'film_id' => 3,
            ],
            [
                'date'    => '2026-03-12',
                'heure'   => '19:30',
                'salle_id' => 1,
                'film_id' => 3,
            ],

            [
                'date'    => '2026-04-02',
                'heure'   => '10:00',
                'salle_id' => 1,
                'film_id' => 4,
            ],
            [
                'date'    => '2026-04-02',
                'heure'   => '14:00',
                'salle_id' => 1,
                'film_id' => 4,
            ],
            [
                'date'    => '2026-04-04',
                'heure'   => '18:45',
                'salle_id' => 1,
                'film_id' => 4,
            ],

            [
                'date'    => '2026-05-21',
                'heure'   => '11:00',
                'salle_id' => 1,
                'film_id' => 5,
            ],
            [
                'date'    => '2026-05-21',
                'heure'   => '15:00',
                'salle_id' => 1,
                'film_id' => 5,
            ],
            [
                'date'    => '2026-05-23',
                'heure'   => '20:30',
                'salle_id' => 1,
                'film_id' => 5,
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
            ['siege_nom' => 'b1', 'reservation_id' => 2],
            ['siege_nom' => 'b13', 'reservation_id' => 2],
            ['siege_nom' => 'c8', 'reservation_id' => 2],
            ['siege_nom' => 'f5', 'reservation_id' => 2],
        ]);    
    }
}
