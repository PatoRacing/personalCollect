<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::table('pagos', function (Blueprint $table) {
            
            // Eliminar columnas
            $table->dropColumn([
                'fecha_de_pago',
                'monto_abonado',
                'medio_de_pago',
                'sucursal',
                'hora',
                'cuenta',
                'nombre_tercero',
                'central_de_pago',
                'comprobante',
                'usuario_informador_id',
                'fecha_informe',
                'situacion',
                'monto_a_rendir',
                'monto_honorarios',
                'honorarios',
                'usuario_aplicador_id',
                'fecha_aplicacion',
                'adelanto',
                'fecha_descarga',
                'usuario_descargador_id',
                'fecha_rendicion',
                'rendicion_cg',
                'usuario_rendidor_id',
                'motivo_rendicion',
                'usuario_observador_id',
                'fecha_observacion'
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
        Schema::table('pagos', function (Blueprint $table) {
            //
        });
    }
};
