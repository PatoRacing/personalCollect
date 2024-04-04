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
        Schema::table('operacions', function (Blueprint $table) {
            Schema::table('operacions', function (Blueprint $table) {
                $table->unsignedBigInteger('usuario_asignado_id')->nullable();
                $table->foreign('usuario_asignado_id')->references('id')->on('users');
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('operacions', function (Blueprint $table) {
            $table->dropForeign(['usuario_asignado_id']);
            $table->dropColumn('usuario_asignado_id');
        });
    }
};
