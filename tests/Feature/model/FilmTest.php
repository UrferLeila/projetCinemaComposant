<?php

use App\Models\Film;
use Illuminate\Foundation\Testing\RefreshDatabase;

pest()->use(RefreshDatabase::class);

describe("Films :", function () {
    it("Controler que nous avons 5 films", function () {

        /** @var \Tests\TestCase $this */

        $this->seed();

        $this->assertDatabaseCount("films", 5);
    });

    it("un film a bien été ajouter", function () {

        /** @var \Tests\TestCase $this */

        Film::factory()->create([
            "titre" => "Red One",
            "auteur" => "Me",
            "image" => "https://www.cinemaroyal.ch/storage/app/resources/resize/539_762_0_0_auto/img_913c605a101eb6172a3c2cd4bd85ac4f.jpg",
        ]);

        $this->seed();

        $this->assertDatabaseCount("films", 6);
    });

    it("un film a bien été Suprimer", function () {

        /** @var \Tests\TestCase $this */

        $this->seed();

        $film = Film::first();

        $film->delete();

        $film-> 

        $this->seed();

        $this->assertDatabaseCount("films", 4);
    });

    it("un film a bien été modifer", function () {

        /** @var \Tests\TestCase $this */
       

        $this->seed();

        $this->assertDatabaseCount("films", 6);
    });
});