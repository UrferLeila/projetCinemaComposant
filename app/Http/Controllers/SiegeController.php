<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siege;

class SiegeController extends Controller
{
    public function index()
    {
        $sieges = Siege::with(['prix', 'salle'])->get();
        return response()->json($sieges, 200);
    }

    public function show(Siege $siege)
    {
        $siege->load(['prix', 'salle']);
        return response()->json($siege, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|unique:sieges,nom',
            'prix_type' => 'required|string|exists:prix,type',
            'salle_id' => 'required|integer|exists:salles,id',
        ]);

        $siege = Siege::create($request->only(['nom', 'prix_type', 'salle_id']));
        return response()->json($siege, 201);
    }

    public function update(Request $request, Siege $siege)
    {
        $request->validate([
            'prix_type' => 'sometimes|string|exists:prix,type',
            'salle_id' => 'sometimes|integer|exists:salles,id',
        ]);

        $siege->update($request->only(['prix_type', 'salle_id']));
        return response()->json($siege, 200);
    }

    public function destroy(Siege $siege)
    {
        $siege->delete();
        return response()->json(['message' => 'Siege deleted'], 200);
    }
}
