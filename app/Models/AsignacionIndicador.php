<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsignacionIndicador extends Model
{
    protected $table = 'asignacion_indicadores';

    protected $fillable = [
        'id_ejercicio',
        'id_programa',
        'id_area',
        'indicadores',
    ];

    /**
     * Convierte JSON ↔ array automáticamente
     */
    protected $casts = [
        'indicadores' => 'array',
    ];

    public function ejercicio()
    {
        return $this->belongsTo(Ejercicio::class, 'id_ejercicio');
    }

    public function programa()
    {
        return $this->belongsTo(Programa::class, 'id_programa');
    }

    public function area()
    {
        return $this->belongsTo(DependenciaArea::class, 'id_area');
    }

}
