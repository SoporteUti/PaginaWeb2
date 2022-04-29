<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCargaAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carga_admins', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_carga');
            $table->boolean('estado')->default(true);
            $table->string('categoria');
            $table->bigInteger('id_jefe')->unsigned()->nullable();

            $table->foreign('id_jefe')
            ->references('id')
            ->on('empleado')
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
        Schema::dropIfExists('carga_admins');
    }
}
