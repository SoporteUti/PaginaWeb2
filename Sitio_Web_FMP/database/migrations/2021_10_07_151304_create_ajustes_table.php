<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAjustesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Illuminate\Support\Facades\Schema::dropIfExists('permisos');

        Illuminate\Support\Facades\Schema::create('permisos', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->id();
            $table->bigInteger('empleado');
            $table->string('tipo_permiso');
            $table->longText('justificacion');
            $table->date('fecha_uso');
            $table->date('fecha_presentacion');
            $table->time('hora_inicio');
            $table->time('hora_final');
            $table->longText('observaciones') -> nullable();
            $table->string('tipo_representante') -> nullable();
            $table->bigInteger('jefatura') -> nullable();
            $table->bigInteger('gestor_rrhh') ->nullable();
            $table->string('olvido') ->nullable();
            $table->string('estado') ->nullable();
            $table->foreign('jefatura')->references('id')->on('empleado');
            $table->foreign('gestor_rrhh')->references('id')->on('empleado');
            $table->foreign('empleado')->references('id')->on('empleado');
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
        Illuminate\Support\Facades\SSchema::dropIfExists('permisos');
    }
}
