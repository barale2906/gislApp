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
        Schema::create('conceptos', function (Blueprint $table) {
            $table->id();

            $table->string('concepto')->comment('nombre del concepto');
            $table->string('cuenta')->nullable()->comment('cuenta según el PUC');
            $table->boolean('tipo')->default(true)->comment('false debito, true credito');
            $table->boolean('status')->default(true)->comment('false Inactiva, true Activa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conceptos');
    }
};
