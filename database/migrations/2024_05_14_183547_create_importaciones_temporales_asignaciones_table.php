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
        Schema::create('importaciones_temporales_asignaciones', function (Blueprint $table) {
            $table->id(); 
            $table->string('operacion'); 
            $table->unsignedBigInteger('cliente_id'); 
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->unsignedBigInteger('agente_asignado_id'); 
            $table->foreign('agente_asignado_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('importaciones_temporales_asignaciones');
    }
};
