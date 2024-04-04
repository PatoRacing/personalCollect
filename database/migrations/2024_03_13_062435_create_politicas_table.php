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
        Schema::create('politicas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('producto_id');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
            $table->string('propiedad_politica_uno')->nullable();
            $table->string('valor_propiedad_uno')->nullable();
            $table->string('propiedad_politica_dos')->nullable();
            $table->string('valor_propiedad_dos')->nullable();
            $table->string('propiedad_politica_tres')->nullable();
            $table->string('valor_propiedad_tres')->nullable();
            $table->string('propiedad_politica_cuatro')->nullable();
            $table->string('valor_propiedad_cuatro')->nullable();
            $table->string('valor_quita')->nullable();
            $table->string('valor_cuota')->nullable();
            $table->string('valor_quita_descuento')->nullable();
            $table->string('valor_cuota_descuento')->nullable();
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
        Schema::dropIfExists('politicas');
    }
};
