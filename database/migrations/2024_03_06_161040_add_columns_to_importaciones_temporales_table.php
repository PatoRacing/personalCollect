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
            $table->string('cuil')->nullable();
            $table->string('email')->nullable();
            $table->string('telefono_uno')->nullable();
            $table->string('telefono_dos')->nullable();
            $table->string('telefono_tres')->nullable();
            $table->date('fecha_castigo')->nullable();
            $table->decimal('monto_castigo')->nullable();
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
        Schema::table('importaciones_temporales', function (Blueprint $table) {
            //
        });
    }
};
