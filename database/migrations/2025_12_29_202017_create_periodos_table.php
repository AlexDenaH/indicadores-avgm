<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('periodos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_ejercicio')->constrained('ejercicios')->onDelete('cascade');
            $table->foreignId('id_programa')->constrained('programas')->onDelete('cascade');
            $table->foreignId('id_indicador')->constrained('indicadores')->onDelete('cascade');
            $table->enum('periodo',['diario','semanal','mensual','trimestral','semestral','anual']);
            $table->integer('dias_inicio');
            $table->integer('dias_final')->nullable();
            $table->boolean('status')->default(false); // activo/inactivo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periodos');
    }
};
