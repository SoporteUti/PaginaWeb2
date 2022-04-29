<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumsToEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empleado', function (Blueprint $table) {
            $table->bigInteger('id_tipo_jornada');
            $table->bigInteger('id_tipo_contrato');
            $table->foreign('id_tipo_jornada')
            ->references('id')
            ->on('tipo_jornada')
            ->onDelete('cascade');
            $table->foreign('id_tipo_contrato')
            ->references('id')
            ->on('tipo_contrato')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('empleado', function (Blueprint $table) {
            $table->dropColumn('id_tipo_jornada');
            $table->dropColumn('id_tipo_contrato');
        });
    }
}
