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
        Schema::create('origen_soportes', function (Blueprint $table) {

            $table->comment('Soportes según el tipo de propietario');
            $table->id();

            $table->integer('origen')->comment('0 persona, 1 empresa, 2 vehiculo');
            $table->string('name')->comment('Nombre del tipo de soporte');
            $table->boolean('status')->default(true)->comment('false Inactivo, true Activo');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('origen_soportes');
    }
};
