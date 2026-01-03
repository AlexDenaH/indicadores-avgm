<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /*
    | Campos asignables
    */
    protected $fillable = [
        'name',
        'first_last_name',
        'second_last_name',
        'email',
        'password',
        'id_dependencia',
        'id_dep_area',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /*
    | Accesor nombre completo
    */
    public function getNombreCompletoAttribute(): string
    {
        return trim("{$this->name} {$this->first_last_name} {$this->second_last_name}");
    }

    /*
    | Relaciones
    */
    public function dependencia()
    {
        return $this->belongsTo(Dependencia::class, 'id_dependencia');
    }

    public function area()
    {
        return $this->belongsTo(DependenciaArea::class, 'id_dep_area');
    }
}
