<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dependencia extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'siglas', 'activa','tipo_dependencia'];

    public function areas()
    {
        return $this->hasMany(DependenciaArea::class, 'id_dependencia');
    }
}
