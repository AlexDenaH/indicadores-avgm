<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Programa extends Model
{
    protected $fillable = ['programa', 'id_ejercicio', 'activo'];

    public function ejercicio()
    {
        return $this->belongsTo(Ejercicio::class, 'id_ejercicio');
    }

    public function indicadores()
    {
        return $this->hasMany(Indicadores::class, 'id_programa');
    }
}
