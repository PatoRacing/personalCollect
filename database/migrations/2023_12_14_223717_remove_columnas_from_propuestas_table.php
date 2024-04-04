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
            $table->dropColumn([
                'monto_negociado',
                'honorarios',
                'monto_total',
                'monto_de_quita',
                'monto_a_pagar',
                'monto_a_pagar_en_cuotas',
                'fecha_pago_cancelacion',
                'porcentaje_grupo_uno',
                'porcentaje_grupo_dos',
                'porcentaje_grupo_tres',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('propuesta', function (Blueprint $table) {
            //
        });
    }
};
