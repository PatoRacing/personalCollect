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
        Schema::create('acuerdos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('propuesta_id');
            $table->foreign('propuesta_id')->references('id')->on('propuestas')->onDelete('cascade');
            $table->unsignedBigInteger('usuario_ultima_modificacion_id');
            $table->foreign('usuario_ultima_modificacion_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('acuerdos');
    }
};
