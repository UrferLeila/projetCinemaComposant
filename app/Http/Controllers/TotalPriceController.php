<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class TotalPriceController extends Controller
{
    /**
     * Display the total price of a reservation.
     */
    public function show(string $id)
    {
        // Load the reservation with related seats and prices
        $reservation = Reservation::with('reservationSieges.siege.prix')->find($id);

        // Check if reservation exists
        if (!$reservation) {
            return response()->json([
                'error' => 'Reservation not found'
            ], 404);
        }

        // Calculate total price
        $totalPrice = $reservation->totalPrice();

        // Return JSON response
        return response()->json([
            'reservation_id' => $reservation->id,
            'total_price' => $totalPrice
        ]);
    }
}
