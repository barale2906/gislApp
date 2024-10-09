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
        Schema::table('conceptos', function (Blueprint $table) {
            $table->integer('accion')->default(1)->after('tipo')->comment('Verifica paso a seguir según el concepto seleccionado, 1 no pasa nada');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('conceptos', function (Blueprint $table) {
            $table->dropColumn('accion');
        });
    }
};
