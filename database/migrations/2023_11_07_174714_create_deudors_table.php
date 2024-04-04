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
        Schema::create('deudors', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('tipo_doc');
            $table->string('nro_doc');
            $table->string('domicilio');
            $table->string('localidad');
            $table->string('codigo_postal');
            $table->string('telefono');
            $table->foreignId('usuario_ultima_modificacion_id')->references('id')->on('users')->onDelete('cascade');;
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
        Schema::dropIfExists('deudors');
    }
};
