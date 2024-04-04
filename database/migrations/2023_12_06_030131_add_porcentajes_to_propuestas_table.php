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
            Schema::table('propuestas', function (Blueprint $table) {

                $table->string('porcentaje_grupo_uno')->nullable();
                $table->string('porcentaje_grupo_dos')->nullable();
                $table->string('porcentaje_grupo_tres')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('propuestas', function (Blueprint $table) {
            Schema::table('propuestas', function (Blueprint $table) {
            $table->dropColumn('porcentaje_grupo_uno');
            $table->dropColumn('porcentaje_grupo_dos');
            $table->dropColumn('porcentaje_grupo_tres');
        });
        });
    }
};
