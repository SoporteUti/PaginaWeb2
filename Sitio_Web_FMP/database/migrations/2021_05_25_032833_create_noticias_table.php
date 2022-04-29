<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoticiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('noticias', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('subtitulo')   -> nullable();
            $table->longText('contenido') -> nullable();
            $table->string('fuente')      -> nullable();            
            $table->string('urlfuente')   -> nullable();
            $table->string('imagen')      -> nullable();
            $table->boolean('tipo');            
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
        Schema::dropIfExists('noticias');
    }
}
