<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DependenciaArea extends Model
{
    use HasFactory;

    protected $fillable = ['id_dependencia', 'unidad_area', 'activa'];

    public function dependencia()
    {
        return $this->belongsTo(Dependencia::class, 'id_dependencia');
    }
}
