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
        Schema::create('gestiones_cuotas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pago_id');
            $table->foreign('pago_id')->references('id')->on('pagos')->onDelete('cascade');
            $table->date('fecha_de_pago');
            $table->string('monto_abonado');
            $table->string('medio_de_pago');
            $table->string('sucursal')->nullable();;
            $table->time('hora')->nullable();;
            $table->string('cuenta')->nullable();;
            $table->string('nombre_tercero')->nullable();
            $table->string('central_de_pago')->nullable();
            $table->string('comprobante')->nullable();
            $table->unsignedBigInteger('usuario_informador_id')->nullable();
            $table->foreign('usuario_informador_id')->references('id')->on('users')->onDelete('cascade');
            $table->date('fecha_informe');
            $table->integer('situacion');
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
        Schema::dropIfExists('gestiones_cuotas');
    }
};
