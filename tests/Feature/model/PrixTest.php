<?php

use App\Models\Prix;
use Illuminate\Foundation\Testing\RefreshDatabase;

pest()->use(RefreshDatabase::class);

describe("Prix CRUD :", function () {

    it("peut créer un nouveau type de prix", function () {
        $prix = Prix::create([
            'type' => 'Etudiant',
            'prix' => 8.50
        ]);

        $this->assertDatabaseHas('prixes', [
            'type' => 'Etudiant',
            'prix' => 8.50
        ]);

        // Vérification de la clé primaire string
        expect($prix->type)->toBe('Etudiant');
    });

    it("peut modifier la valeur d'un prix existant", function () {
    $prix = Prix::create([
        'type' => 'Adulte',
        'prix' => 15.00
    ]);

    $prix->update(['prix' => 16.00]);

    $this->assertDatabaseHas('prixes', [
        'type' => 'Adulte',
        'prix' => 16.00
    ]);
    });

    it("peut supprimer un type de prix", function () {
        $prix = Prix::create([
            'type' => 'Enfant',
            'prix' => 10.00
        ]);

        $prix->delete();

        $this->assertDatabaseMissing('prixes', [
            'type' => 'Enfant'
        ]);
    });

    it("récupère le bon prix via sa clé primaire textuelle", function () {
        Prix::create(['type' => 'Senior', 'prix' => 12.00]);

        $found = Prix::find('Senior');

        expect($found)->not->toBeNull()
            ->and($found->prix)->toEqual(12.00);
    });
});