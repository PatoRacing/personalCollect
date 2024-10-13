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
        Schema::table('pagos', function (Blueprint $table) {
            // Agregar columnas
            $table->date('fecha_de_pago')->nullable();
            $table->string('monto_abonado')->nullable();
            $table->string('medio_de_pago')->nullable();
            $table->string('sucursal')->nullable();
            $table->time('hora')->nullable();
            $table->string('cuenta')->nullable();
            $table->string('nombre_tercero')->nullable();
            $table->string('central_de_pago')->nullable();
            $table->unsignedBigInteger('usuario_informador_id')->nullable();
            $table->date('fecha_informe')->nullable();
            $table->string('monto_a_rendir')->nullable();
            $table->string('monto_honorarios')->nullable();
            $table->string('honorarios')->nullable();
            $table->unsignedBigInteger('usuario_aplicador_id')->nullable();
            $table->date('fecha_aplicacion')->nullable();
            $table->string('adelanto')->nullable();
            $table->date('fecha_descarga')->nullable();
            $table->unsignedBigInteger('usuario_descargador')->nullable();
            $table->date('fecha_rendicion')->nullable();
            $table->string('rendicion_cg')->nullable();
            $table->unsignedBigInteger('usuario_rendidor_id')->nullable();
            $table->string('motivo_rendicion')->nullable();
            $table->unsignedBigInteger('usuario_observador_id')->nullable();
            $table->date('fecha_observacion')->nullable();

            $table->foreign('usuario_informador_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('usuario_aplicador_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('usuario_descargador')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('usuario_rendidor_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('usuario_observador_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pagos', function (Blueprint $table) {
            //
        });
    }
};
