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
        Schema::create('importaciones_temporales', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable();;
            $table->string('tipo_doc')->nullable();;
            $table->string('nro_doc');
            $table->string('domicilio')->nullable();;
            $table->string('localidad')->nullable();;
            $table->string('codigo_postal')->nullable();;
            $table->string('telefono')->nullable();;
            $table->string('segmento')->nullable();;
            $table->string('producto')->nullable();;
            $table->string('operacion');
            $table->date('fecha_atraso')->nullable();;
            $table->date('fecha_apertura')->nullable();;
            $table->string('cant_cuotas')->nullable();;
            $table->string('sucursal')->nullable();;
            $table->string('deuda_capital')->nullable();;
            $table->string('deuda_total')->nullable();;
            $table->string('estado')->nullable();;
            $table->date('fecha_asignacion')->nullable();;
            $table->string('ciclo')->nullable();;
            $table->date('fecha_ult_pago')->nullable();;
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
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
        Schema::dropIfExists('importaciones_temporales');
    }
};
