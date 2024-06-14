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
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('lista_id');
            $table->foreign('lista_id')->references('id')->on('listas');

            $table->unsignedBigInteger('empresa_id');
            $table->foreign('empresa_id')->references('id')->on('empresas');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->integer('numero')->nullable()->comment('numero de factura según la DIAN');
            $table->date('fecha')->comment('Fecha de facturación');
            $table->date('vencimiento')->comment('Fecha de vencimiento');
            $table->string('empresa')->comment('nombre de la empresa a quien se le factura');
            $table->double('total')->comments('total de la factura');
            $table->double('descuento')->comment('total descuento aplicado');
            $table->longText('observaciones')->nullable()->comment('info a tener en cuenta');
            $table->longText('ruta')->nullable()->comment('ruta del archivo con la factura');
            $table->integer('status')->default(3)->comment('1 anulada, 2 pagada 3 proceso, 4 enviada');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};
