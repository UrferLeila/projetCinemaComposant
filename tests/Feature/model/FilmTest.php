<?php

use App\Models\Film;
use Illuminate\Foundation\Testing\RefreshDatabase;

pest()->use(RefreshDatabase::class);

describe("Films :", function () {

   it("confirme que le seeder génère 5 films", function () {
        $this->seed();
        $this->assertDatabaseCount("films", 5);
    });

    it("ajoute un film avec succès", function () {
        $this->seed(); // On part de 5 films

        Film::factory()->create([
            "titre" => "Red One",
            "auteur" => "Me",
            "image" => "https://example.com/image.jpg",
        ]);

        $this->assertDatabaseCount("films", 6);
        $this->assertDatabaseHas("films", ["titre" => "Red One"]);
    });

    it("supprime un film avec succès", function () {
        $this->seed();
        
        $film = Film::first();
        $film->delete();

        $this->assertDatabaseCount("films", 4);
        $this->assertDatabaseMissing("films", ["id" => $film->id]);
    });

    it("modifie un film avec succès", function () {
        $this->seed();
        $film = Film::first();

        $film->update([
            'titre' => 'Titre Modifié'
        ]);

        $this->assertDatabaseHas("films", [
            "id" => $film->id,
            "titre" => "Titre Modifié"
        ]);
    });
});