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
        Schema::create('diligencias', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('ubica_id');
            $table->foreign('ubica_id')->references('id')->on('ubicas');

            $table->unsignedBigInteger('empresa_id');
            $table->foreign('empresa_id')->references('id')->on('empresas');
            $table->boolean('seguimiento')->default(true)->comment('false No se controlan las diligencias por Gisla, true se controlan las diligencias por Gisla, esta dado por el cliente');

            $table->integer('tipo')->default(1)->comment('1 interna, 2 externa, 3 A otras ciudades');
            $table->integer('dest_id')->nullable()->comment('id del usuario de destino interno');
            $table->string('name_dest')->comment('nombre destinatario');
            $table->bigInteger('sucursal_dest_id')->nullable()->comment('Muestra el id de la sucursal del destinatario cuando es interna');
            $table->string('sucursal_dest')->nullable();
            $table->bigInteger('area_dest_id')->nullable()->comment('Muestra el id del área del destinatario cuando es interna');
            $table->string('area_dest')->nullable();
            $table->longText('direccion_dest')->comment('sitio de entrega');

            $table->unsignedBigInteger('ciudad_id');
            $table->foreign('ciudad_id')->references('id')->on('ciudads'); //Ciudad destino

            $table->longText('descripcion')->comment('datos importantes para la entrega');
            $table->longText('detalle')->comment('detalles del contenido del paquete, solo para destinatario');
            $table->date('fecha_recepcion')->nullable()->comment('fecha en que reciben el envío');
            $table->longText('observaciones')->nullable()->comment('anotaciones a la diligencia, uso interna de correspondencia');
            $table->bigInteger('planilla')->nullable()->comment('numero de planilla cuando se hace enrutamiento');
            $table->double('cobro')->nullable()->comment('Se registra el valor recibido del destinatario');
            $table->integer('guias')->nullable()->comment('Cantidad de vueltas registradas para su ejecución');

            $table->integer('status')->default(1)->comment('1 creado, 2 asignado, 3 en proceso, 4 entregada destinatario, 5 ejecutada(cierro yo), 6 cerrada(cierra cliente), 7 legalizada mensajero, 8 Diligencia Cancelada, 9 Devolución, 10 Frecuente');
            $table->integer('status_factura')->default(1)->comment('1 Sin facturar, 2 asignada a factura, 3 facturada, 4 prepagada');
            $table->integer('numero_fac')->nullable()->comment('Numero de factura al que se le asigno');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diligencias');
    }
};
