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
        Schema::create('inasistencias', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->longtext('nombre')->comment('Nombre empleado');
            $table->date('inicia')->comment('Inicia la inasistencia');
            $table->date('finaliza')->comment('Finaliza la inasistencia');
            $table->double('dias')->comment('Días de inasistencia');
            $table->integer('motivo')->default(0)->comment('0 cita médica, 1 cita familiar, 2 Incapacidad, 3 evadido, 4 Vacaciones, 5 Capacitación');
            $table->integer('justificada')->default(0)->comment('0 Injustificada, 1 Justificada');
            $table->longText('soporte')->nullable()->comment('Ruta con el soporte de la inasistencia');
            $table->longText('aprobo')->nullable()->comment('Nombre del funcionario que aprobo la incapacidad');
            $table->integer('status')->default(0)->comment('0 sin aplicar 1 aplicado');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inasistencias');
    }
};
