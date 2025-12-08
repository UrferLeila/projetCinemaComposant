<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Film;

class FilmController extends Controller
{
    /**
     * Display a listing of all films.
     */
    public function index()
    {
        $films = Film::all(); // Get all films
        return response()->json($films, 200); // Return as JSON
    }

    /**
     * Store a newly created film in storage.
     */
    public function store(Request $request)
    {
        $film = Film::create($request->only(['titre', 'auteur', 'image']));
        return response()->json($film, 201);
    }

    /**
     * Display the specified film.
     */
    public function show(string $id)
    {
        $film = Film::find($id);

        if (!$film) {
            return response()->json(['message' => 'Film not found'], 404);
        }

        return response()->json($film, 200);
    }

    /**
     * Update the specified film in storage.
     */
    public function update(Request $request, string $id)
    {
        $film = Film::find($id);

        if (!$film) {
            return response()->json(['message' => 'Film not found'], 404);
        }

        $film->update($request->only(['titre', 'auteur', 'image']));
        return response()->json($film, 200);
    }

    /**
     * Remove the specified film from storage.
     */
    public function destroy(string $id)
    {
        $film = Film::find($id);

        if (!$film) {
            return response()->json(['message' => 'Film not found'], 404);
        }

        $film->delete();
        return response()->json(['message' => 'Film deleted'], 200);
    }
}
