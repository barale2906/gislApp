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
        Schema::create('soportes', function (Blueprint $table) {

            $table->comment('Guarda los soportes gnerados por clientes, usuarios o vehiculos');
            $table->id();

            $table->integer('origen')->comment('0 persona, 1 empresa, 2 vehiculo');
            $table->integer('propietario_id')->comment('id del usuario, moto o empresa');
            $table->string('nombre_propietario');
            $table->string('name')->comment('Nombre del documento');
            $table->string('tipo')->comment('ccb, RUT, SOAT, tecno, mantenimiento, licencia, documento, hoja de vida, referencias');
            $table->date('fecha_crea')->nullable()->comment('FEcha de creación del documento');
            $table->date('fecha_vence')->nullable()->comment('fecha de vencimiento del documento');
            $table->string('ruta')->comment('ubicación del soporte');
            $table->boolean('status')->default(true)->comment('false Inactivo, true Activo');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soportes');
    }
};
