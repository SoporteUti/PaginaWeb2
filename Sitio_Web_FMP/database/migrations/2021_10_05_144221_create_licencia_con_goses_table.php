<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLicenciaConGosesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('licencia_con_goses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('anuales');
            $table->bigInteger('mensuales');
            $table->bigInteger('id_tipo_jornada');
            $table->foreign('id_tipo_jornada')->references('id')->on('tipo_jornada');
            $table->timestamps();
        });
        Schema::table('empleado',function (Blueprint $table) {
            $table->double('salario')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('licencia_con_goses');
    }
}
