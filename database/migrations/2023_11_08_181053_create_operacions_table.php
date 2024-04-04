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
        Schema::create('operacions', function (Blueprint $table) {
            $table->id();
            $table->string('segmento');
            $table->foreignId('producto_id')->references('id')->on('productos')->onDelete('cascade');
            $table->string('operacion');
            $table->date('fecha_apertura');
            $table->integer('cant_cuotas');
            $table->string('sucursal');
            $table->date('fecha_atraso');
            $table->string('dias_atraso');
            $table->string('deuda_total');
            $table->string('deuda_capital');
            $table->date('fecha_ult_pago');
            $table->string('estado');
            $table->date('fecha_asignacion');
            $table->string('ciclo');
            $table->integer('situacion');
            $table->foreignId('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->foreignId('deudor_id')->references('id')->on('deudors')->onDelete('cascade');
            $table->foreignId('usuario_ultima_modificacion_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('operacions');
    }
};
