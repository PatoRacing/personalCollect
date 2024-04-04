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
            $table->string('fecha_castigo')->nullable();
            $table->string('monto_castigo')->nullable();
            $table->string('acuerdo')->nullable();
            $table->string('sub_producto')->nullable();
            $table->string('compensatorio')->nullable();
            $table->string('punitivos')->nullable();
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
            //
        });
    }
};
