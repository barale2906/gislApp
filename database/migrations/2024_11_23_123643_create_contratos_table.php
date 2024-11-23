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
        Schema::create('contratos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('aprobado_id');
            $table->foreign('aprobado_id')->references('id')->on('users');

            $table->string('nombre')->comment('Nombre identificador del documento');
            $table->longText('descripcion')->comment('Detalles del contrato');
            $table->integer('status')->default(1)->comment('0 inactivo, 1 en proceso, 2 Activo');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contratos');
    }
};
