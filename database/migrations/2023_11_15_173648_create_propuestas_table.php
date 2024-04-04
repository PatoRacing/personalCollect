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
        Schema::create('propuestas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_ultima_modificacion_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('operacion_id')->references('id')->on('operacions')->onDelete('cascade');
            $table->string('monto_negociado');
            $table->string('honorarios');
            $table->string('monto_total');
            $table->string('porcentaje_quita')->nullable();
            $table->string('monto_de_quita')->nullable();
            $table->string('total_a_pagar')->nullable();
            $table->string('anticipo')->nullable();
            $table->string('cantidad_de_cuotas_uno')->nullable();
            $table->string('monto_de_cuotas_uno')->nullable();
            $table->string('cantidad_de_cuotas_dos')->nullable();
            $table->string('monto_de_cuotas_dos')->nullable();
            $table->date('vencimiento'); 
            $table->date('accion'); 
            $table->integer('estado');
            $table->string('observaciones'); 
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
        Schema::dropIfExists('propuestas');
    }
};
