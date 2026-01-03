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
            Schema::create('indicadores', function (Blueprint $table) {
                $table->id();
                $table->foreignId('id_programa')->constrained('programas')->onDelete('cascade');
                $table->string('indicador');
                $table->text('descripcion')->nullable();
                $table->string('medicion')->nullable();
                $table->boolean('activo')->default(true);
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indicadores');
    }
};
