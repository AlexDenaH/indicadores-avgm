<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Indicadores;

class Componente extends Model
{
    protected $fillable = [
        'id_indicador',
        'componente',
        'tiene_subcomponentes',
        'subcomponentes'
    ];

    protected $casts = [
        'tiene_subcomponentes' => 'boolean',
        'subcomponentes' => 'array'
    ];

    
    /**
     * Relación: Componente pertenece a un Indicador
     */
    public function indicadores()
    {
        return $this->belongsTo(Indicadores::class, 'id_indicador');
    }
}