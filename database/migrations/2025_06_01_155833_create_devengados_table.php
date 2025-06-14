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
            $table->double('total_empresa')->comment('Costo para la empresa');
            $table->double('total_empleado')->comment('Total a pagar al empleado');
            $table->year('anio')->comment('Año en el que aplica este pago');
            $table->string('mes')->comment('Mes en el que aplica este pago');
            $table->date('fecha_pago')->nullable()->comment('Fecha de pago');

            $table->double('basico')->comment('Salario base devengado para el mes');
            $table->double('subsidio_transporte')->comment('Subisidio devengado para el mes');
            $table->double('salud_empresa')->comment('pago por salud a pagar a la empresa');
            $table->double('salud_empleado')->comment('pago por salud a pagar al empleado');
            $table->double('pension_empresa')->comment('pago por pension a pagar a la empresa');
            $table->double('pension_empleado')->comment('pago por pension a pagar al empleado');
            $table->double('arl')->comment('Valor a pagar de arl según el riesgo definido en el salario');
            $table->double('cesantias')->comment('Valor a calcular de cesantías sobre el salario base');
            $table->double('interesescesantias')->comment('Intereses Cesantias del pago');
            $table->double('prima')->comment('Valor por prima de servicios del mes');
            $table->double('vacaciones')->comment('Valor a calcular de vacaciones sobre el salario base');
            $table->double('dotaciones')->comment('Valor a provisionar por dotaciones');
            $table->double('sena')->comment('provisión pago SENA');
            $table->double('icbf')->comment('provisión pago ICBF');
            $table->double('caja')->comment('provisión pago caja compensación');

            $table->double('rodamiento')->default(0)->comment('Rodamiento según el cargo');

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
