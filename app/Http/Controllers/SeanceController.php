<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seance;

class SeanceController extends Controller
{
    // List all seances
    public function index()
    {
        $seances = Seance::with(['film', 'salle'])->get(); // include relationships
        return response()->json($seances, 200);
    }

    // Show a specific seance
    public function show(string $id)
    {
        $seance = Seance::with(['film', 'salle'])->find($id);

        if (!$seance) {
            return response()->json(['message' => 'Seance not found'], 404);
        }

        return response()->json($seance, 200);
    }

    // Create a new seance
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'heure' => 'required',
            'salle_id' => 'required|integer|exists:salles,id',
            'film_id' => 'required|integer|exists:films,id',
        ]);

        $seance = Seance::create($request->only(['date', 'heure', 'salle_id', 'film_id']));
        return response()->json($seance, 201);
    }

    // Update an existing seance
    public function update(Request $request, string $id)
    {
        $seance = Seance::find($id);
        if (!$seance) {
            return response()->json(['message' => 'Seance not found'], 404);
        }

        $request->validate([
            'date' => 'sometimes|date',
            'heure' => 'sometimes',
            'salle_id' => 'sometimes|integer|exists:salles,id',
            'film_id' => 'sometimes|integer|exists:films,id',
        ]);

        $seance->update($request->only(['date', 'heure', 'salle_id', 'film_id']));
        return response()->json($seance, 200);
    }

    // Delete a seance
    public function destroy(string $id)
    {
        $seance = Seance::find($id);
        if (!$seance) {
            return response()->json(['message' => 'Seance not found'], 404);
        }

        $seance->delete();
        return response()->json(['message' => 'Seance deleted'], 200);
    }
}
