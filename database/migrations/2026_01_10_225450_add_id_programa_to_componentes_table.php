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
        Schema::table('componentes', function (Blueprint $table) {
            if (!Schema::hasColumn('componentes', 'id_programa')) {
                $table->foreignId('id_programa')
                    ->after('id')
                    ->constrained('programas')
                    ->cascadeOnUpdate();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('componentes', function (Blueprint $table) {
            //
            $table->dropColumn('id_programa');
        });
    }
};
