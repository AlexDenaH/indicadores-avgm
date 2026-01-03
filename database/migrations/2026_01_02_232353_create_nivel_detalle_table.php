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
        Schema::create('nivel_detalle', function (Blueprint $table) {
            $table->id();
            // Tipo de detalle (ej. Municipio, Programa, etc.)
            $table->string('tipo');
            // JSON con estructura:
            // [{ "id": 1, "descripcion": "texto" }]
            $table->json('nivel_detalle');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nivel_detalle');
    }
};
