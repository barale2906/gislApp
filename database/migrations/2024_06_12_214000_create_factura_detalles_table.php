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
        Schema::create('factura_detalles', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('factura_id');
            $table->foreign('factura_id')->references('id')->on('facturas');

            $table->integer('diligencia')->nullable()->comment('Diligencia facturada');
            $table->integer('producto_id')->nullable()->comment('id del producto seleccionado');
            $table->string('concepto')->comment('item facturado');
            $table->double('cantidad')->comment('unidades');
            $table->double('unitario')->comment('precio total unitario');
            $table->double('total')->comment('total por item');
            $table->double('descuento')->default(0)->comment('descuento unitario');
            $table->double('descuento_total')->default(0)->comment('descuento total');
            $table->longText('observaciones')->comment('Anotaciones importantes');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factura_detalles');
    }
};
