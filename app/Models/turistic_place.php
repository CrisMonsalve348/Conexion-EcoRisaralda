<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TuristicPlace extends Model
{
    use HasFactory;

    // Nombre de la tabla (porque no es plural como Laravel espera)
    protected $table = 'turistic_place';

    // Campos que se pueden asignar masivamente (fillable)
    protected $fillable = [
        'name',
        'slogan',
        'cover',
        'description',
        'localization',
        'Weather',
        'Weather_img',
        'flora',
        'flora_img',
        'estructure',
        'estructure_img',
        'tips',
        'user_id'
    ];

    // Relación con usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
