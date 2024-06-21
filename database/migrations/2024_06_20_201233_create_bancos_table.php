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
        Schema::create('bancos', function (Blueprint $table) {
            $table->id();

            $table->string('nombre')->comment('nombre de la cuenta');
            $table->string('banco')->comment('Banco al que pertenece la cuenta');
            $table->string('numero')->comment('numero de la cuenta');
            $table->string('tipo')->comment('tipo Ahorros o Corriente o Daviplata o Nequi...');
            $table->boolean('status')->default(true)->comment('false Inactiva, true Activa');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bancos');
    }
};
