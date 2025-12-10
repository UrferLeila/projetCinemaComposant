<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seance;
use App\Models\ReservationSiege;
use App\Models\Siege;

class SeanceController extends Controller
{
    public function index()
    {
        $seances = Seance::with(['film', 'salle'])->get(); // include relationships
        return response()->json($seances, 200);
    }

    public function show(string $id)
    {
        $seance = Seance::with(['film', 'salle'])->find($id);

        if (!$seance) {
            return response()->json(['message' => 'Seance not found'], 404);
        }

        return response()->json($seance, 200);
    }

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

    public function destroy(string $id)
    {
        $seance = Seance::find($id);
        if (!$seance) {
            return response()->json(['message' => 'Seance not found'], 404);
        }

        $seance->delete();
        return response()->json(['message' => 'Seance deleted'], 200);
    }

    public function seats(string $id)
    {
        $seance = Seance::with('salle.sieges')->findOrFail($id);

        $sieges = $seance->salle->sieges;

        // Récupère les sièges déjà réservés pour cette séance
        $reservedSieges = ReservationSiege::whereIn('reservation_id', function($query) use ($id) {
            $query->select('id')
                ->from('reservations')
                ->where('seance_id', $id);
        })->pluck('siege_nom')->toArray();

        // Ajoute un champ `occupied` à chaque siège
        $sieges = $sieges->map(function($siege) use ($reservedSieges) {
            $siege->occupied = in_array($siege->nom, $reservedSieges);
            return $siege;
        });

        return response()->json($sieges);
    }
}
