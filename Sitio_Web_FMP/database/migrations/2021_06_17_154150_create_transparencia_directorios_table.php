<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransparenciaDirectoriosTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transparencia_directorios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('contacto');
            $table->enum('estado', ['activo','inactivo'])->default('activo');
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
        Schema::dropIfExists('transparencia_directorios');
    }
}
