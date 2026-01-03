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
        Schema::create('dependencia_areas', function (Blueprint $table) {
            $table->id(); // ID autoincremental primario
            
            // Relación con la tabla dependencias
            // Se asume que la tabla se llama 'dependencias' y el ID es un bigInteger
            $table->foreignId('id_dependencia')
                ->constrained('dependencias')
                ->onDelete('cascade');

            $table->string('unidad_area');
            $table->boolean('activa')->default(true); // Campo booleano para el estado
            
            $table->timestamps(); // Crea created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dependencia_areas');
    }
};
