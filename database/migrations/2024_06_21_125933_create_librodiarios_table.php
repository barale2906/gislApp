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
        Schema::create('librodiarios', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('banco_id');
            $table->foreign('banco_id')->references('id')->on('bancos');

            $table->unsignedBigInteger('concepto_id');
            $table->foreign('concepto_id')->references('id')->on('conceptos');

            $table->date('fecha')->comment('Fecha del movimiento');
            $table->double('valor')->comment('valor de la transacción');
            $table->double('saldo')->comment('saldo de la cuenta después del movimiento');
            $table->boolean('tipo')->default(true)->comment('true ingreso de dinero, false sálida de dinero');
            $table->string('comentario')->comment('Detalle del movimiento');
            $table->boolean('status')->default(true)->comment('false Inactiva, true Activa, activo siempre será el último movimiento por banco');
            $table->string('soporte')->nullable()->comment('ruta de carga del soorte respectivo');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('librodiarios');
    }
};
