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
        Schema::create('devengados', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('salario_id');
            $table->foreign('salario_id')->references('id')->on('salarios');

            $table->longText('nombre')->comment('Nombre empleado');
            $table->double('dias')->comment('Días laborados');
            $table->double('costo_empresa')->comment('Costo para la empresa');
            $table->double('total_empleado')->comment('Total a pagar al empleado');
            $table->year('anio')->comment('Año en el que aplica este pago');
            $table->string('mes')->comment('Mes en el que aplica este pago');
            $table->date('fecha_pago')->nullable()->comment('Fecha de pago');
            $table->double('seguridad_social_empresa')->comment('Seguridad social a pagar a la empresa');
            $table->double('seguridad_social_empleado')->comment('Seguridad social a pagar al empleado');
            $table->double('provisiones')->comment('Dinero a provisionar según itemes calculados, vacaciones, primas, cesantías, vacaciones');
            $table->longText('soporte_pago')->nullable()->comment('Ruta del sosporte');
            $table->bigInteger('movimiento_banco')->nullable()->comment('id del movimiento bancario con el que se hizo el pago');
            $table->string('calculo')->comment('nombre del usuario que calculo');
            $table->longText('observaciones')->comment('Registro de observaciones');
            $table->integer('status')->default(0)->comment('0 Calculando, 1 Pagado');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devengados');
    }
};
