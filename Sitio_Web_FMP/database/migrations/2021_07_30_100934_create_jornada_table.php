<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJornadaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jornada', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('id_emp');
            $table->foreign('id_emp')->references('id')->on('empleado');
            $table->integer('id_periodo')->unsigned();
            $table->foreign('id_periodo')->references('id')->on('periodos');
            $table->string('procedimiento')->default('guardado');
            $table->text('observaciones')->nullable();
            $table->enum('estado',['activo','inactivo'])->default('activo');
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
        Schema::dropIfExists('jornada');
    }
}
