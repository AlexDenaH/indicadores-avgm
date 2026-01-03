<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NivelDetalle extends Model
{
    protected $table = 'nivel_detalle';

    protected $fillable = [
        'tipo',
        'nivel_detalle',
    ];

    protected $casts = [
        'nivel_detalle' => 'array', // clave para trabajar JSON como array
    ];
}
