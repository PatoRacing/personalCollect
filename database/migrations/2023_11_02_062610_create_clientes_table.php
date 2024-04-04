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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('localidad');
            $table->string('codigo_postal');
            $table->string('provincia');
            $table->string('contacto');
            $table->string('telefono');
            $table->string('email');
            $table->integer('estado');
            $table->unsignedBigInteger('usuario_ultima_modificacion_id'); // Agrega esta línea
            $table->timestamp('creado');
            $table->timestamp('fecha_ultima_modificacion');
            $table->foreign('usuario_ultima_modificacion_id')->references('id')->on('users')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
};
