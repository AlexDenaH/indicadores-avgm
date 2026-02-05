<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('concentrados', function (Blueprint $table) {
            // 1. Agregar nuevos campos
            $table->json('listado_dependencia')->nullable()->after('total');
            $table->longText('observaciones')->nullable()->after('listado_dependencia');
            $table->string('temporalidad')->after('observaciones');
            $table->boolean('estatus_captura')->default(1)->after('temporalidad'); // 1 abierta / 0 cerrada

            // 2. Renombrar id_municipio a id_detalle (Si existe)
            if (Schema::hasColumn('concentrados', 'id_municipio')) {
                $table->renameColumn('id_municipio', 'id_detalle');
            } else {
                $table->unsignedBigInteger('id_detalle')->after('id_dep_area');
            }

            // 3. Agregar id_nivel_detalle
            $table->unsignedBigInteger('id_nivel_detalle')->after('id_detalle');

                        // Evita duplicados
            $table->unique([
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
                'temporalidad'
            ], 'uniq_concentrado');
        });
    }

    public function down(): void
    {
        Schema::table('concentrados', function (Blueprint $table) {
            // Revertir los cambios en caso de rollback
            $table->dropColumn(['listado_dependencia', 'observaciones', 'temporalidad', 'estatus_captura', 'id_nivel_detalle']);
            
            if (Schema::hasColumn('concentrados', 'id_detalle')) {
                $table->renameColumn('id_detalle', 'id_municipio');
            }
        });
    }
};
