<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermisosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Illuminate\Support\Facades\Schema::create('permisos', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->id();
            $table->bigInteger('empleado');
            $table->integer('tipo_permiso');
            $table->longText('justificacion');
            $table->integer('horas_utilizar');
            $table->date('fecha_uso');
            $table->date('fecha_presentacio');
            $table->time('hora_inicio');
            $table->time('hora_finalizado');
            $table->longText('observaciones') -> nullable();
            $table->string('estado') -> nullable();
            $table->integer('representantes') -> nullable();
            $table->bigInteger('jefatura') -> nullable();
            $table->bigInteger('gestor_rrhh') ->nullable();
            $table->foreign('jefatura')->references('id')->on('empleado');
            $table->foreign('gestor_rrhh')->references('id')->on('empleado');
            $table->foreign('empleado')->references('id')->on('empleado');                            
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
        Schema::dropIfExists('permisos');
    }
}
