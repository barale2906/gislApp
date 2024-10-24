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
        Schema::create('cuentaspagars', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('concepto_id');
            $table->foreign('concepto_id')->references('id')->on('conceptos');

            $table->string('name')->comment('Nombre de la cuenta por pagar');
            $table->string('beneficiario')->comment('Empresa o persona a quien se le debe pagar.');
            $table->string('documento_beneficiario')->comment('Numero de documento beneficiario');
            $table->string('tipo_documento_beneficiario')->comment('Tipo de documento beneficiario');
            $table->double('valor_pagar')->comment('Valor total a pagar de la cuenta');
            $table->double('saldo')->comment('Saldo de la obligación');
            $table->integer('frecuencia')->comment('1 mensual, 2 anual, 3 bimestral');
            $table->date('fecha_ultimo_pago')->comment('Registro del último pago');
            $table->date('vencimiento')->comment('cuando se debe pagar la obligación');
            $table->longText('observaciones')->comment('Detalles de la obligación y su historia');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuentaspagars');
    }
};
