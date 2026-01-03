<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;


class Indicadores extends Model
{
    protected $fillable = [
        'id_programa',
        'indicador',
        'descripcion',
        'medicion',
        'id_detalle',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'id_detalle' => 'array',
    ];

    public function programa()
    {
        return $this->belongsTo(Programa::class, 'id_programa');
    }

    public function componentes()
    {
        return $this->hasMany(Componente::class);
    }

    public function periodos()
    {
        // El segundo parámetro es la clave foránea en la tabla 'periodos'
        // Si tu columna se llama diferente a 'indicador_id', especifícala aquí.
        return $this->hasMany(Periodo::class, 'id_indicador');
    }

    public function detalles()
    {
        if (empty($this->id_detalle)) {
            return collect();
        }

        // Convierte a colección y extrae solo ids
        $ids = collect($this->id_detalle)
            ->pluck('id')       // si tu JSON es [{id:1, orden:1}, {id:3, orden:2}]
            ->filter()
            ->values();

        if ($ids->isEmpty()) {
            return collect();
        }

        return NivelDetalle::whereIn('id', $ids)
            ->orderByRaw("FIELD(id, " . $ids->implode(',') . ")")
            ->get();
    }
}
