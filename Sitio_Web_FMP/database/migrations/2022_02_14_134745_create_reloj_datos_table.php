<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelojDatosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reloj_datos', function (Blueprint $table) {
            $table->id();
            $table->string('indice')->nullable();
            $table->string('id_persona')->nullable();
            $table->string('nombre_personal')->nullable();
            $table->string('departamento')->nullable();
            $table->string('posicion')->nullable();
            $table->string('genero')->nullable();
            $table->string('fecha')->nullable();
            $table->string('dia_semana')->nullable();
            $table->string('horario')->nullable();
            $table->string('entrada')->nullable();
            $table->string('salida')->nullable();
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
        Schema::dropIfExists('reloj_datos');
    }
}
