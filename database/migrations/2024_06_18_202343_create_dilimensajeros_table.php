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
        Schema::create('dilimensajeros', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('diligencia_id');
            $table->foreign('diligencia_id')->references('id')->on('diligencias');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->datetime('fecha')->nullable()->comment('fecha en que recoge la dligencia');
            $table->integer('status')->default(1)->comment('1. Asignado, 2 Recogido, 3 entregado, 4 reasignado');
            $table->longText('observaciones')->comment('REgistre lo ocurrido con la asignación');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dilimensajeros');
    }
};
