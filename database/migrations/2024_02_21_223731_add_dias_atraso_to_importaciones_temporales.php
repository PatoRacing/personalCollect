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
        Schema::table('importaciones_temporales', function (Blueprint $table) {
            $table->string('dias_atraso')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('importaciones_temporales', function (Blueprint $table) {
            $table->dropColumn('dias_atraso');
        });
    }
};
