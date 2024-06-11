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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('nombre del producto');
            $table->string('tipo')->default(1)->comment('1 Entrega por evento, 2 Entrega global');
            $table->longText('descripcion')->comment('Datos importantes del producto');
            $table->boolean('status')->default(true)->comment('false Inactivo, true Activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
