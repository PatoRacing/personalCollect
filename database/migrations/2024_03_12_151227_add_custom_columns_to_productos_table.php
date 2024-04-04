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
        Schema::table('productos', function (Blueprint $table) {
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
            $table->string('valor_quita_cuota')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('productos', function (Blueprint $table) {
            //
        });
    }
};
