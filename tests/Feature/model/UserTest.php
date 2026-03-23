<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

pest()->use(RefreshDatabase::class);

describe("User Model & Auth :", function () {

    it("crée un utilisateur avec un mot de passe haché", function () {
        $user = User::create([
            'name'     => 'Alice',
            'email'    => 'alice@example.com',
            'password' => 'secret123', // Sera haché via le cast 'hashed'
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'alice@example.com',
        ]);

        // Vérifie que le mot de passe n'est pas stocké en clair
        expect($user->password)->not->toBe('secret123');
        
        // Vérifie que le hachage est valide
        expect(Hash::check('secret123', $user->password))->toBeTrue();
    });

    it("ne doit pas afficher le mot de passe dans le tableau (hidden fields)", function () {
        $user = User::factory()->create([
            'password' => 'password123'
        ]);

        $userArray = $user->toArray();

        // Le mot de passe et le remember_token ne doivent pas être visibles
        expect($userArray)->not->toHaveKey('password')
            ->and($userArray)->not->toHaveKey('remember_token');
    });

    it("peut modifier le profil de l'utilisateur", function () {
        $user = User::factory()->create(['name' => 'Ancien Nom']);

        $user->update(['name' => 'Nouveau Nom']);

        $this->assertDatabaseHas('users', [
            'id'   => $user->id,
            'name' => 'Nouveau Nom'
        ]);
    });

    it("valide le format de la date email_verified_at (casting)", function () {
        $user = User::factory()->create([
            'email_verified_at' => now()
        ]);

        // Vérifie que le cast transforme la string de la DB en objet Carbon/DateTime
        expect($user->email_verified_at)->toBeInstanceOf(DateTime::class);
    });
});