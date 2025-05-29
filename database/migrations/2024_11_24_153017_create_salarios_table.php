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
        Schema::create('salarios', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('contrato_id');
            $table->foreign('contrato_id')->references('id')->on('contratos');

            $table->double('basico')->comment('Salario base a pagar');
            $table->double('subsidio_transporte')->comment('Subisidio aplicable');
            $table->double('rodamiento')->default(0)->comment('Rodamiento según el cargo');
            $table->double('salud')->comment('Valor a calcular de salud sobre el salario base');
            $table->double('pension')->comment('Valor a calcular de pensión sobre el salario base');
            $table->double('arl')->comment('Valor a calcular de arl según el riesgo');
            $table->double('cesantías')->comment('Valor a calcular de cesantías sobre el salario base');
            $table->double('vacaciones')->comment('Valor a calcular de vacaciones sobre el salario base');
            $table->double('dotaciones')->comment('Valor a provisionar por dotaciones');
            $table->year('anio')->comment('Año en el que aplica este salario');
            $table->longText('observaciones')->comment('anotaciones a la adición');
            $table->integer('status')->default(1)->comment('0 Inactivo, 1 En proceso, 2 Activo');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salarios');
    }
};
