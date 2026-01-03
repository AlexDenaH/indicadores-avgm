<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Periodo extends Model
{
    protected $fillable = [
        'id_ejercicio',
        'id_programa',
        'id_indicador',
        'periodo',
        'dias_inicio',
        'dias_final',
        'status',
    ];

    protected $casts = [
        'dias_inicio' => 'integer',
        'dias_final'  => 'integer',
    ];

    public const PERIODOS = [
        'diario',
        'semanal',
        'mensual',
        'trimestral',
        'anual',
    ];

  public function ejercicio()
    {
        return $this->belongsTo(Ejercicio::class, 'id_ejercicio','id');
    }

    public function programa()
    {
        return $this->belongsTo(Programa::class, 'id_programa', 'id');
    }

    public function indicadores()
    {
         return $this->belongsTo(Indicadores::class, 'id_indicador', 'id');
    }

}
