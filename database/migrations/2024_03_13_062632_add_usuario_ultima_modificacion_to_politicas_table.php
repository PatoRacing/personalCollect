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
        Schema::table('politicas', function (Blueprint $table) {
            $table->unsignedBigInteger('usuario_ultima_modificacion_id');
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
        Schema::table('politicas', function (Blueprint $table) {
            //
        });
    }
};
