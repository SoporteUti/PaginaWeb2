<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSondeosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sondeos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->longtext('descripcion');
            $table->string('imagen');
            $table->bigInteger('user');
            $table->foreign('user')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');            
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
        Schema::dropIfExists('sondeos');
    }
}
