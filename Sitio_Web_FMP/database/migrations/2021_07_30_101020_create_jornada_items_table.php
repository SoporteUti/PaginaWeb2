<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJornadaItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jornada_items', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('id_jornada')->unsigned();
            $table->foreign('id_jornada')->references('id')->on('jornada');
            $table->string('dia')->nullable();
            $table->string('hora_inicio')->nullable();
            $table->string('hora_fin')->nullable();
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
        Schema::dropIfExists('jornada_items');
    }
}
