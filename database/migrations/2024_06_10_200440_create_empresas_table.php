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
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('nit')->unique()->comment('Número de NIT');
            $table->string('name')->unique()->comment('nombre de la empresa');
            $table->longText('direccion')->nullable()->comment('dirección de la empresa');
            $table->string('telefono')->nullable()->comment('teléfono de la empresa');
            $table->string('contacto')->nullable()->comment('contacto de la empresa');
            $table->string('email')->nullable()->comment('email de contacto');
            $table->string('email_facturacion')->nullable()->comment('email de facturación');
            $table->string('logo')->nullable()->comment('logo de la empresa');
            $table->string('tipo')->default('jurídico')->comment('tipo de empresa natural o jurídica');
            $table->string('metodopago')->default('contado')->comment('Metodo de pago pactado');
            $table->boolean('status')->default(true)->comment('false Inactivo, true Activo');
            $table->boolean('seguimiento')->default(false)->comment('false No se controlan las diligencias por Gisla, true se controlan las diligencias por Gisla');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
