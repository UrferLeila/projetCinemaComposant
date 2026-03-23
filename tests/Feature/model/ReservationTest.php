<?php

use App\Models\Reservation;
use App\Models\ReservationSiege;
use App\Models\Siege;
use Illuminate\Foundation\Testing\RefreshDatabase;

pest()->use(RefreshDatabase::class);

describe("ReservationSiege CRUD & Relations :", function () {

    it("peut lier un siège à une réservation", function () {
        // Préparation des données parentes
        $reservation = Reservation::factory()->create();
        $siege = Siege::factory()->create(['nom' => 'A1']);

        // Action
        $lien = ReservationSiege::create([
            'siege_nom' => 'A1',
            'reservation_id' => $reservation->id,
        ]);

        // Assertions
        $this->assertDatabaseHas('reservation_sieges', [
            'siege_nom' => 'A1',
            'reservation_id' => $reservation->id,
        ]);

        expect($lien->siege_nom)->toBe('A1');
    });

    it("accède correctement au modèle Siege lié", function () {
        $siege = Siege::factory()->create(['nom' => 'B10']);
        $reservation = Reservation::factory()->create();

        $pivot = ReservationSiege::create([
            'siege_nom' => $siege->nom,
            'reservation_id' => $reservation->id,
        ]);

        // Test de la relation belongsTo
        expect($pivot->siege)->toBeInstanceOf(Siege::class)
            ->and($pivot->siege->nom)->toBe('B10');
    });

    it("accède correctement à la Réservation liée", function () {
        // 1. On crée d'abord le siège parent
        Siege::factory()->create(['nom' => 'A1']);

        // 2. On crée la réservation parente
        $reservation = Reservation::factory()->create();

        // 3. Maintenant on peut créer le lien
        $pivot = ReservationSiege::create([
            'siege_nom' => 'A1',
            'reservation_id' => $reservation->id,
        ]);

        expect($pivot->reservation)->toBeInstanceOf(Reservation::class)
            ->and($pivot->reservation->id)->toBe($reservation->id);
    });

    it("supprime le lien sans supprimer le siège ou la réservation", function () {
        $siege = Siege::factory()->create(['nom' => 'D1']);
        $res = Reservation::factory()->create();
        $pivot = ReservationSiege::create(['siege_nom' => 'D1', 'reservation_id' => $res->id]);

        $pivot->delete();

        // Le lien est mort
        $this->assertDatabaseMissing('reservation_sieges', ['id' => $pivot->id]);
        // Mais les parents existent toujours
        $this->assertDatabaseHas('sieges', ['nom' => 'D1']);
        $this->assertDatabaseHas('reservations', ['id' => $res->id]);
    });
});