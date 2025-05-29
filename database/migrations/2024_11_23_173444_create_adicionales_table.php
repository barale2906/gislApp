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
        Schema::create('adicionales', function (Blueprint $table) {
            $table->id();

            $table->string('nombre')->comment('Nombre identificador del documento');
            $table->longText('descripcion')->comment('Detalles del adicional');
            $table->integer('aplica')->default(0)->comment('0 Básico, 1 Hora');
            $table->integer('crt_base')->default(0)->comment('0 Básico, 2 Básico + subsidio transporte');
            $table->double('valor_tra')->comment('Porcentaje o valor final del adicional sobre la base');
            $table->integer('tipo_tra')->default(0)->comment('0 Directo, 1 Porcentaje');
            $table->integer('responsable')->default(0)->comment('0 empleado, 1 Empresa, 2 Los dos');
            $table->double('valor_emp')->comment('Porcentaje o valor final del adicional sobre la base para la empresa');
            $table->integer('tipo_emp')->default(0)->comment('0 Directo, 1 Porcentaje para la empresa');
            $table->integer('status')->default(1)->comment('0 Inactivo, 1 En proceso, 2 Activo');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adicionales');
    }
};
