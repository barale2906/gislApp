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
        Schema::table('diligencias', function (Blueprint $table) {
            $table->string('pago_mensajero')->nullable()->after('numero_fac')->comment('Registra número de documento con el cuál cobro.');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('diligencias', function (Blueprint $table) {
            $table->dropColumn('pago_mensa');
        });
    }
};
