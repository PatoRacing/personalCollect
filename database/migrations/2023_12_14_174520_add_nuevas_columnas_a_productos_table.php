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
            $table->string('monto_minimo');
            $table->string('monto_maximo');
            $table->string('porcentaje_uno');
            $table->string('porcentaje_dos');
            $table->string('porcentaje_tres');
            $table->string('porcentaje_cuatro');
            $table->string('cuotas_uno');
            $table->string('cuotas_dos');
            $table->string('cuotas_tres');
            $table->string('cuotas_cuatro');
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
            $table->dropColumn([
                'monto_minimo',
                'monto_maximo',
                'porcentaje_uno',
                'porcentaje_dos',
                'porcentaje_tres',
                'porcentaje_cuatro',
                'cuotas_uno',
                'cuotas_dos',
                'cuotas_tres',
                'cuotas_cuatro',
            ]);
        });
    }
};
