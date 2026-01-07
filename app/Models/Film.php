<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Film extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre',
        'auteur',
        'image',
    ];

    public function seances()
    {
        return $this->hasMany(Seance::class);
    }
 protected static function booted()
    {
        static::deleting(function ($film) {
            foreach ($film->seances as $seance) {
                foreach ($seance->reservations as $reservation) {
                    $reservation->reservationSieges()->delete();
                    $reservation->delete();
                }

                $seance->delete();
            }
        });
    }
}
