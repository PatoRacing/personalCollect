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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('acuerdo_id');
            $table->foreign('acuerdo_id')->references('id')->on('acuerdos')->onDelete('cascade');
            $table->string('monto');
            $table->date('vencimiento');
            $table->string('estado');
            $table->string('comprobante')->nullable();
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
        Schema::dropIfExists('pagos');
    }
};
