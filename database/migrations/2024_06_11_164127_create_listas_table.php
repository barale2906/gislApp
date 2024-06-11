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
            $table->string('name')->comment('nombre de la lista');
            $table->date('inicia')->comment('Inicia la vigencia de esta lista');
            $table->date('finaliza')->comment('Finaliza la vigencia');
            $table->longText('descripcion')->comment('Datos importantes de la lista');
            $table->boolean('status')->default(true)->comment('false Inactivo, true Activo');
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
