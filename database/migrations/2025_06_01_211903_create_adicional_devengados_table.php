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
        Schema::create('adicional_devengados', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('adicional_id');
            $table->foreign('adicional_id')->references('id')->on('adicionales');

            $table->unsignedBigInteger('devengado_id');
            $table->foreign('devengado_id')->references('id')->on('devengados');

            $table->double('unitario')->comment('Costo unitario del adicional');
            $table->double('cantidad')->comment('Numero de veces que se carga el adicional');
            $table->double('total')->comment('valor del adicional');
            $table->longText('detalle')->comment('comentarios al adicional');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adicional_devengados');
    }
};
