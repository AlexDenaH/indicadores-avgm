<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DependenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dependencias = [
            [
                'nombre' => 'FISCALÍA DEL ESTADO DE JALISCO',
                'siglas' => 'FE'
            ],
            [
                'nombre' => 'RED DE CENTROS DE JUSTICIA PARA LAS MUJERES',
                'siglas' => 'REDCJM'
            ],
            [
                'nombre' => 'SECRETARÍA DE IGUALDAD SUSTANTIVA ENTRE MUJERES Y HOMBRES',
                'siglas' => 'SISMYH'
            ],
            [
                'nombre' => 'INSTITUTOS MUNICIPALES DE LAS MUJERES',
                'siglas' => 'IMM'
            ],
            [
                'nombre' => 'SECRETARÍA DE SALUD',
                'siglas' => 'SS'
            ],
            [
                'nombre' => 'CONSEJO ESTATAL PARA LA PREVENCION Y ATENCION DE LA VIOLENCIA INTRAFAMILIAR',
                'siglas' => 'CEPAVIF'
            ],
            [
                'nombre' => 'COMISION ESTATAL DE DERECHOS HUMANOS JALISCO',
                'siglas' => 'CEDHJ'
            ],
        ];

        foreach ($dependencias as $dependencia) {
            DB::table('dependencias')->insert([
                'nombre' => $dependencia['nombre'],
                'siglas' => $dependencia['siglas'],
                'activa' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}