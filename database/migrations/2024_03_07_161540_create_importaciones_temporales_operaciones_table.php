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
        Schema::create('importaciones_temporales_operaciones', function (Blueprint $table) {
            $table->id();
            $table->string('segmento')->nullable();
            $table->string('producto')->nullable();
            $table->string('operacion')->nullable();
            $table->string('nro_doc')->nullable();
            $table->string('fecha_apertura')->nullable();
            $table->string('cant_cuotas')->nullable();
            $table->string('sucursal')->nullable();
            $table->string('fecha_atraso')->nullable();
            $table->string('dias_atraso')->nullable();
            $table->string('fecha_castigo')->nullable();
            $table->string('deuda_total')->nullable();
            $table->string('monto_castigo')->nullable();
            $table->string('deuda_capital')->nullable();
            $table->string('fecha_ult_pago')->nullable();
            $table->string('estado')->nullable();
            $table->string('fecha_asignacion')->nullable();
            $table->string('ciclo')->nullable();
            $table->string('acuerdo')->nullable();
            $table->string('sub_producto')->nullable();
            $table->string('compensatorio')->nullable();
            $table->string('punitivos')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('importaciones_temporales_operaciones');
    }
};
