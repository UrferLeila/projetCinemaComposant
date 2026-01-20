<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'seance_id',
    ];

    // --------------------------
    // Relationships
    // --------------------------

    // Reservation belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Reservation belongs to a seance
    public function seance()
    {
        return $this->belongsTo(Seance::class);
    }

    // Reservation has many seats (ReservationSiege)
    public function reservationSieges()
    {
        return $this->hasMany(ReservationSiege::class);
    }

    // --------------------------
    // Methods
    // --------------------------

    // Calculate the total price of the reservation
    public function totalPrice(): float
{
    return (float) $this->reservationSieges->sum(function($reservationSiege) {
        return $reservationSiege->siege->prix->prix ?? 0; // use 'prix' column
    });
}

}
