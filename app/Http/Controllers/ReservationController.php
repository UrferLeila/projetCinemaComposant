<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\ReservationSiege;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'seance_id' => 'required|exists:seances,id',
            'seats' => 'required|array|min:1',
        ]);
        $seats = $request->seats;

        $alreadyBooked = ReservationSiege::whereHas('reservation', function ($q) use ($request) {
            $q->where('seance_id', $request->seance_id);
        })->whereIn('siege_nom', $seats)->pluck('siege_nom')->toArray();

        if (!empty($alreadyBooked)) {
            return response()->json([
                'success' => false,
                'message' => 'Les sièges suivants sont déjà réservés: ' . implode(', ', $alreadyBooked)
            ], 409);
        }

        DB::beginTransaction();
        try {
            $reservation = Reservation::create([
                'user_id' => Auth::id(),
                'seance_id' => $request->seance_id,
            ]);

            foreach ($seats as $seatNom) {
                ReservationSiege::create([
                    'siege_nom' => $seatNom,
                    'reservation_id' => $reservation->id,
                ]);
            }

            DB::commit();
            return response()->json(['success' => true, 'reservation' => $reservation], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Erreur lors de la réservation.'], 500);
        }
    }

    public function index()
    {
        $reservations = Reservation::with('seance', 'user', 'reservationSieges')->where('user_id', Auth::id())->get();
        return response()->json($reservations, 200);
    }

    public function show($id)
    {
        $reservation = Reservation::with('seance', 'user', 'reservationSieges')->findOrFail($id);
        return response()->json($reservation, 200);
    }

    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->reservationSieges()->delete();
        $reservation->delete();
        return response()->json(['success' => true, 'message' => 'Réservation supprimée'], 200);
    }
}
