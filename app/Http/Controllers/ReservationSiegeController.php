<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReservationSiege;

class ReservationSiegeController extends Controller
{
    public function index()
    {
        $reservations = ReservationSiege::with(['siege', 'reservation'])->get();
        return response()->json($reservations, 200);
    }

    public function show(ReservationSiege $reservationSiege)
    {
        $reservationSiege->load(['siege', 'reservation']);
        return response()->json($reservationSiege, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'siege_nom' => 'required|string|exists:sieges,nom',
            'reservation_id' => 'required|integer|exists:reservations,id',
        ]);

        $reservationSiege = ReservationSiege::create(
            $request->only(['siege_nom', 'reservation_id'])
        );
        return response()->json($reservationSiege, 201);
    }

    public function update(Request $request, ReservationSiege $reservationSiege)
    {
        $request->validate([
            'siege_nom' => 'sometimes|string|exists:sieges,nom',
            'reservation_id' => 'sometimes|integer|exists:reservations,id',
        ]);

        $reservationSiege->update($request->only(['siege_nom', 'reservation_id']));
        return response()->json($reservationSiege, 200);
    }

    public function destroy(ReservationSiege $reservationSiege)
    {
        $reservationSiege->delete();
        return response()->json(['message' => 'ReservationSiege deleted'], 200);
    }
}
