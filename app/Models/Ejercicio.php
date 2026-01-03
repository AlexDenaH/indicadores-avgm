<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ejercicio extends Model
{
    protected $fillable = ['ejercicio', 'activo'];

    // Un ejercicio tiene muchos programas
    public function programas()
    {
        return $this->hasMany(Programa::class, 'id_ejercicio');
    }
}
