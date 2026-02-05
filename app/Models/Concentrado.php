<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Concentrado extends Model
{
    protected $table = 'concentrados';

    protected $fillable = [
        'id_ejercicio',
        'id_periodo',
        'id_programa',
        'id_indicador',
        'id_dependencia',
        'id_dep_area',
        'id_detalle',
        'id_nivel_detalle',
        'id_componente',
        'subcomponente',
        'total',
        'listado_dependencia',
        'observaciones',
        'temporalidad',
        'estatus_captura'
    ];

    protected $casts = [
        'listado_dependencia' => 'array',
        'estatus_captura' => 'boolean',
    ];
}
