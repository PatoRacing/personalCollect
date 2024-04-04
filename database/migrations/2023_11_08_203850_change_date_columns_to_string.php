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
            $table->string('fecha_atraso')->change();
            $table->string('fecha_ult_pago')->change();
            $table->string('fecha_asignacion')->change();
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
            $table->date('fecha_atraso')->change();
            $table->date('fecha_ult_pago')->change();
            $table->date('fecha_asignacion')->change();
        });
    }
};
