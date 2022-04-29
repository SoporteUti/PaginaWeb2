<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriodosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periodos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('ciclo_id');
            $table->foreign('ciclo_id')->references('id')->on('ciclos');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->string('tipo');
            $table->text('observaciones')->nullable();
            $table->enum('estado',['activo','inactivo','finalizado'])->default('activo');
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
        Schema::dropIfExists('periodos');
    }
}
