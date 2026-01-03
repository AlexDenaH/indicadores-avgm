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
Schema::create('concentrados', function (Blueprint $table) {
                $table->id();
                $table->foreignId('id_ejercicio')->constrained('ejercicios')->onDelete('cascade');
                $table->foreignId('id_periodo')->constrained('periodos')->onDelete('cascade');
                $table->foreignId('id_dependencia')->constrained('dependencias')->onDelete('cascade');
                $table->foreignId('id_dep_area')->constrained('dependencia_areas')->onDelete('cascade');
                $table->foreignId('id_municipio')->constrained('municipios')->onDelete('cascade');
                $table->foreignId('id_programa')->constrained('programas')->onDelete('cascade');
                $table->foreignId('id_indicador')->constrained('indicadores')->onDelete('cascade');
                $table->foreignId('id_componente')->constrained('componentes')->onDelete('cascade');
                $table->string('subcomponente')->nullable();
                $table->integer('total')->default(0);
                $table->timestamps();
            });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('concentrados');
    }
};
