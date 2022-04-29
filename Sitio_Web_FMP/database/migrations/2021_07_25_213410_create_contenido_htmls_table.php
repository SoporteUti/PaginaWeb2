<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContenidoHtmlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contenido_htmls', function (Blueprint $table) {
            $table->id();
            $table->longText('contenido');
            $table->string('localizacion');
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
        Schema::dropIfExists('contenido_htmls');
    }
}
