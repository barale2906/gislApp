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
        Schema::create('porcentajes_nomina', function (Blueprint $table) {
            $table->id();

            $table->double('smmlv')->comment('Salario minimo del año');
            $table->double('subsidio_transporte')->comment('subsidio aplicable al año');
            $table->year('anio')->comment('Año en el que aplican estos datos');
            $table->double('porcen_salud')->comment('Porcentaje salud empresa');
            $table->double('porcen_salud_emple')->comment('Porcentaje salud empleado');
            $table->double('porcen_pension')->comment('Porcentaje pension empresa');
            $table->double('porcen_pension_emple')->comment('Porcentaje pension empleado');
            $table->double('porcen_cesantias')->comment('porcentaje cesantias sobre el salario base');
            $table->double('porcen_interesescesantias')->comment('poIntereses Cesantias del pago');
            $table->double('porcen_prima')->comment('porcentaje prima de servicios del mes');
            $table->double('porcen_vacaciones')->comment('Porcentaje de vacaciones sobre el salario base');
            $table->double('porcen_sena')->comment('porcentaje pago SENA');
            $table->double('porcen_icbf')->comment('porcentaje pago ICBF');
            $table->double('porcen_caja')->comment('porcentaje pago caja compensación');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('porcentajes_nomina');
    }
};
