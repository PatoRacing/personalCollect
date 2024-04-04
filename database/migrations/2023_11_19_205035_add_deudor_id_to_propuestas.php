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
        Schema::table('propuestas', function (Blueprint $table) {
            $table->unsignedBigInteger('deudor_id');
            $table->foreign('deudor_id')->references('id')->on('deudors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('propuestas', function (Blueprint $table) {
            $table->dropForeign(['deudor_id']);
            $table->dropColumn('deudor_id');
        });
    }
};