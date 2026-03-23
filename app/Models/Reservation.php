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
  
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    public function seance()
    {
        return $this->belongsTo(Seance::class);
    }

    public function reservationSieges()
    {
        return $this->hasMany(ReservationSiege::class);
    }

    public function totalPrice(): float
    {
        return (float) $this->reservationSieges->sum(function ($reservationSiege) {
            return $reservationSiege->siege->prix->prix ?? 0; 
        });
    }

}
