<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos_informados', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_deudor');
            $table->string('dni_deudor');
            $table->date('fecha_de_pago');
            $table->string('monto');
            $table->string('medio_de_pago');
            $table->string('sucursal');
            $table->time('hora')->nullable();
            $table->string('cuenta')->nullable();
            $table->string('nombre_tercero')->nullable();
            $table->string('central_de_pago')->nullable();
            $table->string('comprobante')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('importaciones_pagos_informados');
    }
};
