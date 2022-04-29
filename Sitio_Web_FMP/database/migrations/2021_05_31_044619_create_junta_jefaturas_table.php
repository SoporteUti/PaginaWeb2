<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJuntaJefaturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('junta_jefaturas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('sector_dep_unid');
            $table->integer('tipo');
            $table->bigInteger('user');
            $table->timestamps();
            $table->foreign('user')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('junta_jefaturas');
    }
}
