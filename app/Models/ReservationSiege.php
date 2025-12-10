<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReservationSiege extends Model
{
    use HasFactory;

    protected $fillable = [
        'siege_nom',
        'reservation_id',
    ];

    public $timestamps = false; 

    public function siege()
    {
        return $this->belongsTo(Siege::class, 'siege_nom', 'nom');
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
