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
        Schema::create('gestiones_deudores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deudor_id')->references('id')->on('deudors')->onDelete('cascade');
            $table->foreignId('usuario_ultima_modificacion_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('accion');
            $table->string('resultado');
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
        Schema::dropIfExists('gestiones_deudores');
    }
};
