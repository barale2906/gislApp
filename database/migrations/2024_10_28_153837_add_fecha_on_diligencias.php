<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('diligencias', function (Blueprint $table) {

            $table->date('fecha_entrega')->nullable()->after('detalle')->comment('Fecha de entrega programada.');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('diligencias', function (Blueprint $table) {

            $table->dropColumn('fecha_entrega');
        });
    }
};
