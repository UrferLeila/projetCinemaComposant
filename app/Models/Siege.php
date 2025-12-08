<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siege extends Model
{
    use HasFactory;

    protected $primaryKey = 'nom'; // string primary key
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'nom',
        'prix_type',
        'salle_id',
    ];

    // Relation to Prix
    public function prix()
    {
        return $this->belongsTo(Prix::class, 'prix_type', 'type');
    }

    // Relation to Salle
    public function salle()
    {
        return $this->belongsTo(Salle::class, 'salle_id', 'id');
    }
}
