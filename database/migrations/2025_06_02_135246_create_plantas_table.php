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
        Schema::create('plantas', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('salario_id');
            $table->foreign('salario_id')->references('id')->on('salarios');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('contrato_id');
            $table->foreign('contrato_id')->references('id')->on('contratos');

            $table->string('nombre')->comment('nombre del empleado');
            $table->year('anio')->comment('año de aplicación');
            $table->date('inicia')->comment('inicio de la contratación');
            $table->date('finaliza')->nullable()->comment('finaliza contrato');
            $table->longText('observaciones')->comment('observaciones aplicadas');
            $table->integer('status')->default(1)->comment('0 inactivo, 1 Activo');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plantas');
    }
};
