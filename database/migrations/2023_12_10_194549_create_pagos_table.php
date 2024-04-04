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
            $table->string('concepto');
            $table->string('monto');
            $table->date('vencimiento');
            $table->integer('estado');
            $table->string('comprobante'); 
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
