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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'rol_id')) {
                $table->foreignId('rol_id')->constrained()->onDelete('cascade');
            }

            if (!Schema::hasColumn('users', 'estado_de_usuario_id')) {
                $table->foreignId('estado_de_usuario_id')->constrained()->onDelete('cascade');
            }

            if (!Schema::hasColumn('users', 'dni')) {
                $table->string('dni');
            }

            if (!Schema::hasColumn('users', 'telefono')) {
                $table->string('telefono');
            }

            if (!Schema::hasColumn('users', 'domicilio')) {
                $table->string('domicilio');
            }

            if (!Schema::hasColumn('users', 'localidad')) {
                $table->string('localidad');
            }

            if (!Schema::hasColumn('users', 'codigo_postal')) {
                $table->string('codigo_postal');
            }

            if (!Schema::hasColumn('users', 'fecha_de_ingreso')) {
                $table->timestamp('fecha_de_ingreso');
            }
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('rol', 'estado_de_usuario', 'dni', 'telefono', 'domicilio',
            'localidad', 'codigo_postal', 'fecha_de_ingreso');
        });
    }
};
