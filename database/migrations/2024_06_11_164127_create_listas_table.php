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
        Schema::create('listas', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->comment('nombre de la lista');
            $table->date('inicia')->comment('Inicia la vigencia de esta lista');
            $table->date('finaliza')->comment('Finaliza la vigencia');
            $table->longText('descripcion')->comment('Datos importantes de la lista');
            $table->integer('status')->default(1)->comment('0 obsoleta, 1 proceso, 2 aprobada, 3 vigente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listas');
    }
};
