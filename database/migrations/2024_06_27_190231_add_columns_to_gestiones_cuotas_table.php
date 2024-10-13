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
        Schema::table('gestiones_cuotas', function (Blueprint $table) {
            $table->string('monto_a_rendir')->nullable();
            $table->string('proforma')->nullable();
            $table->unsignedBigInteger('usuario_rendidor_id')->nullable();
            $table->foreign('usuario_rendidor_id')->references('id')->on('users')->onDelete('cascade');
            $table->date('fecha_rendicion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gestiones_cuotas', function (Blueprint $table) {
            //
        });
    }
};
