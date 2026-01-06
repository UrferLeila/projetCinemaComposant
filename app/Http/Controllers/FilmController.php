<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Film;

class FilmController extends Controller
{
    public function index()
    {
        $films = Film::all();
        return response()->json($films, 200);
    }

    public function show(string $id)
    {
        $film = Film::with('seances')->find($id);

        if (!$film) {
            return response()->json(['message' => 'Film not found'], 404);
        }

        return response()->json($film, 200);
    }

    public function store(Request $request)
    {
        $film = Film::create($request->only(['titre', 'auteur', 'image']));
        return response()->json($film, 201);
    }

    public function update(Request $request, string $id)
    {
        $film = Film::find($id);
        if (!$film) {
            return response()->json(['message' => 'Film not found'], 404);
        }
        $film->update($request->only(['titre', 'auteur', 'image']));
        return response()->json($film, 200);
    }

   public function destroy($id)
{
    $film = Film::find($id);

    if (!$film) {
        return response()->json(['message' => 'Film not found'], 404);
    }

    $film->delete(); // will delete all seances and their reservations automatically

    return response()->json(['message' => 'Film and all related seances/reservations deleted successfully.']);
}

}
