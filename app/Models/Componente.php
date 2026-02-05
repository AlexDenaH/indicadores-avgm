<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Indicadores;

class Componente extends Model
{
    protected $fillable = [
        'id_programa',
        'id_indicador',
        'componente',
        'tiene_subcomponentes',
        'subcomponentes'
    ];

    protected $casts = [
        'tiene_subcomponentes' => 'boolean',
        'subcomponentes' => 'array'
    ];



    public function ejercicioDelPrograma()
    {
        // (Modelo Destino, Modelo Intermediario, Llave foránea en Programa, Llave foránea en Ejercicio, Llave local en Componente, Llave local en Programa)
        return $this->hasOneThrough(
            Ejercicio::class,
            Programa::class,
            'id',            // FK en programas (su propia ID)
            'id',            // FK en ejercicios (su propia ID)
            'id_programa',   // Local key en componentes
            'id_ejercicio'   // Local key en programas
        );
    }

    public function programa()
    {
        return $this->belongsTo(Programa::class, 'id_programa');
    }

    /**
     * Relación: Componente pertenece a un Indicador
     */
    public function indicadores()
    {
        return $this->belongsTo(Indicadores::class, 'id_indicador');
    }
}
