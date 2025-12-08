<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seance extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'heure',
        'salle_id', //TODO: must be a key
        'film_id',
    ];

     public function film()
    {
        return $this->belongsTo(Film::class);
    }

     public function salle()
    {
        return $this->belongsTo(Salle::class);
    }
}
