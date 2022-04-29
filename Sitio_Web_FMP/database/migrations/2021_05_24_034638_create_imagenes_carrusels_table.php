<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagenesCarruselsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imagenes_carrusels', function (Blueprint $table) {
            $table->id();
            $table->string('imagen');            
            $table->bigInteger('user');
            $table->bigInteger('tipo');
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
        Schema::dropIfExists('imagenes_carrusels');
    }
}
