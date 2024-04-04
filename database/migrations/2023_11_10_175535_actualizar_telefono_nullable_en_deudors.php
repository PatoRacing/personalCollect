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
        Schema::table('deudors', function (Blueprint $table) {
            $table->string('telefono_nuevo')->nullable();
        });
        // Copia los datos de 'telefono' a 'telefono_nuevo'
        DB::table('deudors')->update(['telefono_nuevo' => DB::raw('telefono')]);

        // Elimina la columna 'telefono' antigua
        Schema::table('deudors', function (Blueprint $table) {
            $table->dropColumn('telefono');
        });

        // Renombra la columna 'telefono_nuevo' a 'telefono'
        Schema::table('deudors', function (Blueprint $table) {
            $table->renameColumn('telefono_nuevo', 'telefono');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
