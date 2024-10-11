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
        Schema::create('carteras', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('factura_id');
            $table->foreign('factura_id')->references('id')->on('facturas');

            $table->string('cliente')->comment('Nombre de la empresa');
            $table->string('nit')->comment('NIT del cliente');

            $table->double('total')->comments('total de la factura');
            $table->double('descuento')->comments('descuento aplicado a la factura');
            $table->double('saldo')->default(0)->comments('saldo pendiente de la factura');
            $table->double('impuestos')->default(0)->comments('Total de impuestos retenidos');

            $table->longText('comentarios')->comment('Historial de registros');
            $table->integer('status')->default(1)->comment('1 Activa, 2 Abonada, 3 Cancelada, 4 Anulada');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carteras');
    }
};
