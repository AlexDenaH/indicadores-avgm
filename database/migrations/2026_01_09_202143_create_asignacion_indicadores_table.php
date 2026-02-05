<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.cls
     */
    public function up(): void
    {
        Schema::create('asignacion_indicadores', function (Blueprint $table) {
            $table->id();

            // Relaciones principalescls
            $table->unsignedBigInteger('id_ejercicio');
            $table->unsignedBigInteger('id_programa');
            $table->unsignedBigInteger('id_area');

            /**
             * JSON de enteros:
             * Ejemplo: [1,5,8,10]
             * Representa los IDs de indicadores asignados
             */
            $table->json('indicadores');

            $table->timestamps();

            // Evita duplicidad de asignaciones por área / ejercicio / programa
            $table->unique(['id_ejercicio', 'id_programa', 'id_area'], 'asignacion_unique');

            // Foreign keys
            $table->foreign('id_ejercicio')
                ->references('id')
                ->on('ejercicios')
                ->cascadeOnDelete();

            $table->foreign('id_programa')
                ->references('id')
                ->on('programas')
                ->cascadeOnDelete();

            $table->foreign('id_area')
                ->references('id')
                ->on('dependencia_areas') // 👈 AQUÍ
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignacion_indicadores');
    }
};
