<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    protected $fillable = [
    'clave',       // clave del municipios
    'nombre',
    'clave_inegi', // clave del inegi 
    ];

    /**
     * Relación muchos a muchos con dependencias
     */
    public function dependencias()
    {
        return $this->belongsToMany(Dependencia::class)
                    ->withTimestamps();
    }
}

