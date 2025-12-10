<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prix extends Model
{
    use HasFactory;

    protected $primaryKey = 'type'; 
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'type',
        'prix',
    ];

    public function sieges()
    {
        return $this->hasMany(Siege::class, 'prix_type', 'type');
    }
}
